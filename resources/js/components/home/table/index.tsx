import {
    type Dispatch,
    type SetStateAction,
    useState,
    type ComponentProps,
} from "react";
import { drawerState } from "../../../store";
// Components
import { Header } from "./header";
import { Body } from "./body";
import { NoData } from "./body/NoData";
import { Pagination } from "./Pagination";
// Types
import { Column } from "..";
import { PracoviskoProps } from "../../../src/types";
type TableProps = {
    data: PracoviskoProps["data"];
    search: string;
    columns: Column[];
    setColumns: Dispatch<SetStateAction<Column[]>>;
    customAction?: () => void;
    pagination?: boolean;
};

export const Table = (props: TableProps) => {
    const { data, pagination, ...rest } = props;
    const { open } = drawerState.useState((state) => state);
    // Pagination
    const [page, setPage] = useState(1);
    const [range, setRange] = useState(10);
    const pageLimitValues = [10, 25, 50];
    const tableData = pagination
        ? data.slice((page - 1) * range, page * range)
        : data;
    const tableProps = {
        ...rest,
        columns: props.columns,
        tableData,
    };
    const paginationProps: ComponentProps<typeof Pagination> = {
        count: data.length,
        pageLimitValues,
        page,
        setPage,
        range,
        setRange,
    };
    const showPagination = pagination && data.length > range;
    return (
        <div className="list-table">
            <div
                style={{
                    margin: open ? 0 : "0 auto",
                    ...(!tableData.length && { height: "100%" }),
                }}
            >
                <Header {...tableProps} />
                {tableData.length ? <Body {...tableProps} /> : <NoData />}
            </div>
            {showPagination && <Pagination {...paginationProps} />}
        </div>
    );
};
