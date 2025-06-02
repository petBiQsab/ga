import { Fragment } from "react";
// Components
import { Input } from "../../../../Input";
import { Select } from "../../../../Select";
import { Icon } from "../../../../icon/Icon";
import { Tooltip } from "../../../../Tooltip";
// Types
import { ActivitiesProps, UpdateActivityType } from ".";
import { Activity as ActivityType } from "../../../types";
import { DetailPops } from "../../../../../src/types";
export type ActivityProps = ActivityType & {
    isAdmin: boolean;
    isPM: boolean;
    updateActivity: (value: ActivityType, type: UpdateActivityType) => void;
    list: ActivitiesProps["list"];
    categories: ActivitiesProps["categories"];
    users: ActivitiesProps["users"];
    rights: DetailPops["meta"]["rights"];
    isDeleting?: boolean;
};

export const Activity = (props: ActivityProps) => {
    const {
        isAdmin,
        isPM,
        flag,
        headerTitle,
        value,
        zodpovedni,
        updateActivity,
        list,
        categories,
        users,
        isDeleting,
        rights,
    } = props;
    const updateValue = (
        name: string,
        value: string | string[] | number | null
    ) => {
        const newValue =
            name === "zodpovedni"
                ? (value as string[]).map((v) => ({
                      id: users.find((user) => user.value === v)?.id ?? null,
                      value: v,
                  }))
                : name === "value"
                ? {
                      id: list.find((item) => item.name === value)?.id ?? null,
                      value,
                  }
                : name === "headerTitle"
                ? {
                      id:
                          categories.find(
                              (category) => category.value === value
                          )?.id ?? null,
                      value,
                  }
                : value;
        updateActivity(
            {
                ...props,
                [name]: newValue,
            },
            "update"
        );
    };
    const persons = zodpovedni?.map(({ value }) => value) ?? [];
    const inputProps = {
        colorScheme: "dark",
    } as const;
    const selectProps = {
        colorScheme: "dark",
        styles: {
            height: "3rem",
            backgroundColor: "#fff",
            padding: "0.5rem 0.75rem",
        },
    } as const;
    const dateFields = [
        [
            {
                name: "zaciatok_aktivity",
                label: "Plánovaný začiatok",
            },
            {
                name: "skutocny_zaciatok_aktivity",
                label: "Reálny začiatok",
            },
        ],
        [
            {
                name: "koniec_aktivity",
                label: "Plánovaný koniec",
            },
            {
                name: "skutocny_koniec_aktivity",
                label: "Reálny koniec",
            },
        ],
    ];
    const objectValue = typeof value === "object" ? value.value : value;
    return (
        <div
            style={{
                width: "100%",
                display: "flex",
                alignItems: "flex-start",
                gap: "0.75rem",
                // ...(isDeleting && {
                //     pointerEvents: "none",
                //     transition: "opacity 0.75s",
                //     opacity: 0,
                // }),
            }}
        >
            <Tooltip
                value="Potvrďte zmazanie aktivity"
                alignment="right"
                isOpen={!!isDeleting}
                isNotificationType="warning"
                isNotificationCallback={() =>
                    updateActivity(props, "confirm-delete")
                }
                wrapperStyles={{
                    flex: 1,
                    display: "grid",
                    gridTemplateColumns: "repeat(5, 1fr)",
                    gap: "0.5rem",
                    transition: "all 0.75s",
                    backgroundColor: "#e8e8e8",
                    padding: "0.75rem 1rem",
                    borderRadius: "0.5rem",
                    border: `${
                        isDeleting ? "#c5362e" : "transparent"
                    } 1px solid`,
                    ...(isDeleting && {
                        pointerEvents: "none",
                    }),
                }}
            >
                <div
                    style={{
                        gridColumn: "span 2",
                    }}
                >
                    {flag ? (
                        <Select
                            {...selectProps}
                            name="aktivita"
                            label="Aktivita"
                            list={list.map(({ name }) => ({
                                label: name,
                                value: name,
                            }))}
                            setter={updateValue.bind(null, "value")}
                            selectedValue={objectValue}
                            disabled={
                                isDeleting || !rights.write.includes("value")
                            }
                        />
                    ) : (
                        <Input
                            {...inputProps}
                            name="vlastna-aktivita"
                            label="Vlastná aktivita"
                            value={objectValue}
                            setValue={updateValue.bind(null, "value")}
                            disabled={
                                isDeleting || !rights.write.includes("value")
                            }
                        />
                    )}
                    <br />
                    <Select
                        {...selectProps}
                        name="zodpovedni"
                        label="Zodpovední"
                        list={users.map(({ value }) => ({
                            label: value,
                            value,
                        }))}
                        setter={updateValue.bind(null, "zodpovedni")}
                        selectedValue={persons ?? ""}
                        multiselect
                        disabled={
                            isDeleting || !rights.write.includes("zodpovedni")
                        }
                    />
                </div>
                <div>
                    {flag ? (
                        <Input
                            {...inputProps}
                            name="kategoria"
                            label="Kategória"
                            value={
                                list.find(({ name }) => name === objectValue)
                                    ?.headerTitle ?? ""
                            }
                            setValue={() => {}}
                            disabled
                        />
                    ) : (
                        <Select
                            {...selectProps}
                            name="kategoria"
                            label="Kategória"
                            list={categories.map(({ value }) => ({
                                label: value,
                                value,
                            }))}
                            setter={updateValue.bind(null, "headerTitle")}
                            selectedValue={
                                typeof headerTitle === "object"
                                    ? headerTitle.value ?? ""
                                    : headerTitle ?? ""
                            }
                            disabled={
                                isDeleting ||
                                !rights.write.includes("headerTitle")
                            }
                        />
                    )}
                </div>
                {dateFields.map((dateField, index) => (
                    <div key={index}>
                        {dateField.map(({ name, label }, subIndex) => (
                            <Fragment key={name}>
                                <Input
                                    {...inputProps}
                                    name={name}
                                    label={label}
                                    value={(
                                        (props[name as keyof typeof props] ??
                                            "") as string
                                    ).slice(0, -3)}
                                    setValue={updateValue.bind(null, name)}
                                    type="month"
                                    disabled={
                                        isDeleting ||
                                        !rights.write.includes(name)
                                    }
                                    dateAttributes={{
                                        min: name.includes("koniec")
                                            ? (
                                                  props[
                                                      name.replace(
                                                          "koniec",
                                                          "zaciatok"
                                                      ) as keyof typeof props
                                                  ] as string
                                              )?.slice(0, -3)
                                            : undefined,
                                    }}
                                />
                                {subIndex === 0 && <br />}
                            </Fragment>
                        ))}
                    </div>
                ))}
            </Tooltip>
            {isAdmin && !isPM && (
                <Icon
                    icon="close"
                    style={{
                        width: "1.5rem",
                        height: "1.5rem",
                        transition: "transform 0.75s",
                        transform: `rotate(${
                            isDeleting ? 45 : 0
                        }deg) scale(0.81)`,
                        backgroundColor: isDeleting ? "#c5362e" : "#595959",
                        color: "#fff",
                        padding: "6px",
                        borderRadius: "50%",
                    }}
                    onClick={() =>
                        updateActivity(
                            props,
                            isDeleting ? "cancel-delete" : "delete"
                        )
                    }
                />
            )}
        </div>
    );
};
