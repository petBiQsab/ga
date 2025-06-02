import { CSSProperties, ChangeEvent } from "react";
type CheckboxProps = {
    label: string;
    checked: boolean;
    disabled?: boolean;
    onCheck?: (e: ChangeEvent<HTMLInputElement>) => void;
    styles?: CSSProperties;
};

export const Checkbox = ({
    label,
    checked,
    disabled,
    onCheck,
    styles,
}: CheckboxProps) => {
    return (
        <div style={styles}>
            <label
                style={{
                    display: "flex",
                    cursor: disabled ? "not-allowed" : "pointer",
                    transition: "all 0.1s linear",
                    ...(disabled && {
                        color: "#bfbfbf",
                    }),
                }}
            >
                <input
                    name={label}
                    type="checkbox"
                    checked={checked}
                    disabled={disabled}
                    onChange={onCheck}
                />
                <span
                    style={{
                        userSelect: "none",
                        marginLeft: "1rem",
                    }}
                >
                    {label}
                </span>
            </label>
        </div>
    );
};
