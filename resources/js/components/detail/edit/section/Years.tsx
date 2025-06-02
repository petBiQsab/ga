import { formatCurrency } from "../../../../lib/format";
// Components
import { Input } from "../../../Input";
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
    setValue: (value: any) => void;
    isReadOnly?: boolean;
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

export const Years = ({
    sectionData,
    yearsData,
    setValue,
    isReadOnly,
}: YearsProps) => {
    const entries = Object.entries(yearsData);
    const content = entries.map(([key, value]) => {
        return {
            key,
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
    const updateValue = (
        key: string,
        year: string | number,
        value: string | number
    ) => {
        const newValues = yearsData[key].map((item) => {
            if (item.rok === Number(year)) {
                return {
                    ...item,
                    value: Number(value),
                };
            }
            return item;
        });
        const newYearsData = {
            ...yearsData,
            [key]: newValues,
        };
        setValue(newYearsData);
    };
    return (
        <>
            {content.map(({ key, title, values }, index) => (
                <div
                    key={index}
                    style={{
                        display: "grid",
                        gridTemplateColumns: "repeat(4, 1fr)",
                        gap: "0.5rem",
                        backgroundColor: "#e8e8e8",
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
                                borderRadius: "0.25rem",
                            }}
                        >
                            <p
                                style={{
                                    fontWeight: 600,
                                    padding: "0.75rem 0.75rem 0.25rem",
                                    ...(isReadOnly && {
                                        opacity: 0.63,
                                    }),
                                }}
                            >
                                {index === 1 && "do r. "}
                                {rok}
                            </p>
                            {index === 0 ? (
                                <p
                                    style={{
                                        textAlign: "right",
                                        padding: "0.75rem",
                                        marginTop: "calc(0.5rem + 1px)",
                                        ...(isReadOnly && {
                                            opacity: 0.63,
                                        }),
                                    }}
                                >
                                    {formatCurrency(value, 0)}
                                </p>
                            ) : (
                                <Input
                                    name={"name"}
                                    value={value ?? 0}
                                    setValue={updateValue.bind(null, key, rok)}
                                    type="number"
                                    isYearsInput
                                    disabled={isReadOnly}
                                />
                            )}
                        </div>
                    ))}
                </div>
            ))}
            <Section sectionData={sectionData} />
        </>
    );
};
