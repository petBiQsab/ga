import { utils, writeFile } from "xlsx";

export const handleExport = (
    columns: {
        key: string;
        title: string;
    }[],
    data: {
        [key: string]: string | number | null;
    }[],
    type: "csv" | "xlsx" = "xlsx",
    fileName?: string,
    separator = ";"
) => {
    const headerRow = columns.map((header) => header.title);
    const bodyRows = data.map((item) =>
        columns.map((header) =>
            String(item[header.key as keyof typeof item] ?? "")
        )
    );
    const array = [headerRow, ...bodyRows];
    const date = new Date().toLocaleDateString().replaceAll("/", "-");
    const name = fileName ?? `${date}_export`;
    // Create and download file
    if (type === "csv") {
        const csv = arrayToCsv(array, separator);
        if (!csv) {
            throw new Error(
                "Unable to create CSV. Please check if data is valid and if provided separator is correct"
            );
        }
        const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
        const url = URL.createObjectURL(blob);
        // Create link to download the file
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", `${name}.csv`);
        link.click();
    } else {
        const worksheet = utils.aoa_to_sheet(array);
        const workbook = utils.book_new();
        utils.book_append_sheet(workbook, worksheet, name);
        writeFile(workbook, `${name}.xlsx`);
    }
};
// CSV from array
function arrayToCsv(data: string[][], separator: string) {
    // Check if data is valid
    if (!Array.isArray(data)) {
        throw new Error(`data has to be typeof: ${typeof []}`);
    }
    // Check if separator is a valid character
    if (!/^[^\n"]$/.test(separator)) {
        throw new Error(
            "Separator must be single character and cannot be a newline or double quotes"
        );
    }
    // Check if data is not empty
    if (Array.isArray(data[0])) {
        let csv = "";
        // Loop through each row
        data.forEach((row) => {
            row.forEach((value, index) => {
                const rowValue = value ?? "";
                csv += appendElement(rowValue, row.length, index, separator);
            });
        });
        return csv;
    }
}
// Append element to CSV
const appendElement = (
    element: string | number | null,
    lineLength: number,
    elementIndex: number,
    separator: string
) => {
    const includesSpecials = checkSpecialChars(element, separator);
    let isElement = element;
    // Element icludes special characters
    if (includesSpecials) {
        isElement = String(isElement)?.replace(/"/g, '""');
    }
    // Set element or rows separator
    const afterElement = lineLength - 1 === elementIndex ? "\n" : separator;
    return includesSpecials
        ? `"${isElement}"${afterElement}`
        : `${isElement}${afterElement}`;
};
// Check if element includes special characters
const checkSpecialChars = (
    value: string | number | null,
    separator: string
) => {
    // Check if element is valid
    const symbols = '\\n"';
    const isValue = value ? value.toString().toLowerCase() : "";
    if (typeof value === "string") {
        let regexp = symbols;
        if (
            typeof separator !== "undefined" &&
            separator !== null &&
            !symbols.includes(separator)
        ) {
            regexp += separator;
        }
        return isValue.length === 0 || new RegExp(`[${regexp}]`).test(isValue);
    } else {
        return false;
    }
};
