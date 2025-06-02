import { Tooltip } from "../../../Tooltip";
import { Icon } from "../../../icon/Icon";
// Types
import { RowProps } from ".";

export const Titles = ({
    cells,
    columnsCount,
    updateColumnFilter,
    showSummaryRow,
    customAction,
}: RowProps) => {
    return (
        <div
            style={{
                display: "flex",
                color: "#fff",
                backgroundColor: "#383636",
            }}
        >
            {cells.map(
                ({ key, title, width, minWidth, filter, settings }, index) => {
                    const updatedFilterColumn = {
                        key,
                        width,
                    };
                    const handleClickFilter = () =>
                        updateColumnFilter({
                            ...updatedFilterColumn,
                            filter: {
                                ...filter,
                                open: !filter.open,
                            },
                            settings: !filter.open ? false : settings,
                        });
                    const handleClickSettings = () =>
                        updateColumnFilter({
                            ...updatedFilterColumn,
                            filter: !settings
                                ? {
                                      ...filter,
                                      open: false,
                                  }
                                : filter,
                            settings: !settings,
                        });
                    return (
                        <div
                            key={key}
                            style={{
                                width,
                                display: "flex",
                                alignItems: "center",
                                justifyContent: "center",
                                userSelect: "none",
                                padding: "1rem",
                                ...(index < 3 && {
                                    position: "sticky",
                                    left:
                                        index === 0
                                            ? 0
                                            : index === 1
                                            ? cells[0].width
                                            : cells[0].width + cells[1].width,
                                    backgroundColor: "#383636",
                                }),
                                ...(index !== columnsCount - 1 && {
                                    borderRight:
                                        "rgba(255, 255, 255, 0.24) 1px solid",
                                }),
                            }}
                        >
                            {!["checked", "mtl"].includes(key) && (
                                <p
                                    style={{
                                        fontFamily: "Open Sans",
                                        fontWeight: 600,
                                        fontSize: "12px",
                                        lineHeight: "18px",
                                        marginRight: "auto",
                                    }}
                                >
                                    {title}
                                </p>
                            )}
                            {index === 0 && (
                                <Tooltip
                                    value={
                                        showSummaryRow
                                            ? null
                                            : "Ľavým klikom na ikonku zobrazíte ponuku filtrov pre nastavenie tabuľky, z ktorej vyberiete požadované stĺpce. Výber je potrebné potvrdiť uložením."
                                    }
                                    offsetTop={20}
                                    offsetLeft={-20}
                                >
                                    <Icon
                                        icon="filter"
                                        style={{
                                            color: "#fff",
                                        }}
                                        onClick={customAction}
                                    />
                                </Tooltip>
                            )}
                            {index > 0 && (
                                <>
                                    <Tooltip value="Filter" offsetTop={20}>
                                        <Icon
                                            icon="table-filter"
                                            style={{
                                                color: filter.value.length
                                                    ? "#c5362e"
                                                    : filter.open
                                                    ? "#fff"
                                                    : "#bfbfbf",
                                            }}
                                            onClick={handleClickFilter}
                                        />
                                    </Tooltip>
                                    {index > 1 && (
                                        <Tooltip
                                            value="Upraviť šírku stĺpca"
                                            offsetTop={20}
                                        >
                                            <Icon
                                                icon="dots"
                                                style={{
                                                    cursor: "pointer",
                                                    color:
                                                        width > minWidth
                                                            ? "#c5362e"
                                                            : settings
                                                            ? "#fff"
                                                            : "#bfbfbf",
                                                    marginLeft: "0.5rem",
                                                }}
                                                onClick={handleClickSettings}
                                            />
                                        </Tooltip>
                                    )}
                                </>
                            )}
                        </div>
                    );
                }
            )}
        </div>
    );
};
