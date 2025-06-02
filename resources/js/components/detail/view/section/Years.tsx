import { formatCurrency } from "../../../../lib/format";
// Components
import { Section, type SectionProps } from ".";
// Types
type YearsProps = {
    sectionData: SectionProps["sectionData"];
    yearsData: {
        [key: string]: {
            id: number;
            rok: number;
            type: string;
            value: number;
        }[];
    };
};
export type YearsDataObject = { [key: string]: YearsProps["yearsData"] };
// Constants
export const yearsObjectKeys = [
    "kvalifikovany_odhad",
    "projektova_idea",
    "projektovy_zamer",
];
const titles = {
    roky: null,
    bv: "Bežné výdavky",
    kv: "Kapitálové výdavky",
    bp: "Bežné príjmy",
    kp: "Kapitálové príjmy",
};

export const Years = ({ sectionData, yearsData }: YearsProps) => {
    const entries = Object.entries(yearsData);
    const content = entries.map(([key, value]) => {
        return {
            title: titles[key as keyof typeof titles],
            values: [
                {
                    id: 1,
                    rok: "Celkom",
                    value: value.reduce((acc, curr) => acc + curr.value, 0),
                },
                ...value,
            ],
        };
    });
    return (
        <>
            {content.map(({ title, values }, index) => (
                <div
                    key={index}
                    style={{
                        display: "grid",
                        gridTemplateColumns: "repeat(4, 1fr)",
                        gap: "0.5rem",
                        backgroundColor: "#f5f5f5",
                        padding: "0.75rem 1rem",
                        borderRadius: "0.5rem",
                        marginBottom: "0.5rem",
                    }}
                >
                    {title && (
                        <p
                            style={{
                                gridColumn: "1 / -1",
                                fontSize: "18px",
                                fontWeight: 600,
                                marginBottom: "0.5rem",
                            }}
                        >
                            {title}
                        </p>
                    )}
                    {values.map(({ rok, value }, index) => (
                        <div
                            key={index}
                            style={{
                                gridColumn: index === 0 ? "1 / 3" : "auto",
                                backgroundColor: "#fff",
                                padding: "0.75rem",
                                borderRadius: "0.25rem",
                            }}
                        >
                            <p
                                style={{
                                    fontWeight: 600,
                                }}
                            >
                                {index === 1 && "do r. "}
                                {rok}
                            </p>
                            <p
                                style={{
                                    textAlign: "right",
                                }}
                            >
                                {formatCurrency(value, 0)}
                            </p>
                        </div>
                    ))}
                </div>
            ))}
            <Section sectionData={sectionData} />
        </>
    );
};
