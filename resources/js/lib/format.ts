export const highlightString = (value: string | number, search: string) => {
    const string = typeof value === "number" ? String(value) : value;
    const stringIndex = string.toLowerCase().indexOf(search);
    if (search.length > 0 && stringIndex !== -1) {
        const highlightedText = string.substring(
            stringIndex,
            stringIndex + search.length
        );
        return string.replace(
            highlightedText,
            `<span style="color: #c5362e;">${highlightedText}</span>`
        );
    } else {
        return string;
    }
};

type DateType = "d.m.Y" | "m.Y" | "d.m.Y H:M"; // Added time option
export const formatDate = (date: string, type: DateType) => {
    if (date === null || date === undefined) {
        return "";
    } else {
        const isShort = type === "m.Y";
        const hasTime = type === "d.m.Y H:M"; // Check if time is required

        const options: Intl.DateTimeFormatOptions = {
            month: isShort ? "long" : "numeric",
            year: "numeric",
            ...(!isShort && { day: "numeric" }),
            ...(hasTime && {
                hour: "2-digit",
                minute: "2-digit",
                timeZone: "Europe/Bratislava", // Set the desired time zone (for Slovakia)
            }),
        };

        // If time is required, use toLocaleTimeString for time formatting only
        if (hasTime) {
            return capitalizeFirstLetter(
                new Date(date).toLocaleTimeString("sk-SK", options)
            );
        } else {
            // Otherwise, use toLocaleDateString for the date formatting
            return capitalizeFirstLetter(
                new Date(date).toLocaleDateString("sk-SK", options)
            );
        }
    }
};

// Helper function to capitalize the first letter
function capitalizeFirstLetter(str: string): string {
    return str.charAt(0).toUpperCase() + str.slice(1);
}



export const formatCurrency = (
    value: string | number | null,
    maximumFractionDigits = 2
) => {
    if (value === null || value === undefined) {
        return "";
    } else {
        const number = Number(value);
        if (Number.isNaN(number)) {
            return "";
        } else {
            return number.toLocaleString("sk-SK", {
                style: "currency",
                currency: "EUR",
                maximumFractionDigits,
            });
        }
    }
};

export const formatCurrencyPercent = (
    value: string | number | null,
) => {
    if (value === null || value === undefined) {
        return "";
    } else {
        const number = Number(value);
        if (Number.isNaN(number)) {
            return "";
        } else {
            return number + " %";
        }
    }
};

export const capitalize = (string?: string) => {
    if (string) {
        if (string.includes(" ") || string.includes("-")) {
            const stringArray = string.includes(" ")
                ? string.split(" ")
                : string.split("-");
            return stringArray
                .map((s) => s[0].toUpperCase() + s.slice(1))
                .join(" ");
        } else {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    } else {
        return "";
    }
};

export const keyify = (
    obj: {
        [key: string]: any;
    },
    prefix = "",
    includeValues = false,
    sort = true
) =>
    Object.keys(obj).reduce<string[]>((keys, nextKey): string[] => {
        const key = `${prefix}${nextKey}`;
        if (Array.isArray(obj[nextKey])) {
            // If another object in array, recurse
            if (
                typeof obj[nextKey][0] === "object" &&
                obj[nextKey][0] !== null
            ) {
                return [...keys, ...keyify(obj[nextKey][0], key)];
            }
            return [
                ...keys,
                includeValues
                    ? `${nextKey}: ${obj[nextKey].toString()}`
                    : nextKey,
            ];
        } else if (typeof obj[nextKey] === "object" && obj[nextKey] !== null) {
            return [...keys, ...keyify(obj[nextKey], key)];
        }
        const keyified = [
            ...keys,
            includeValues
                ? `${prefix}${nextKey}: ${obj[nextKey]}`
                : `${prefix}${nextKey}`,
        ];
        return sort
            ? keyified.sort((a, b) => a.localeCompare(b, "sk"))
            : keyified;
    }, []);
