import { DataObject, DataPrimitive } from "../../../src/types";
type Row = {
    [key: string]: DataPrimitive | DataObject | DataObject[];
};

export const topLevelFilters = [
    {
        name: "Zobraziť len aktívne projekty",
        callback: (row: Row) =>
            ![
                "Projekt ukončený",
                "Projekt zastavený",
                "Zatiaľ len riadok v portfóliu",
            ].includes(row.stav_projektu as string) &&
            row.kategoria_projektu !== "I",
    },
    {
        name: "Zobraziť len projekty môjho útvaru",
        callback: (row: Row, moje_utvary_filter2: string[]) =>
            (row.utvar_projektoveho_manazera as string[])?.some((utvar) =>
                moje_utvary_filter2?.includes(utvar)
            ),
    },
    {
        name: "Nezobrazovať projekty kategórie D, (D) a I",
        callback: (row: Row) =>
            !["D", "(D)", "I"].includes(row.kategoria_projektu as string),
    },
    {
        name: "Zobraziť projekty s červeným projektovým semaforom",
        callback: (row: Row) => row.mtl === "red",
    },
    {
        name: "Zobraziť projekty s červeným termínovým semaforom",
        callback: (row: Row) => row.atl === "red",
    },
    //{
    //    name: "Zobraziť priority",
    //    callback: (row: Row) => row.priorita === 1,
    //},
    //{
    //    name: "Zobraziť projekty, ktoré majú zapnutý reporting",
    //    callback: (row: Row) => (row.reporting_filter as number) > 0,
    //},
];
// Additional conditions for "Zobraziť projekty, ktoré majú zapnutý reporting"
export const radioButtonFilters = [
    {
        name: "Zreportované",
        callback: (row: Row) => row.reporting_filter === 1,
    },
    {
        name: "Nezreportované",
        callback: (row: Row) => row.reporting_filter === 2,
    },
];

export const defaultFilters = [
//    "Zobraziť len aktívne projekty",
//     "Nezobrazovať projekty kategórie D, (D) a I", zakomentované pre vypnutie
];
