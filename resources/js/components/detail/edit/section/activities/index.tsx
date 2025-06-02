import { Fragment } from "react";
// Assets
import { getPermittedActivities } from "../../../assets";
import { standardTemplate, vlastnaTemlpate } from "./assets";
// Components
import { Section, type SectionProps } from "..";
import { AddActivity } from "./AddActivity";
import { Activity, type ActivityProps } from "./Activity";
// Types
import type { Activity as ActivityType } from "../../../types";
import { DetailPops } from "../../../../../src/types";
export type ActivitiesProps = {
    role: string;
    standard: ActivityType[];
    vlastne: ActivityType[];
    sectionData: SectionProps["sectionData"];
    list: { id: string; headerTitle: string; name: string }[];
    categories: { id: string; value: string }[];
    users: { id: string; value: string }[];
    setValue: (activityType: string, value: ActivityType[]) => void;
    rights: DetailPops["meta"]["rights"];
};
export type UpdateActivityType =
    | "add"
    | "update"
    | "delete"
    | "confirm-delete"
    | "cancel-delete";

export const Activities = ({
    role,
    standard,
    vlastne,
    sectionData,
    list,
    categories,
    users,
    setValue,
    rights,
}: ActivitiesProps) => {
    const isAdmin = ["Administrátor", "Projektové vedenie"].includes(role);
    const isPM = role === "Projektové vedenie";

    const activities = [
        {
            activities: getPermittedActivities(standard, rights),
            type: "standard",
            buttonTitle: "štandardnú",
        },
        {
            activities: getPermittedActivities(vlastne, rights),
            type: "vlastne",
            buttonTitle: "vlastnú",
        },
    ];
    const updateActivity = (
        activityType: string,
        index: number,
        value: ActivityType,
        type: UpdateActivityType
    ) => {
        const activitiesCopy =
            activityType === "standard" ? [...standard] : [...vlastne];
        const isDelete = type === "delete";
        if (type === "add") {
            activitiesCopy.push(value);
        } else {
            activitiesCopy[index] = {
                ...value,
                ...(["delete", "cancel-delete"].includes(type) && {
                    isDeleting: isDelete,
                }),
            };
        }
        setValue(activityType, activitiesCopy);
        if (type === "confirm-delete") {
            activitiesCopy.splice(index, 1);
            setValue(activityType, activitiesCopy);
        }
        // if (isDelete) {
        //     setTimeout(() => {
        //         activitiesCopy.splice(index, 1);
        //         setValue(activityType, activitiesCopy);
        //     }, 750);
        // }
    };
    return (
        <>
            <Section sectionData={sectionData} />
            <div
                style={{
                    display: "flex",
                    flexDirection: "column",
                    alignItems: "flex-start",
                    gap: "0.5rem",
                    paddingTop: "1rem",
                    borderTop: "#d9d9d9 1px solid",
                    marginTop: "1rem",
                }}
            >
                {activities.map(({ activities, type, buttonTitle }) => {
                    const newValue = (type === "standard"
                        ? standardTemplate
                        : vlastnaTemlpate) as unknown as ActivityProps;
                    const addActivity = updateActivity.bind(
                        null,
                        type,
                        0,
                        newValue,
                        "add"
                    );
                    return (
                        <Fragment key={type}>
                            {activities.map((aktivita, index) => {
                                const key =
                                    aktivita.id_aktivita ?? `${type}_${index}`;
                                return (
                                    <Activity
                                        {...aktivita}
                                        key={key}
                                        isAdmin={isAdmin}
                                        isPM={isPM}
                                        updateActivity={updateActivity.bind(
                                            null,
                                            type,
                                            index
                                        )}
                                        list={list}
                                        categories={categories}
                                        users={users}
                                        rights={rights}
                                    />
                                );
                            })}
                            {isAdmin && (
                                <AddActivity
                                    title={`Pridať ${buttonTitle} aktivitu`}
                                    addActivity={addActivity}
                                />
                            )}
                        </Fragment>
                    );
                })}
            </div>
        </>
    );
};
