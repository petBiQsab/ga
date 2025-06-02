import { getRygColor } from "../../../../lib/data";
// Components
import { Column } from "../..";
import { Tooltip } from "../../../Tooltip";
type RowProps = {
    columns: Column[];
    index: number;
    value: string;
    width: number;
    isCurrency?: boolean;
    isLights: boolean;
    atlColor?: string;
    mtlColor?: string;
    isRyg?: boolean;
};

export const Row = ({
    columns,
    index,
    value,
    width,
    isCurrency,
    isLights,
    atlColor,
    mtlColor,
    isRyg,
}: RowProps) => {
    const lights = [atlColor, mtlColor];
    return (
        <div
            style={{
                width,
                display: "flex",
                ...((index === 1 || index === 2) && {
                    left:
                        index === 1
                            ? columns[0].width
                            : columns[0].width + columns[1].width,
                }),
                ...(index !== columns.length - 1 && {
                    borderRight: "#bfbfbf 1px solid",
                }),
                ...(value.includes("span") && {
                    backgroundColor: "#f6eeee",
                }),
            }}
        >
            {isLights ? (
                <div
                    style={{
                        display: "flex",
                        gap: "0.5rem",
                        marginTop: "2px",
                    }}
                >
                    {lights.map((color, index) => (
                        <Tooltip
                            key={index}
                            value={`${
                                index === 0 ? "Termínový" : "Projektový"
                            } semafor`}
                        >
                            <div
                                style={{
                                    width: "0.75rem",
                                    height: "0.75rem",
                                    backgroundColor: color ?? "transparent",
                                    borderRadius: "50%",
                                    ...(!color && {
                                        border: "1px solid #bfbfbf",
                                    }),
                                }}
                            />
                        </Tooltip>
                    ))}
                </div>
            ) : (
                <p
                    dangerouslySetInnerHTML={{
                        __html: value,
                    }}
                    style={{
                        ...(isCurrency && {
                            marginLeft: "auto",
                        }),
                        ...(isRyg && {
                            color: getRygColor(value),
                        }),
                    }}
                />
            )}
        </div>
    );
};
