import { useMemo } from "react";
// Components
import { Input } from "../../../Input";
import { Select } from "../../../Select";
import { AMtlRadioButtons } from "../../AMtlRadioButtons";
// Types
import { DataObject, DetailPops } from "../../../../src/types";
export type SectionProps = {
    sectionData: {
        name: string;
        label: string;
        value: DataObject["value"] | DataObject | DataObject[];
        setValue: (value: any) => void;
        multiline?: boolean;
        list?: {
            id: string | number;
            value?: string;
            cn?: string;
            name?: string;
            nazov_projektu?: string;
            label?: string;
        }[];
        multiple?: boolean;
        disabled?: boolean;
        gridColumn?: number;
        notAvailableIds?: DetailPops["meta"]["notAvailableIds"];
    }[];
};
export type ValueObject = {
    value?: string;
    cn?: string;
    name?: string;
    nazov_projektu?: string;
} | null;

export const Section = ({ sectionData }: SectionProps) => {
    return (
        <div
            style={{
                display: "grid",
                gridTemplateColumns: "repeat(6, 1fr)",
                gap: "1rem",
            }}
        >
            {sectionData.map(
                ({
                    label,
                    name,
                    value,
                    setValue,
                    multiline,
                    list,
                    multiple,
                    disabled,
                    gridColumn,
                    notAvailableIds,
                }) => {
                    const valueFormat = useMemo(
                        () =>
                            Array.isArray(value)
                                ? (value as (ValueObject | string)[]).map((v) =>
                                      typeof v === "string"
                                          ? v
                                          : v?.value ??
                                            v?.cn ??
                                            v?.name ??
                                            v?.nazov_projektu ??
                                            ""
                                  )
                                : ((typeof value === "string" ||
                                  typeof value === "number"
                                      ? value
                                      : (value as ValueObject)?.value ??
                                        (value as ValueObject)?.cn ??
                                        (value as ValueObject)?.name ??
                                        (value as ValueObject)
                                            ?.nazov_projektu ??
                                        "") as string | number),
                        [value]
                    );
                    const setter = (
                        value: string | string[] | null,
                        isNewValue = false
                    ) => {
                        const getList = (value: string) =>
                            list?.find(
                                (item) =>
                                    value ===
                                    (item.value ??
                                        item.cn ??
                                        item.name ??
                                        item.nazov_projektu)
                            );
                        const valueItems = value
                            ? Array.isArray(value)
                                ? value.map(
                                      (valueItem) =>
                                          getList(valueItem) ??
                                          // If value is not in list, create new
                                          (isNewValue
                                              ? { value: valueItem }
                                              : null)
                                  )
                                : getList(value)
                            : null;
                        setValue(valueItems);
                    };
                    return (
                        <div
                            key={name}
                            style={{
                                gridColumn: `span ${gridColumn ?? 6}`,
                            }}
                        >
                            {name === "mtl" ? (
                                <AMtlRadioButtons
                                    label={label}
                                    color={value as string}
                                    setValue={setValue}
                                    disabled={disabled}
                                />
                            ) : list ? (
                                <Select
                                    name={name}
                                    list={
                                        list.map((item) => {
                                            const value =
                                                item.value ??
                                                item.cn ??
                                                item.name ??
                                                item.nazov_projektu ??
                                                "";
                                            return {
                                                label: value,
                                                value,
                                                ...(item.label && {
                                                    groupLabel: item.label,
                                                }),
                                            };
                                        }) ?? []
                                    }
                                    setter={setter}
                                    selectedValue={
                                        valueFormat as string | string[]
                                    }
                                    label={label}
                                    multiselect={multiple}
                                    disabled={disabled}
                                    styles={{
                                        height: "3rem",
                                        backgroundColor: "#fff",
                                        padding: "0.5rem 0.75rem",
                                    }}
                                />
                            ) : (
                                <Input
                                    name={name}
                                    label={label}
                                    value={
                                        (value as DataObject)?.type === "m.Y"
                                            ? (valueFormat as string).slice(
                                                  0,
                                                  -3
                                              )
                                            : (valueFormat as string | number)
                                    }
                                    setValue={setValue}
                                    type={
                                        (typeof valueFormat === "number"
                                            ? "number"
                                            : (value as DataObject)?.type ===
                                              "d.m.Y"
                                            ? "date"
                                            : (value as DataObject)?.type ===
                                              "m.Y"
                                            ? "month"
                                            : "text") as "text"
                                    }
                                    multiline={multiline}
                                    disabled={disabled}
                                    isInvalid={
                                        name === "id_pp" &&
                                        notAvailableIds?.includes(
                                            valueFormat as string
                                        )
                                    }
                                />
                            )}
                        </div>
                    );
                }
            )}
        </div>
    );
};
