import { Titles } from "./Titles";
import { Summary } from "./summary";
// Types
import { Dispatch, SetStateAction } from "react";
import { Column } from "../..";
type HeaderProps = {
    columns: Column[];
    setColumns: Dispatch<SetStateAction<Column[]>>;
    customAction?: () => void;
};
export type ColumnsFilter = {
    key: Column["key"];
    width: Column["width"];
    filter: Column["filter"];
    settings: Column["settings"];
};
export type RowProps = {
    cells: Column[];
    columnsCount: number;
    updateColumnFilter: (columnFilter: ColumnsFilter) => void;
    showSummaryRow: boolean;
    customAction?: () => void;
};

export const Header = ({ columns, setColumns, customAction }: HeaderProps) => {
    const updateColumnFilter = ({
        key,
        width,
        filter,
        settings,
    }: ColumnsFilter) => {
        setColumns((prev) => {
            const column = prev.find((column) => column.key === key);
            const updatedColumn = {
                ...column,
                width,
                filter,
                settings,
            } as Column;
            return prev.map((column) =>
                column.key === key ? updatedColumn : column
            );
        });
    };
    const showSummaryRow = columns.some(
        ({ filter, settings, sum }) => filter.open || settings || sum! >= 0
    );
    const props: RowProps = {
        cells: columns,
        columnsCount: columns.length,
        updateColumnFilter,
        showSummaryRow,
        customAction,
    };
    return (
        <div
            style={{
                position: "sticky",
                zIndex: 1,
                top: 0,
            }}
        >
            <Titles {...props} />
            <Summary {...props} />
        </div>
    );
};
