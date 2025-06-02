import {
    type ForwardedRef,
    forwardRef,
    type Dispatch,
    type SetStateAction,
} from "react";
import { sections } from "../assets";
// Components
import { Accordion } from "../../Accordion";
import { Section, type SectionProps } from "./section";
import { Activities, ActivitiesProps } from "./section/activities";
import { Years, yearsObjectKeys, type YearsDataObject } from "./section/Years";
// Types
import { DataObject, DetailPops } from "../../../src/types";
import { ActivityProps } from "./section/activities/Activity";
type EditProps = {
    isCreate: boolean;
    role: string;
    data: DetailPops["data"];
    setData: Dispatch<SetStateAction<DetailPops["data"]>>;
    lists: {
        [key: string]: DataObject[];
    };
    meta: DetailPops["meta"];
};

export const Edit = forwardRef(
    (
        { isCreate, role, data, setData, lists, meta }: EditProps,
        ref: ForwardedRef<HTMLDivElement>
    ) => {
        const permittedSections = sections.map((section) => ({
            ...section,
            fields: section.fields
                .filter(
                    (field) =>
                        meta.rights.write.includes(field.key) ||
                        meta.rights.read.includes(field.key)
                )
                .map((field) => ({
                    ...field,
                    disabled:
                        !meta.rights.write.includes(field.key) ||
                        field.disabled,
                })),
        }));
        const permittedYears = yearsObjectKeys.filter(
            (year) =>
                meta.rights.write.includes(year) ||
                meta.rights.read.includes(year)
        );
        const updateData = (
            parentKey: string,
            sectionKey: string,
            value: any
        ) => {
            const dataSectionObject = data[parentKey][sectionKey] as DataObject;
            const newSectionData = {
                ...data[parentKey],
                ...(typeof value === "object" ||
                typeof dataSectionObject === "string"
                    ? {
                        [sectionKey]: value,
                    }
                    : {
                        ...data[parentKey],
                        [sectionKey]: {
                            ...dataSectionObject,
                            value,
                        },
                    }),
            };
            setData((prev) => ({
                ...prev,
                [parentKey]: { ...newSectionData },
            }));
        };
        const groupsList = lists.groups.concat(lists.organizacie);
        return (
            <div
                ref={ref}
                style={{
                    display: "flex",
                    flexDirection: "column",
                    gap: "0.75rem",
                    flex: 1,
                }}
            >
                {permittedSections.map(
                    ({ open, fields, key: parentKey, name }) => {
                        const accordionProps = {
                            id: parentKey,
                            title: name,
                            open: fields.some((field) =>
                                meta.rights.write.includes(field.key)
                            ),
                            styles: {
                                borderRadius: "0.5rem",
                                backgroundColor: "#f5f5f5",
                            },
                            disabled: fields.length === 0,
                        };
                        const sectionData = fields.map((input) => ({
                            name: input.key,
                            label: input.name,
                            value:
                                input.key === "utvar_projektoveho_managera"
                                    ? (
                                    data[parentKey as any]
                                        .projektovy_manager as DataObject[]
                                )?.map((item) => {
                                    const groupsName = lists.users.find(
                                        (user) =>
                                            user.value === item.value
                                    )?.group_name;
                                    return lists.groups.find(
                                        (group) =>
                                            groupsName === group.value
                                    );
                                }) ?? []
                                    : input.key ===
                                    "utvar_magistratneho_garanta"
                                        ? lists.users.find(
                                        (user) =>
                                            (
                                                (data[parentKey as any]
                                                    .magistratny_garant as DataObject | null)?.value === user.value
                                            )
                                    )?.group_name ?? ""
                                        : data[parentKey as any][input.key as keyof typeof input],
                            setValue: (value: any) =>
                                updateData(parentKey, input.key, value),
                            multiline: input.multiline,
                            list: ["sprava", "udrzba"].includes(input.key)
                                ? groupsList
                                : lists[input.list as keyof typeof lists],
                            multiple: input.multiple,
                            disabled: (input as any).disabled,
                            gridColumn: input.gridColumn,
                            ...(input.key === "id_pp" && {
                                notAvailableIds: isCreate
                                    ? meta.notAvailableIds
                                    : [],
                            }),
                        })) as SectionProps["sectionData"];
                        console.log(fields);
                        const yearsData = Object.assign(
                            {},
                            ...yearsObjectKeys.map((key) => {
                                const object = data[key];
                                const objectKeys = Object.keys(object);
                                const objectYearsKey = objectKeys.find(
                                    (objectKey) => objectKey.includes("roky")
                                );
                                if (objectYearsKey) {
                                    return {
                                        [key]: object[objectYearsKey],
                                    };
                                }
                            })
                        ) as YearsDataObject;
                        return (
                            <Accordion key={name} {...accordionProps}>
                                {parentKey === "aktivity" ? (
                                    <Activities
                                        role={role}
                                        standard={
                                            data.aktivity
                                                .aktivity_standard as unknown as ActivityProps[]
                                        }
                                        vlastne={
                                            data.aktivity
                                                .aktivity_vlastne as unknown as ActivityProps[]
                                        }
                                        sectionData={sectionData}
                                        list={
                                            lists.aktivity as unknown as ActivitiesProps["list"]
                                        }
                                        categories={
                                            lists.aktivity_kategoria as ActivitiesProps["categories"]
                                        }
                                        users={
                                            lists.users as ActivitiesProps["users"]
                                        }
                                        setValue={(activityType, value) =>
                                            updateData(
                                                "aktivity",
                                                `aktivity_${activityType}`,
                                                value
                                            )
                                        }
                                        rights={meta.rights}
                                    />
                                ) : permittedYears.includes(parentKey) ? (
                                    <Years
                                        sectionData={sectionData}
                                        yearsData={yearsData[parentKey]}
                                        setValue={(value) =>
                                            updateData(
                                                parentKey,
                                                `${parentKey}_roky`,
                                                value
                                            )
                                        }
                                        isReadOnly={meta.rights.read.includes(
                                            parentKey
                                        )}
                                    />
                                ) : (
                                    <Section sectionData={sectionData} />
                                )}
                            </Accordion>
                        );
                    }
                )}
            </div>
        );
    }
);
