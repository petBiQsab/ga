import { type KeyboardEvent, useState, useMemo } from "react";
import { default as SelectComponent } from "react-select";
import makeAnimated from "react-select/animated";
// Types
import { CSSProperties } from "react";
import { getRygColor } from "../lib/data";
type Option = {
    label: string;
    value: string;
    isFixed?: boolean;
    groupLabel?: string;
};
type SelectProps = {
    name: string;
    list: Option[];
    setter: (value: string | string[] | null, isNewValue?: boolean) => void;
    label?: string;
    fixedValues?: string[];
    selectedValue: string | string[] | null;
    fontSize?: string;
    placeholder?: string;
    placeholderColor?: string;
    multiselect?: boolean;
    clearable?: boolean;
    required?: boolean;
    disabled?: boolean;
    colorScheme?: "dark" | "light";
    isEmailForm?: boolean;
    styles?: CSSProperties;
};

export const Select = ({
    name,
    list,
    setter,
    label,
    fixedValues = [],
    selectedValue,
    fontSize = "1rem",
    placeholder = "Vyberte zo zoznamu",
    placeholderColor = "#bfbfbf",
    multiselect = false,
    clearable = true,
    required = false,
    disabled = false,
    colorScheme = "light",
    isEmailForm,
    styles,
}: SelectProps) => {
    const options = useMemo(() => {
        if (["sprava", "udrzba"].includes(name)) {
            const groups = Array.from(
                new Set(list.map((item) => item.groupLabel))
            );
            const groupedOptions = groups.map((group) => ({
                label: group,
                options: list
                    .filter((item) => item.groupLabel === group)
                    .map((item) => ({
                        label: item.label,
                        value: item.value,
                    })),
            }));
            return groupedOptions;
        } else {
            return list;
        }
    }, [list]);
    const value = Array.isArray(selectedValue)
        ? selectedValue?.length > 0
            ? selectedValue.map((item) => ({
                  label: item,
                  value: item,
              }))
            : null
        : { label: selectedValue, value: selectedValue };
    const animatedComponents = makeAnimated();
    const minHeight = styles?.height ?? `calc(${fontSize} + 1.5rem)`;
    const updateValue = (option: unknown) =>
        setter(
            option
                ? multiselect
                    ? (option as Option[]).map((item) => item.value)
                    : (option as Option).value
                : null
        );
    const [inputValue, setInputValue] = useState("");
    const updateInputValue = (value: string) => setInputValue(value);
    const addNewValue = (e: KeyboardEvent<HTMLFieldSetElement>) => {
        if (
            e.key === "Enter" &&
            inputValue.length > 0 &&
            ["hashtag"].includes(name)
        ) {
            const newOption = {
                label: inputValue,
                value: inputValue,
            };
            setter([...(selectedValue as string[]), inputValue], true);
            list.push(newOption);
            setInputValue("");
        }
    };
    return (
        <fieldset
            onKeyUp={addNewValue}
            style={{
                ...(isEmailForm && {
                    marginTop: 0,
                }),
            }}
        >
            <SelectComponent
                name={name}
                options={options}
                isMulti={multiselect}
                isClearable={list.some((v) => !v.isFixed) && clearable}
                required={required}
                isDisabled={disabled}
                components={{
                    ...animatedComponents,
                    MultiValueRemove: (props) =>
                        animatedComponents.MultiValueRemove &&
                        !fixedValues.includes(
                            (props.data as { label: string }).label
                        ) &&
                        !disabled ? (
                            <animatedComponents.MultiValueRemove {...props} />
                        ) : null,
                }}
                value={value}
                onChange={updateValue}
                inputValue={inputValue}
                onInputChange={updateInputValue}
                placeholder={label ? null : placeholder}
                noOptionsMessage={() => "Žiadne výsledky"}
                loadingMessage={() => "Načítavam..."}
                menuPosition={"fixed"}
                styles={{
                    control: (baseStyles, { isFocused, isDisabled }) => ({
                        ...baseStyles,
                        minHeight,
                        fontSize,
                        lineHeight: 1,
                        backgroundColor:
                            styles?.backgroundColor ??
                            (isDisabled ? "#f5f5f5" : "transparent"),
                        borderRadius: styles?.borderRadius ?? "0.25rem",
                        border:
                            styles?.border ??
                            `${isFocused ? "#383636" : "#d9d9d9"} 1px solid`,
                        boxShadow: "none",
                        "&:hover": {
                            borderColor: isFocused ? "#383636" : "",
                        },
                        ...(isEmailForm && {
                            height: "100%",
                            borderTopLeftRadius: 0,
                            borderBottomLeftRadius: 0,
                        }),
                        ...(styles?.maxHeight && {
                            maxHeight: styles.maxHeight,
                        }),
                    }),
                    indicatorsContainer: (baseStyles) => ({
                        ...baseStyles,
                        ...(disabled && {
                            display: "none",
                        }),
                    }),
                    dropdownIndicator: (baseStyles, { isFocused }) => ({
                        ...baseStyles,
                        color: isFocused ? "#383636" : placeholderColor,
                        borderColor: isFocused ? "#383636" : placeholderColor,
                        svg: {
                            width: fontSize,
                            height: fontSize,
                        },
                        "&:hover": {
                            color: "#383636",
                        },
                    }),
                    indicatorSeparator: (baseStyles) => ({
                        ...baseStyles,
                        backgroundColor: placeholderColor,
                    }),
                    container: (baseStyles) => ({
                        ...baseStyles,
                        width: "100%",
                        minHeight,
                        ...(isEmailForm && {
                            height: "100%",
                        }),
                    }),
                    valueContainer: (baseStyles) => ({
                        ...baseStyles,
                        padding: styles?.padding ?? "0.25rem",
                    }),
                    input: (baseStyles) => ({
                        ...baseStyles,
                        color: "#383636",
                        padding: "1px 0 0",
                    }),
                    singleValue: (baseStyles) => ({
                        ...baseStyles,
                        ...(name === "ryg" && {
                            color: getRygColor(selectedValue as string),
                        }),
                    }),
                    multiValue: (baseStyles, { data }) => ({
                        ...baseStyles,
                        display: "flex",
                        alignItems: "center",
                        backgroundColor: "#e8e8e8",
                        padding: "0.25rem",
                        borderRadius: "0.25rem",
                        ...((fixedValues.includes(
                            (data as { label: string }).label
                        ) ||
                            disabled) && {
                            paddingRight: "0.5rem",
                            ...(!disabled && { backgroundColor: "#383636" }),
                        }),
                    }),
                    multiValueLabel: (baseStyles, { data }) => ({
                        ...baseStyles,
                        fontSize: "0.75rem",
                        ...(fixedValues.includes(
                            (data as { label: string }).label
                        ) && {
                            color: "#fff",
                        }),
                    }),
                    multiValueRemove: (baseStyles) => ({
                        ...baseStyles,
                        transition: "all 0.25s",
                        padding: "0.25rem",
                        "&:hover": {
                            cursor: "pointer",
                            backgroundColor: "#c5362e",
                            color: "#f5f5f5",
                        },
                    }),
                    clearIndicator: (baseStyles) => ({
                        ...baseStyles,
                        pointerEvents: selectedValue ? "auto" : "none",
                        opacity: selectedValue ? 1 : 0,
                        transition: "all 0.25s",
                        color: "#383636",
                        "&:hover": {
                            cursor: "pointer",
                            color: "#c5362e",
                        },
                    }),
                    placeholder: (baseStyles) => ({
                        ...baseStyles,
                        color: placeholderColor,
                    }),
                    menu: (base) => ({
                        ...base,
                        boxShadow: "0px 2px 8px rgba(0, 0, 0, 0.15)",
                        fontSize,
                    }),
                    menuPortal: (base) => ({
                        ...base,
                        zIndex: 9,
                    }),
                    option: (baseStyles, { isFocused, isSelected }) => ({
                        ...baseStyles,
                        backgroundColor: isFocused
                            ? "rgba(197, 54, 46, 0.12)"
                            : "",
                        ...(isSelected && {
                            backgroundColor: "#c5362e",
                        }),
                        ":active": {
                            color: "#fff",
                            backgroundColor: "#262626",
                        },
                    }),
                }}
            />
            {label && (
                <label
                    data-value={
                        (selectedValue && selectedValue.length > 0) ||
                        inputValue.length > 0
                    }
                    data-color-scheme={colorScheme}
                    style={{
                        ...(disabled && {
                            color: "#999",
                        }),
                    }}
                >
                    {label}
                    {required && " *"}
                </label>
            )}
        </fieldset>
    );
};
