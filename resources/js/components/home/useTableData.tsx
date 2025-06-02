import { useMemo } from "react";
// Assets
import { radioButtonFilters, topLevelFilters } from "./filters/assets";
// Types
import { DataPrimitive, PracoviskoProps } from "../../src/types";
import { Column } from ".";
type TableData = {
    data: PracoviskoProps["data"];
    user: PracoviskoProps["user"];
    filters: string[];
    search: string;
    columns: Column[];
};

export const tableData = ({
    data,
    user,
    filters,
    search,
    columns,
}: TableData) => {
    const dataSearchAndFilters = useMemo(
        () =>
            data.filter(
                (row) =>
                    // Iterate over active filters
                    [...topLevelFilters, ...radioButtonFilters].every(
                        ({ name, callback }) =>
                            filters.includes(name)
                                ? callback(
                                      row as { [key: string]: DataPrimitive },
                                      user.moje_utvary_filter2
                                  )
                                : true
                    ) &&
                    // Check if the row contains search
                    Object.values(row).some((value) =>
                        String(value).toLowerCase().includes(search)
                    )
            ),
        [filters, search]
    );
    const columnsFilterLists = Object.assign(
        {},
        ...columns.map((column) => ({
            [column.key]: Array.from(
                new Set(
                    dataSearchAndFilters
                        .flatMap((row) => String(row[column.key] ?? ""))
                        .filter(Boolean)
                )
            ),
        }))
    ) as {
        [key: string]: string[];
    };
    const filteredData = useMemo(
        () =>
            dataSearchAndFilters.filter((row) =>
                columns
                    .filter((column) => column.visible)
                    .every(({ key, filter }) => {
                        if (filter.value.length > 0) {
                            const cellValue = String(row[key]);
                            // Empty values
                            const showNullValues =
                                filter.value.includes("Prázdné");
                            if (Array.isArray(cellValue)) {
                                // If the cell is an array, check if any of the values match
                                return (cellValue as string[]).some((v) =>
                                    showNullValues
                                        ? v === null
                                        : filter.value.includes(v)
                                );
                            } else {
                                // If the cell is a string, check if it matches
                                return showNullValues
                                    ? row[key] === null || cellValue === null
                                    : filter.value.includes(
                                          cellValue as string
                                      );
                            }
                        } else {
                            // If no filter is selected, show all rows
                            return true;
                        }
                    })
            ),
        [columns, dataSearchAndFilters]
    );
    return {
        columnsFilterLists,
        filteredData,
    };
};
