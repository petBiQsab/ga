// Utils
import { formatCurrency } from "../../../../../lib/format";
// Components
import { Select } from "../../../../Select";
import { Settings } from "./Settings";
// Types
import { RowProps } from "..";

export const Summary = ({
    cells,
    columnsCount,
    updateColumnFilter,
    showSummaryRow,
}: RowProps) => {
    return showSummaryRow ? (
        <div
            style={{
                minHeight: "3rem",
                display: "flex",
                transition: "all 0.3s",
                color: "#383636",
                backgroundColor: "#d9d9d9",
            }}
        >
            {cells.map(
                ({ key, width, minWidth, filter, settings, sum }, index) => {
                    const updateColumnWidth = (width: number) =>
                        updateColumnFilter({
                            key,
                            width,
                            filter,
                            settings,
                        });
                    const settingsProps = {
                        width,
                        minWidth,
                        updateColumnWidth,
                    };
                    const filterList = [
                        {
                            label: "Prázdné",
                            value: "Prázdné",
                        },
                        ...(filter.list.map((value) => ({
                            value,
                            label: value,
                        })) ?? []),
                    ];
                    const setter = (value: string | string[] | null) =>
                        updateColumnFilter({
                            key,
                            width,
                            filter: {
                                ...filter,
                                value: value as string[],
                            },
                            settings,
                        });
                    const selectProps = {
                        name: key,
                        list: filterList,
                        selectedValue: filter.value,
                        setter,
                        multiselect: true,
                        fontSize: "0.75rem",
                        placeholder: "Zobraziť",
                        placeholderColor: "#383636",
                    };
                    return (
                        <div
                            key={index}
                            style={{
                                width,
                                display: "flex",
                                alignItems: "center",
                                justifyContent: `flex-${
                                    settings ? "end" : "start"
                                }`,
                                padding: "0.25rem 1rem",
                                ...(index < 3 && {
                                    position: "sticky",
                                    left:
                                        index === 0
                                            ? 0
                                            : index === 1
                                            ? cells[0].width
                                            : cells[0].width + cells[1].width,
                                    zIndex: 1,
                                    backgroundColor: "#d9d9d9",
                                }),
                                ...(index === 0 && {
                                    backgroundColor: "transparent",
                                }),
                                ...(index !== columnsCount - 1 && {
                                    borderRight: "#bfbfbf 1px solid",
                                }),
                            }}
                        >
                            {settings ? (
                                <Settings {...settingsProps} />
                            ) : filter.open ? (
                                <Select {...selectProps} />
                            ) : (
                                sum! >= 0 && (
                                    <p
                                        style={{
                                            width: "100%",
                                            fontFamily: "Open Sans",
                                            fontWeight: 600,
                                            fontSize: "12px",
                                            lineHeight: "18px",
                                            textAlign: "right",
                                        }}
                                    >
                                        {formatCurrency(sum ?? 0)}
                                    </p>
                                )
                            )}
                        </div>
                    );
                }
            )}
        </div>
    ) : null;
};
