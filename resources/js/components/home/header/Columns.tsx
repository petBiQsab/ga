import { colummsWithAttributes } from "../table/assets";
// Components
import { Select } from "../../Select";
// Types
import { ComponentProps, Dispatch, SetStateAction } from "react";
import { Column } from "..";
type ColumnsProps = {
    setColumns: Dispatch<SetStateAction<Column[]>>;
    selectedColumns: string[];
    localStorageVisibleColumns: string[];
    setLocalStorageVisibleColumns: Dispatch<SetStateAction<string[]>>;
};

export const Columns = ({
    setColumns,
    selectedColumns,
    localStorageVisibleColumns,
    setLocalStorageVisibleColumns,
}: ColumnsProps) => {
    const fixedColumnsIds = ["mtl", "id", "nazov_projektu"];
    const list = colummsWithAttributes.map((column) => ({
        label: column.title,
        value: column.title,
        ...(fixedColumnsIds.includes(column.key) && {
            isFixed: true,
        }),
    }));
    const setter = (value: string | string[] | null) => {
        if (value) {
            setColumns((prev) =>
                prev.map((column) => {
                    const visible = value.includes(column.title);
                    return {
                        ...column,
                        visible,
                    };
                })
            );
            setLocalStorageVisibleColumns(value as string[]);
            localStorage.setItem(
                "projektove_portfolio_visible_columns",
                JSON.stringify(value)
            );
        }
    };
    const fixedValues = colummsWithAttributes
        .filter((column) => fixedColumnsIds.includes(column.key))
        .map((column) => column.title);
    const selectProps: ComponentProps<typeof Select> = {
        name: "columns",
        list,
        setter,
        fixedValues,
        selectedValue: selectedColumns,
        multiselect: true,
        clearable: false,
        placeholder: "Vyberte stĺpce",
    };
    // Defaults
    const defaultVisibleColumns = colummsWithAttributes
        .filter((column) => column.visible)
        .map((column) => column.title);
    const isDefaultColumnsOnly =
        JSON.stringify(defaultVisibleColumns) ===
        JSON.stringify(localStorageVisibleColumns);
    const resetVisibleColumns = () => {
        setColumns((prev) =>
            prev.map((column) => {
                const visible = defaultVisibleColumns.includes(column.title);
                return {
                    ...column,
                    visible,
                };
            })
        );
        setLocalStorageVisibleColumns(defaultVisibleColumns);
        localStorage.setItem(
            "projektove_portfolio_visible_columns",
            JSON.stringify(defaultVisibleColumns)
        );
    };
    return (
        <div
            style={{
                display: "flex",
                alignItems: "center",
                flexFlow: "row wrap",
                ...(isDefaultColumnsOnly && {
                    marginBottom: "1rem",
                }),
            }}
        >
            <p
                style={{
                    fontFamily: "Open Sans",
                    fontWeight: 700,
                    fontSize: "1.25rem",
                    lineHeight: "1.5rem",
                    color: "#383636",
                    paddingBottom: "1rem",
                }}
            >
                Zobrazené stĺpce
            </p>
            <Select {...selectProps} />
            {!isDefaultColumnsOnly && (
                <button
                    className="btn-tertiary"
                    style={{
                        height: "2.5rem",
                        color: "#383636",
                        marginTop: "0.5rem",
                        marginLeft: "auto",
                    }}
                    onClick={resetVisibleColumns}
                >
                    Zobraziť predvolené
                </button>
            )}
        </div>
    );
};
