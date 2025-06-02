import { ChangeEvent, useState } from "react";
// Components
import { RangeComponent } from "../../../../RangeComponent";
// Types
type SettingsProps = {
    width: number;
    minWidth: number;
    updateColumnWidth: (width: number) => void;
};

export const Settings = ({
    width,
    minWidth,
    updateColumnWidth,
}: SettingsProps) => {
    // Range
    const [value, setValue] = useState(width);
    const setter = () => updateColumnWidth(value);
    const defaultMinimalRange = minWidth ?? 180;
    const defaultMaximalRange = defaultMinimalRange * 2;
    const updateRange = (e: ChangeEvent<HTMLInputElement>) => {
        const value = Number(e.target.value);
        if (value <= defaultMaximalRange) {
            setValue(value);
        }
    };
    const rangeProps = {
        value,
        setValue: updateRange,
        setter,
        defaultMinimalRange,
        defaultMaximalRange,
        defaultStep: 5,
    };
    return (
        <>
            <RangeComponent {...rangeProps} />
        </>
    );
};
