import { Section, type SectionProps } from ".";
import { getPermittedActivities } from "../../assets";
// Components
import { Icon } from "../../../icon/Icon";
// Types
import { formatDate } from "../../../../lib/format";
import { DetailPops } from "../../../../src/types";
import { Activity } from "../../types";
type ActivitiesProps = {
    standard: Activity[];
    vlastne: Activity[];
    sectionData: SectionProps["sectionData"];
    rights: DetailPops["meta"]["rights"];
};

export const Activities = ({
    standard,
    vlastne,
    sectionData,
    rights,
}: ActivitiesProps) => {
    const activities = [...standard, ...vlastne];
    const headerStyles = {
        fontWeight: 600,
        lineHeight: 1.5,
        marginBottom: "0.25rem",
    };
    const dateBoxStyles = {
        display: "flex",
        alignItems: "center",
        marginBottom: "0.25rem",
    };
    const dateHeaderStyles = {
        ...headerStyles,
        marginBottom: 0,
        marginRight: "0.5rem",
    };
    const permittedActivities = getPermittedActivities(activities, rights);
    return (
        <>
            <Section sectionData={sectionData} />
            <div
                style={{
                    display: "flex",
                    flexDirection: "column",
                    gap: "0.5rem",
                    ...(permittedActivities.length && {
                        paddingTop: "1rem",
                        borderTop: "#d9d9d9 1px solid",
                        marginTop: "1rem",
                    }),
                }}
            >
                {activities.length ? (
                    permittedActivities.map(
                        (
                            {
                                koniec_aktivity,
                                skutocny_koniec_aktivity,
                                skutocny_zaciatok_aktivity,
                                value,
                                headerTitle,
                                zaciatok_aktivity,
                                zodpovedni,
                            },
                            index
                        ) => {
                            const persons = zodpovedni
                                .map(({ value }) => value)
                                .join(", ");
                            const getActivityDateIcon = (date: string) =>
                                new Date(date) > new Date()
                                    ? "circle"
                                    : (`${
                                          skutocny_zaciatok_aktivity ? "" : "in"
                                      }valid` as const);
                            const skutocnyZaciatokAktivityIcon =
                                getActivityDateIcon(skutocny_zaciatok_aktivity);
                            const skutocnyKoniecAktivityIcon =
                                getActivityDateIcon(skutocny_koniec_aktivity);
                            return (
                                <div
                                    key={index}
                                    style={{
                                        display: "grid",
                                        gridTemplateColumns: "2fr 1fr 1fr 1fr",
                                        backgroundColor: "#f5f5f5",
                                        padding: "0.75rem 1rem",
                                        borderRadius: "0.5rem",
                                    }}
                                >
                                    <div>
                                        <p style={headerStyles}>
                                            {value
                                                ? "Aktivita"
                                                : "Vlastná aktivita"}{" "}
                                            projektu
                                        </p>
                                        <p>{value as string}</p>
                                        <br />
                                        <p style={headerStyles}>Zodpovední</p>
                                        <p>{persons}</p>
                                    </div>
                                    <div>
                                        <p style={headerStyles}>Kategória</p>
                                        <p>
                                            {(headerTitle as { value: string })
                                                ?.value ??
                                                headerTitle ??
                                                ""}
                                        </p>
                                    </div>
                                    <div>
                                        <p style={headerStyles}>
                                            Plánovaný začiatok
                                        </p>
                                        <p>
                                            {formatDate(
                                                zaciatok_aktivity,
                                                "m.Y"
                                            )}
                                        </p>
                                        <br />
                                        <div style={dateBoxStyles}>
                                            <p style={dateHeaderStyles}>
                                                Reálny začiatok
                                            </p>
                                            <Icon
                                                icon={
                                                    skutocnyZaciatokAktivityIcon
                                                }
                                            />
                                        </div>
                                        <p>
                                            {formatDate(
                                                skutocny_zaciatok_aktivity,
                                                "m.Y"
                                            )}
                                        </p>
                                    </div>
                                    <div>
                                        <p style={headerStyles}>
                                            Plánovaný koniec
                                        </p>
                                        <p>
                                            {formatDate(koniec_aktivity, "m.Y")}
                                        </p>
                                        <br />
                                        <div style={dateBoxStyles}>
                                            <p style={dateHeaderStyles}>
                                                Reálny koniec
                                            </p>
                                            <Icon
                                                icon={
                                                    skutocnyKoniecAktivityIcon
                                                }
                                            />
                                        </div>
                                        <p>
                                            {formatDate(
                                                skutocny_koniec_aktivity,
                                                "m.Y"
                                            )}
                                        </p>
                                    </div>
                                </div>
                            );
                        }
                    )
                ) : (
                    <p>Zatiaľ neboli pridané žiadne aktivity</p>
                )}
            </div>
        </>
    );
};
