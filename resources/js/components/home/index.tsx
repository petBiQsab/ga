import { type ComponentProps, useState } from "react";
import { notImplemented, toggleDrawer } from "../../store";
import { tableData } from "./useTableData";
// Assets
import { handleExport } from "../../lib/csv";
import { colummsWithAttributes, currencyFields } from "./table/assets";
import { defaultFilters } from "./filters/assets";
// Components
import { Drawer } from "../Drawer";
import { Icon } from "../icon/Icon";
import { Filters } from "./filters";
import { Header } from "./header";
import { Table } from "./table";
// Types
import { PracoviskoProps } from "../../src/types";
export type Column = {
    key: string;
    title: string;
    width: number;
    minWidth: number;
    visible: boolean;
    filter: {
        open: boolean;
        value: string[];
        list: string[];
    };
    settings: boolean;
    date?: string;
    sum?: number;
};

export const Home = ({ user, data }: PracoviskoProps) => {
    // Header
    const [search, setSearch] = useState("");
    const [filters, setFilters] = useState<string[]>(defaultFilters);
    const [columns, setColumns] = useState<Column[]>(colummsWithAttributes);
    const resetColumnsFilters = () => {
        setColumns((prev) =>
            prev.map((column) => ({
                ...column,
                filter: {
                    ...column.filter,
                    open: false,
                    value: [],
                },
            }))
        );
    };
    // Data
    const { columnsFilterLists, filteredData } = tableData({
        data,
        user,
        filters,
        search,
        columns,
    });
    const actions = [
        {
            content: (
                <>
                    <Icon
                        icon="table-filter"
                        style={{
                            color: filters.length ? "#fff" : "#595959",
                            marginRight: "0.5rem",
                        }}
                    />
                    Filtrovať
                </>
            ),
            className: filters.length ? "primary" : "secondary",
            onClick: toggleDrawer,
        },
        {
            content: "Pridať projekt",
            className: "primary",
            onClick: () => window.open("/detail", "_blank"),
        },
        {
            content: "Zrušiť filtre",
            className: "secondary",
            onClick: resetColumnsFilters,
        },
        {
            content: <Icon icon="export-csv" />,
            className: "secondary",
            onClick: () =>
                handleExport(
                    columns.filter(
                        // (column) => column.visible && column.key !== "mtl"
                        (column) => column.key !== "mtl"
                    ),
                    filteredData as {
                        [key: string]: string | number | null;
                    }[]
                ),
            title: "Exportovať zobrazované stĺpce do XLSX.",
        },
    ].filter(
        (item) =>
            (user.role !== "Administrátor"
                ? item.content !== "Pridať projekt"
                : true) && (user.role === "Everyone" ? !item.title : true)
    );
    // Props
    const filtersProps: ComponentProps<typeof Filters> = {
        filters,
        setFilters,
        closeDrawer: toggleDrawer,
    };
    const [expandHeader, setExpandHeader] = useState(false);
    const headerProps: ComponentProps<typeof Header> = {
        search,
        setSearch,
        expandHeader,
        setExpandHeader,
        actions,
        columns,
        setColumns,
    };
    const customAction = () => setExpandHeader(!expandHeader);
    const tableProps: ComponentProps<typeof Table> = {
        data: filteredData,
        search,
        columns: columns
            .filter((column) => column.visible)
            .map((column) => {
                const sum = currencyFields.includes(column.key)
                    ? filteredData
                          .map((row) => Number(row[column.key]))
                          .reduce((a, b) => a + b, 0)
                    : undefined;
                return {
                    ...column,
                    ...(column.key === "id" && {
                        // Expand ID column
                        width: column.filter.open || column.settings ? 175 : 75,
                    }),
                    filter: {
                        ...column.filter,
                        // Set filter list
                        list: columnsFilterLists[column.key],
                    },
                    ...(sum === 0 && { sum }),
                };
            }),
        setColumns,
        customAction,
        pagination: false,
    };
    return (
        <section>
            <Drawer>
                <Filters {...filtersProps} />
            </Drawer>
            <Header {...headerProps} />
            <Table {...tableProps} />
        </section>
    );
};
