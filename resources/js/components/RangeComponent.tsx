import { ChangeEvent } from "react";
type RangeComponentProps = {
    value: number;
    setValue: (event: ChangeEvent<HTMLInputElement>) => void;
    setter: () => void;
    defaultMinimalRange: number;
    defaultMaximalRange: number;
    defaultStep: number;
};

export const RangeComponent = ({
    value,
    setValue,
    setter,
    defaultMinimalRange,
    defaultMaximalRange,
    defaultStep,
}: RangeComponentProps) => {
    return (
        <div
            style={{
                display: "flex",
                alignItems: "center",
            }}
        >
            <input
                type="range"
                value={value}
                min={defaultMinimalRange}
                max={defaultMaximalRange}
                step={defaultStep}
                onChange={setValue}
                onMouseUp={setter}
                onMouseLeave={setter}
                onTouchEnd={setter}
            />
            <p
                style={{
                    fontFamily: "Open Sans",
                    fontWeight: 600,
                    fontSize: "12px",
                    lineHeight: "18px",
                }}
            >
                {value}
            </p>
        </div>
    );
};
