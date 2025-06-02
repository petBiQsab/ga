import { a_mtlColors } from "../../lib/data";
import { tooltips } from "./assets";
// Components
import { Tooltip } from "../Tooltip";
// Types
type AMtlColorsProps = {
    color: string | null;
    hidetooltip?: boolean;
    tooltip?: keyof typeof tooltips;
};

export const AMtlColors = ({ color, hidetooltip, tooltip }: AMtlColorsProps) => {
    const colors = Object.entries(a_mtlColors);
    const tooltipValue = tooltip ? tooltips[tooltip] : "";

    const ColorDisplay = (
        <div
            style={{
                width: "3.5rem",
                height: "1.5rem",
                display: "flex",
                alignItems: "center",
                gap: "0.25rem",
                backgroundColor: "#262626",
                padding: "0.25rem 6px",
                borderRadius: "2rem",
            }}
        >
            {colors.map(([colorName, colorHex]) => (
                <div
                    key={colorName}
                    style={{
                        width: "0.75rem",
                        height: "0.75rem",
                        backgroundColor:
                            color === colorName ? colorHex : "#ffffff52",
                        borderRadius: "50%",
                    }}
                />
            ))}
        </div>
    );

    return hidetooltip ? ColorDisplay : <Tooltip value={tooltipValue}>{ColorDisplay}</Tooltip>;
};
