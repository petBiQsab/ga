import { isListField } from "../../assets";
import { getRygColor } from "../../../../lib/data";
import {formatDate, formatCurrency, formatCurrencyPercent} from "../../../../lib/format";
// Components
import { AMtlColors } from "../../AMtlColors";
// Types
import { DataObject, DataPrimitive } from "../../../../src/types";
import { ReactNode } from "react";
export type SectionProps = {
    sectionData: {
        name: string;
        label: string;
        value: DataObject["value"] | DataObject | DataObject[];
    }[];
};

export const Section = ({ sectionData }: SectionProps) => {
    return (
        <div
            style={{
                display: "flex",
                flexDirection: "column",
                gap: "0.5rem",
            }}
        >
            {sectionData.map(({ label, name, value }) => {
                const isArray = Array.isArray(value);
                const isList = isListField(name);
                const valueFormat = isArray ? (
                    // Arrays
                    value.map((v, index) => {
                        const item = (
                            v?.hasOwnProperty("value")
                                ? (v as DataObject).value
                                : v
                        ) as string;
                        return (
                            <p
                                key={index}
                                style={{
                                    padding: "0.25rem 0.5rem",
                                    ...(value.length > 1 && {
                                        backgroundColor: "#f5f5f5",
                                        borderRadius: "0.5rem",
                                    }),
                                }}
                            >
                                {item}
                            </p>
                        );
                    })
                ) : value?.hasOwnProperty("value") ? (
                    // Objects
                    (value as DataObject).type === "number" ? (
                        ["max_rok"].includes(name) ? (
                            (value as DataObject).value
                        ) : (
                            // Numbers
                            name === "podiel_externeho_financovania_z_celkovej_ceny" ? formatCurrencyPercent((value as DataObject).value as Exclude<
                                    DataPrimitive,
                                    string[]
                                >) :
                        formatCurrency(
                                (value as DataObject).value as Exclude<
                                    DataPrimitive,
                                    string[]
                                >
                            )
                        )
                    ) : (value as DataObject).type ? (
                        // Dates
                        formatDate(
                            (value as DataObject).value as string,
                            (value as DataObject).type as "d.m.Y"
                        )
                    ) : (
                        (value as DataObject).value
                    )
                ) : name.includes("hyperlink_") ? (
                    // Links
                    <a href={value as string} target="_blank">
                        Link
                    </a>
                ) : isList ? (
                    (value as string)?.split("\n")?.length > 1 ? (
                        <ul>
                            {(value as string)
                                .split("\n")
                                .map((item, index) => (
                                    <li key={index}>{item}</li>
                                ))}
                        </ul>
                    ) : (
                        value
                    )
                ) : (
                    value
                );
                const ValueTag = isArray || isList ? "div" : "p";
                return (
                    <div
                        key={name}
                        style={{
                            minHeight: "2rem",
                            display: "grid",
                            gridTemplateColumns: "2fr 3fr",
                        }}
                    >
                        <p
                            style={{
                                fontWeight: 600,
                                padding: "0.25rem 0",
                            }}
                        >
                            {label}
                        </p>
                        {name === "mtl" ? (
                            <AMtlColors color={value as string} tooltip="AMtl"/>
                        ) : (
                            <ValueTag
                                style={
                                    isArray
                                        ? {
                                              display: "flex",
                                              flexFlow: "row wrap",
                                              gap: "0.25rem",
                                          }
                                        : {
                                              padding: "0.25rem 0.5rem",
                                              ...(name === "ryg" && {
                                                  color: getRygColor(value),
                                              }),
                                          }
                                }
                            >
                                {valueFormat as ReactNode}
                            </ValueTag>
                        )}
                    </div>
                );
            })}
        </div>
    );
};
