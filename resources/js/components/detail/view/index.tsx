import { type ForwardedRef, forwardRef } from "react";
import { sections } from "../assets";
// Components
import { Accordion } from "../../Accordion";
import { Section, type SectionProps } from "./section";
import { Activities } from "./section/Activities";
import { Years, yearsObjectKeys, type YearsDataObject } from "./section/Years";
// Types
import { DataObject, DetailPops } from "../../../src/types";
import { Activity } from "../types";
type ViewProps = {
    data: DetailPops["data"];
    lists: {
        [key: string]: DataObject[];
    };
    rights: DetailPops["meta"]["rights"];
};

export const View = forwardRef(
    ({ data, lists, rights }: ViewProps, ref: ForwardedRef<HTMLDivElement>) => {
        const permittedSections = sections.map((section) => ({
            ...section,
            fields: section.fields.filter(
                (field) =>
                    rights.write.includes(field.key) ||
                    rights.read.includes(field.key)
            ),
        }));
        const permittedYears = yearsObjectKeys.filter(
            (year) => rights.write.includes(year) || rights.read.includes(year)
        );
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
                            open: open && fields.length > 0,
                            styles: {
                                borderRadius: "0.5rem",
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
                                    : input.key === "utvar_magistratneho_garanta"
                                        ? lists.users.find((user) =>(
                                            (data[parentKey as any].magistratny_garant as DataObject | null)?.value === user.value)
                                    )?.group_name ?? ""    : data[parentKey as any]
                                    [input.key as keyof typeof input],
                        })) as SectionProps["sectionData"];
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
                                        standard={
                                            data.aktivity
                                                .aktivity_standard as unknown as Activity[]
                                        }
                                        vlastne={
                                            data.aktivity
                                                .aktivity_vlastne as unknown as Activity[]
                                        }
                                        sectionData={sectionData}
                                        rights={rights}
                                    />
                                ) : permittedYears.includes(parentKey) ? (
                                    <Years
                                        sectionData={sectionData}
                                        yearsData={yearsData[parentKey]}
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
