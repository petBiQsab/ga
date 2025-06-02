import { type ChangeEvent, Fragment, useEffect, type MouseEvent } from "react";
// Assets
import { topLevelFilters, radioButtonFilters } from "./assets";
// Components
import { Icon } from "../../icon/Icon";
import { Checkbox } from "../../Checkbox";
import { RadioButton } from "../../RadioButton";
// Types
type FiltersProps = {
    filters: string[];
    setFilters: (filters: string[]) => void;
    closeDrawer: () => void;
};

export const Filters = ({ filters, setFilters, closeDrawer }: FiltersProps) => {
    useEffect(() => {
        // Update filters from local storage
        const localStorageFiltersValue = localStorage.getItem(
            "projektove_portfolio_filters"
        );
        if (localStorageFiltersValue) {
            setFilters(JSON.parse(localStorageFiltersValue));
        }
    }, []);
    const updateFilters = (
        e: ChangeEvent<HTMLInputElement> | MouseEvent<HTMLButtonElement>
    ) => {
        const { name } = e.currentTarget;
        if (name) {
            // Update checkbox filters
            const updatedTopLevelFilters = filters.includes(name)
                ? filters.filter((filter) => filter !== name)
                : [
                      ...(name === "Zreportované"
                          ? filters.filter(
                                (filter) => filter !== "Nezreportované"
                            )
                          : name === "Nezreportované"
                          ? filters.filter(
                                (filter) => filter !== "Zreportované"
                            )
                          : filters),
                      name,
                  ];
            // Update radio button filters
            const updatedFilters =
                name === "Zobraziť projekty, ktoré majú zapnutý reporting" &&
                filters.includes(
                    "Zobraziť projekty, ktoré majú zapnutý reporting"
                )
                    ? filters.filter(
                          (filter) =>
                              ![
                                  "Zobraziť projekty, ktoré majú zapnutý reporting",
                                  "Zreportované",
                                  "Nezreportované",
                              ].includes(filter)
                      )
                    : updatedTopLevelFilters;
            // Update state and local storage
            setFilters(updatedFilters);
            localStorage.setItem(
                "projektove_portfolio_filters",
                JSON.stringify(updatedFilters)
            );
        } else {
            // Reset filters
            setFilters([]);
            localStorage.removeItem("projektove_portfolio_filters");
        }
    };
    const checkboxStyles = {
        backgroundColor: "#f5f5f5",
        padding: "1rem",
        borderRadius: "0.25rem",
    };
    return (
        <div
            className="filters"
            style={{
                display: "flex",
                flexFlow: "row wrap",
                justifyContent: "space-between",
            }}
        >
            <p
                style={{
                    fontWeight: 700,
                    padding: "1.5rem",
                }}
            >
                Filter
            </p>
            <Icon
                icon="close"
                onClick={closeDrawer}
                style={{
                    marginRight: "1.5rem",
                }}
            />
            <div
                style={{
                    display: "flex",
                    flexDirection: "column",
                    gap: "0.5rem",
                    padding: "1.25rem 1.5rem",
                    borderTop: "#e0e0e0 1px solid",
                }}
            >
                {topLevelFilters.map(({ name }) => (
                    <Fragment key={name}>
                        {name ===
                        "Zobraziť projekty, ktoré majú zapnutý reporting" ? (
                            <div style={{ ...checkboxStyles }}>
                                <Checkbox
                                    label={name}
                                    checked={filters.includes(name)}
                                    onCheck={updateFilters}
                                />
                                {radioButtonFilters.map(({ name }) => (
                                    <RadioButton
                                        key={name}
                                        label={name}
                                        checked={filters.includes(name)}
                                        disabled={
                                            !filters.includes(
                                                "Zobraziť projekty, ktoré majú zapnutý reporting"
                                            )
                                        }
                                        onChange={updateFilters}
                                        styles={{
                                            backgroundColor: "#fff",
                                            padding: "0.5rem 0.75rem",
                                            borderRadius:
                                                checkboxStyles.borderRadius,
                                            marginTop:
                                                name === "Zreportované"
                                                    ? "0.75rem"
                                                    : "0.5rem",
                                        }}
                                    />
                                ))}
                            </div>
                        ) : (
                            <Checkbox
                                label={name}
                                checked={filters.includes(name)}
                                onCheck={updateFilters}
                                styles={checkboxStyles}
                            />
                        )}
                    </Fragment>
                ))}
                {filters.length > 0 && (
                    <button
                        className="btn-tertiary"
                        style={{
                            alignSelf: "flex-end",
                            color: "#383636",
                        }}
                        onClick={updateFilters}
                    >
                        Vypnúť všetky filtre
                    </button>
                )}
            </div>
        </div>
    );
};
