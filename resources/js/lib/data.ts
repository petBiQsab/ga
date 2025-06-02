import { CSSProperties } from "react";
import { DataObject } from "../src/types";

export const a_mtlColors = {
    red: "#ff1414",
    orange: "#f4a407",
    green: "#0ab707",
};

export const getRygColor = (
    value: string | number | DataObject | null
): CSSProperties["color"] => {
    if (value) {
        const currentValue = (
            (typeof value === "object" ? value.value : value) ?? ""
        )
            .toString()
            .toLowerCase();
        return currentValue.length
            ? currentValue === "yellow"
                ? "#f4d307"
                : a_mtlColors[currentValue as keyof typeof a_mtlColors]
            : "inherit";
    } else {
        return "inherit";
    }
};
