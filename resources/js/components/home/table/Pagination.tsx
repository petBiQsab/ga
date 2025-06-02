import { Fragment, useMemo } from "react";
// Types
type PaginationProps = {
    count: number;
    pageLimitValues: number[];
    page: number;
    setPage: (page: number) => void;
    range: number;
    setRange: (range: number) => void;
};

export const Pagination = ({
    count,
    pageLimitValues,
    page,
    setPage,
    range,
    setRange,
}: PaginationProps) => {
    // Pagination
    const paginationPages = Array.from(
        { length: Math.ceil(count / range) },
        (_, i) => i
    );
    const listPagesFormatted = useMemo(() => {
        const pagesList = paginationPages
            .map((value) => {
                if (
                    // Show first,
                    value < 1 ||
                    // last,
                    value === paginationPages.length - 1 ||
                    // the one before and after
                    Math.abs(page - value - 1) < 2
                ) {
                    return value + 1;
                }
            })
            .filter(Boolean) as number[];
        return pagesList.flatMap((value, index) =>
            // Add ... based on the number of pages
            index === 0 || value - 1 === pagesList[index - 1]
                ? value
                : [null, value]
        );
    }, [page, paginationPages]);
    return (
        <div>
            {listPagesFormatted.map((value, index) => (
                <Fragment key={index}>
                    {value ? (
                        <span
                            style={{
                                ...(value === page && {
                                    color: "#fafafa",
                                    backgroundColor: "#383636",
                                    pointerEvents: "none",
                                }),
                            }}
                            onClick={() => setPage(value)}
                        >
                            {value.toLocaleString("sk-SK")}
                        </span>
                    ) : (
                        <p>...</p>
                    )}
                </Fragment>
            ))}
            <p>Zobraziť</p>
            <select
                value={range}
                onChange={(e) => setRange(Number(e.target.value))}
            >
                {pageLimitValues.map((value, index) => (
                    <option
                        key={index}
                        value={value}
                        label={value.toString()}
                    />
                ))}
            </select>
            {/* <p>na stránku, spolu {count.toLocaleString("sk-SK")} záznamov</p> */}
        </div>
    );
};
