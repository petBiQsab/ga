import { CSSProperties } from "react";
type RadioButtonProps = {
    label: string;
    checked: boolean;
    disabled?: boolean;
    onChange: (event: React.ChangeEvent<HTMLInputElement>) => void;
    styles?: CSSProperties;
};

export const RadioButton = ({
    label,
    checked,
    disabled,
    onChange,
    styles,
}: RadioButtonProps) => {
    return (
        <div style={{ ...styles }}>
            <label
                style={{
                    display: "flex",
                    userSelect: "none",
                    fontSize: "14px",
                    cursor: disabled ? "not-allowed" : "pointer",
                    transition: "all 0.1s linear",
                    ...(disabled && {
                        color: "#bfbfbf",
                    }),
                }}
            >
                <input
                    name={label}
                    type="radio"
                    checked={checked}
                    disabled={disabled}
                    onChange={onChange}
                    style={{
                        marginRight: "1rem",
                    }}
                />
                <span />
                {label}
            </label>
        </div>
    );
};
