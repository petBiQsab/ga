import {
    formatCurrency,
    formatDate,
    highlightString,
} from "../../../../lib/format";
import { currencyFields } from "../assets";
import { a_mtlColors } from "../../../../lib/data";
// Types
import { Column } from "../..";
import { PracoviskoProps } from "../../../../src/types";
import { Row } from "./Row";
import { ComponentProps } from "react";
type BodyProps = {
    tableData: PracoviskoProps["data"];
    search: string;
    columns: Column[];
};

export const Body = ({ tableData, search, columns }: BodyProps) => {
    return tableData.map((row, rowIndex) => {
        return (
            <a
                key={rowIndex}
                href={`detail/${row.id_original}`}
                target="_blank"
                rel="noopener noreferrer"
                style={{
                    ...(rowIndex !== tableData.length - 1 && {
                        borderBottom: "#bfbfbf 1px solid",
                    }),
                }}
            >
                {columns.map(({ key, width, date, title }, cellIndex) => {
                    const isCurrency = currencyFields?.includes(key);
                    const cellValue = isCurrency
                        ? formatCurrency(row[key] as string | number)
                        : date
                        ? formatDate(row[key] as string, date as "m.Y")
                        : row[key];
                    const valueSanitizied = (
                        cellValue
                            ? Array.isArray(cellValue)
                                ? cellValue.length
                                    ? cellValue.join(", ")
                                    : ""
                                : cellValue
                            : ""
                    ) as string;
                    const value = highlightString(valueSanitizied, search);
                    const rowProps: ComponentProps<typeof Row> = {
                        columns,
                        index: cellIndex,
                        value,
                        width,
                        isCurrency,
                        isLights: key === "atl" || key === "mtl",
                        atlColor:
                            a_mtlColors[row["atl"] as keyof typeof a_mtlColors],
                        mtlColor:
                            a_mtlColors[row["mtl"] as keyof typeof a_mtlColors],
                        isRyg: key === "ryg",
                    };
                    return <Row key={cellIndex} {...rowProps} />;
                })}
            </a>
        );
    });
};
