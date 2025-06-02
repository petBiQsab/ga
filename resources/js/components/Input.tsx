import {
    type ChangeEvent,
    type CSSProperties,
    type FormEvent,
    useEffect,
    type WheelEvent,
} from "react";
// Assets
import { isListField } from "./detail/assets";
type InputProps = {
    name: string;
    label?: string;
    value?: string | number | null;
    setValue?: (value: string | number) => void;
    required?: boolean;
    disabled?: boolean;
    multiline?: boolean;
    type?: "text" | "number" | "email" | "password" | "date" | "month";
    colorScheme?: "dark" | "light";
    pattern?: string;
    autocomplete?: boolean;
    numberAttributes?: {
        min?: number;
        max?: number;
        step?: number;
    };
    dateAttributes?: {
        min?: string;
        max?: string;
    };
    isYearsInput?: boolean;
    isInvalid?: boolean;
    styles?: CSSProperties;
};

export const Input = ({
    name,
    label,
    value,
    setValue,
    required,
    disabled,
    multiline,
    type = "text",
    colorScheme = "light",
    pattern,
    autocomplete = true,
    numberAttributes = {
        min: 0,
    },
    dateAttributes,
    isYearsInput = false,
    isInvalid,
    styles,
}: InputProps) => {
    const isList = isListField(name);
    useEffect(() => {
        if (multiline) {
            const element = document.getElementsByName(name)[0];
            if (element) {
                // Resize textarea to fit content
                element.style.height = "auto";
                element.style.height = `${element.scrollHeight + 4}px`; // Add 4px to prevent scroll
            }
        }
    }, [isList, multiline, value]);
    const isNumber = type === "number";
    // TODO - add hyphen separated new lines
    const onChange = (
        e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement>
    ) => {
        const dataInvalid =
            e.currentTarget.getAttribute("data-invalid") === "true";
        if (dataInvalid) {
            e.currentTarget.setAttribute("data-invalid", "false");
            e.currentTarget.setCustomValidity("");
        }
        if (setValue) {
            const { value } = e.target;
            const newValue = isNumber
                ? Number(value)
                : isList
                ? value.startsWith("-")
                    ? value
                          .split("\n")
                          .filter((row) => row !== "-")
                          .map((row) => row.slice(2))
                          .join("\n")
                    : value
                : type === "month"
                ? value.length
                    ? `${value}-01`
                    : ""
                : value;
            setValue(newValue);
        }
    };
    const onInvalid = (
        e: FormEvent<HTMLInputElement> | FormEvent<HTMLTextAreaElement>
    ) => {
        e.currentTarget.setAttribute("data-invalid", "true");
        e.currentTarget.setCustomValidity(" ");
    };
    const isCurrencySuffix = isNumber && !["id_pp", "max_rok"].includes(name);
    const isCurrencyPercentSuffix = name === "podiel_externeho_financovania_z_celkovej_ceny";
    const InputComponent = multiline ? "textarea" : "input";
    const inputProps = {
        name,
        ...(value === undefined
            ? { defaultValue: "" }
            : {
                  value: value
                      ? isList
                          ? (value as string)
                                .split("\n")
                                .map((row) => `- ${row.trimStart()}`)
                                .join("\n")
                          : value
                      : "",
              }),
        onChange,
        onInvalid,
        required,
        disabled,
        placeholder: " ",
        ...(!multiline && { type }),
        ...(pattern && { pattern }),
        autoComplete: autocomplete ? "on" : "off",
        ...(isNumber && {
            ...numberAttributes,
            // Prevent updating value on scroll
            onWheel: (e: WheelEvent<HTMLInputElement | HTMLTextAreaElement>) =>
                e.currentTarget.blur(),
        }),
        ...(["date", "month"].includes(type) && dateAttributes),
        ...(isInvalid && {
            "data-invalid": true,
        }),
        style: {
            ...((isCurrencySuffix || isCurrencyPercentSuffix) &&
                ({
                    textAlign: "right",
                    paddingRight: isCurrencyPercentSuffix ? "1.75rem" : "1.5rem",
                } as CSSProperties)),
            ...(isYearsInput && {
                paddingRight: "1.5rem",
                borderTopRightRadius: 0,
                borderRight: 0,
                borderBottom: 0,
                borderTopLeftRadius: 0,
                borderLeft: 0,
            }),
            ...(styles && { ...styles }),
        },
    };
    return (
        <fieldset style={styles}>
            <InputComponent {...inputProps} />
            {label && (
                <label data-color-scheme={colorScheme}>
                    {label}
                    {required && " *"}
                </label>
            )}
            {isCurrencySuffix && (
                <span
                    style={{
                        right: "0.75rem",
                        ...(disabled && {
                            color: "#888",
                        }),
                    }}
                >
                    {isCurrencyPercentSuffix ? "%" : "€"}
                </span>
            )}
        </fieldset>
    );
};
