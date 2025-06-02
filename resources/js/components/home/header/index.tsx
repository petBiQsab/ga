import {
    type Dispatch,
    type SetStateAction,
    useEffect,
    useState,
    type ComponentProps,
} from "react";
// Assets
import { supportIcons } from "./assets";
// Components
import { RouteHeaderWrapper } from "../../RouteHeaderWrapper";
import { Accordion } from "../../Accordion";
import { Icon } from "../../icon/Icon";
import { Tooltip } from "../../Tooltip";
import { Columns } from "./Columns";
// Types
import { Column } from "..";
type HeaderProps = {
    search: string;
    setSearch: (search: string) => void;
    expandHeader: boolean;
    setExpandHeader: (expandHeader: boolean) => void;
    actions: {
        content: JSX.Element | string;
        className: string;
        onClick: () => void;
        title?: string;
    }[];
    columns: Column[];
    setColumns: Dispatch<SetStateAction<Column[]>>;
};

export const Header = ({
    search,
    setSearch,
    expandHeader,
    setExpandHeader,
    actions,
    columns,
    setColumns,
}: HeaderProps) => {
    const [localStorageVisibleColumns, setLocalStorageVisibleColumns] =
        useState<string[]>([]);
    useEffect(() => {
        // Update columns from local storage
        const localStorageVisibleColumnsValue = localStorage.getItem(
            "projektove_portfolio_visible_columns"
        );
        if (localStorageVisibleColumnsValue) {
            const newLocalStorageVisibleColumns = JSON.parse(
                localStorageVisibleColumnsValue
            );
            setLocalStorageVisibleColumns(newLocalStorageVisibleColumns);
            setColumns((prev) =>
                prev.map((column) => {
                    const visible = newLocalStorageVisibleColumns.includes(
                        column.title
                    );
                    return {
                        ...column,
                        visible,
                    };
                })
            );
        }
    }, []);
    const columnsProps: ComponentProps<typeof Columns> = {
        setColumns,
        selectedColumns: columns
            .filter((column) => column.visible)
            .map((column) => column.title),
        localStorageVisibleColumns,
        setLocalStorageVisibleColumns,
    };
    return (
        <RouteHeaderWrapper>
            {/* {supportIcons.map(({ ref, icon, title }) => (
                    <Tooltip key={icon} value={title}>
                        <a
                            href={ref}
                            target="_blank"
                            className="btn-secondary"
                            style={{
                                width: 40,
                            }}
                        >
                            <Icon icon={icon} />
                        </a>
                    </Tooltip>
                ))} */}
            <input
                type="text"
                value={search}
                placeholder="Hľadať..."
                style={{
                    minWidth: "min(100%, 27rem)",
                    height: "2.5rem",
                    flex: 1,
                    ...(search.length > 0 && {
                        borderColor: "#c5362e",
                    }),
                }}
                onChange={(e) => setSearch(e.target.value.toLowerCase())}
            />
            <Accordion
                id="header"
                open={expandHeader}
                styles={{
                    width: "100%",
                    backgroundColor: "#fafafa",
                    borderRadius: "0.25rem",
                    border: "none",
                    margin: `${expandHeader ? 1 : 0.5}rem 0`,
                }}
            >
                <Columns {...columnsProps} />
                <button
                    className="btn-tertiary"
                    style={{
                        lineHeight: 1,
                        color: "#c5362e",
                        padding: 0,
                    }}
                    onClick={() => setExpandHeader(false)}
                >
                    <Icon
                        icon="hide-filter"
                        style={{ marginRight: "0.5rem" }}
                    />
                    Zatvoriť
                </button>
            </Accordion>
            <div
                style={{
                    display: "flex",
                    flexFlow: "row wrap",
                    justifyContent: "flex-end",
                    gap: "1rem",
                    marginLeft: "auto",
                }}
            >
                {actions.map(
                    ({ content, className, onClick, title }, index) => (
                        <Tooltip key={index} value={title}>
                            <button
                                className={`btn-${className}`}
                                onClick={onClick}
                                style={{
                                    ...(title && {
                                        width: "2.5rem",
                                        height: "2.5rem",
                                    }),
                                }}
                            >
                                {content}
                            </button>
                        </Tooltip>
                    )
                )}
            </div>
        </RouteHeaderWrapper>
    );
};
