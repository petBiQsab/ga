import { fields } from "./assets";
import { formatDate } from "../../lib/format";
// Components
import { Input } from "../Input";
import { Select } from "../Select";
// Types
import {
    DataObject,
    DataPrimitive,
    DetailPops,
    PracoviskoProps,
} from "../../src/types";
import { ValueObject } from "../detail/edit/section";
type AskForChangeFormProps = {
    data: DetailPops["data"] | PracoviskoProps;
};

export const AskForChangeForm = ({ data }: AskForChangeFormProps) => {
    const border = "#ddd 1px solid";
    const cellStyles = {
        padding: "0.75rem",
        borderTop: border,
        borderBottom: border,
    };
    return (
        <div
            style={{
                maxWidth: "75vw",
                display: "flex",
                flexDirection: "column",
                gap: "0.25rem",
            }}
        >
            {fields.map(({ parentKey, key, name }) => {
                const value = (data as DetailPops["data"])?.[parentKey]?.[key];
                const isArray = Array.isArray(value);
                const isDate = key.includes("datum");
                const valueFormat = (
                    isArray
                        ? value.map((v, index) => {
                              const item = (
                                  v.hasOwnProperty("value")
                                      ? (v as DataObject).value
                                      : v
                              ) as string;
                              return (
                                  <p
                                      key={index}
                                      style={{
                                          backgroundColor: "#e8e8e8",
                                          padding: "0.25rem 0.5rem",
                                          borderRadius: "0.5rem",
                                      }}
                                  >
                                      {item}
                                  </p>
                              );
                          })
                        : value?.hasOwnProperty("value")
                        ? isDate
                            ? formatDate(
                                  (value as DataObject).value as string,
                                  key
                              )
                            : (value as DataObject).value
                        : value
                ) as DataPrimitive;
                const CellTag = isArray ? "div" : ("p" as const);
                // Input, Select
                const inputValueFormat = isArray
                    ? (value as (ValueObject | string)[]).map((v) =>
                          typeof v === "string"
                              ? v
                              : v?.value ??
                                v?.cn ??
                                v?.name ??
                                v?.nazov_projektu ??
                                ""
                      )
                    : ((typeof value === "string" || typeof value === "number"
                          ? value
                          : (value as ValueObject)?.value ??
                            (value as ValueObject)?.cn ??
                            (value as ValueObject)?.name ??
                            (value as ValueObject)?.nazov_projektu ??
                            "") as string | number);
                return (
                    <div
                        key={name}
                        style={{
                            overflow: "hidden",
                            display: "grid",
                            gridTemplateColumns: "2fr 3fr 3fr",
                            borderRadius: "0.25rem",
                        }}
                    >
                        <p
                            style={{
                                backgroundColor: "#e8e8e8",
                                borderLeft: border,
                                ...cellStyles,
                            }}
                        >
                            {name}
                        </p>
                        <CellTag
                            style={{
                                backgroundColor: "#f5f5f5",
                                ...cellStyles,
                                ...(isArray && {
                                    display: "flex",
                                    flexFlow: "row wrap",
                                    gap: "0.25rem",
                                }),
                            }}
                        >
                            {valueFormat}
                        </CellTag>
                        {isArray ? (
                            <Select
                                name={key}
                                list={[]}
                                setter={() => {}}
                                selectedValue={
                                    inputValueFormat as string | string[]
                                }
                                multiselect
                                isEmailForm
                            />
                        ) : (
                            <Input
                                name={key}
                                type={isDate ? "month" : "text"}
                                required
                                styles={{
                                    height: "100%",
                                    borderTopLeftRadius: 0,
                                    borderBottomLeftRadius: 0,
                                    margin: 0,
                                }}
                            />
                        )}
                    </div>
                );
            })}
        </div>
    );
};
