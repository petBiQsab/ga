import { useState } from "react";
// Assets
import { a_mtlColors } from "../../lib/data";
import { tooltips } from "./assets";
// Components
import { Tooltip } from "../Tooltip";
// Types
type AMtlRadioButtonsProps = {
    label: string;
    color: string | null;
    setValue: (value: string | null) => void;
    disabled?: boolean;
};

export const AMtlRadioButtons = ({
    label,
    color,
    setValue,
    disabled,
}: AMtlRadioButtonsProps) => {
    const colors = Object.entries(a_mtlColors);
    const [colorState, setColorState] = useState(color);
    const toggleColor = () => {
        if (!disabled) {
            const index = colors.findIndex(
                ([colorName]) => colorName === colorState
            );
            const newColorState =
                index === colors.length - 1
                    ? null
                    : colors[index === colors.length - 1 ? 0 : index + 1][0];
            setColorState(newColorState);
            setValue(newColorState);
        }
    };
    return (
        <Tooltip value={tooltips.AMtl}>
            <div
                style={{
                    display: "flex",
                    justifyContent: "space-between",
                    backgroundColor: "#fff",
                    padding: "0.75rem",
                    border: "#ddd 1px solid",
                    borderRadius: "0.25rem",
                    userSelect: "none",
                }}
            >
                <p>{label}</p>
                <div
                    style={{
                        width: "3.5rem",
                        height: "1.5rem",
                        cursor: disabled ? "not-allowed" : "pointer",
                        display: "flex",
                        alignItems: "center",
                        gap: "0.25rem",
                        backgroundColor: "#262626",
                        padding: "0.25rem 6px",
                        borderRadius: "2rem",
                    }}
                    onClick={toggleColor}
                >
                    {colors.map(([colorName, colorHex]) => (
                        <div
                            key={colorName}
                            style={{
                                width: "0.75rem",
                                height: "0.75rem",
                                transition: "background-color 0.25s",
                                backgroundColor:
                                    colorState === colorName
                                        ? colorHex
                                        : "#ffffff52",
                                borderRadius: "50%",
                            }}
                        />
                    ))}
                </div>
            </div>
        </Tooltip>
    );
};
