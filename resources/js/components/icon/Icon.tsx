import { icons } from "./icons";
// Types
import { CSSProperties } from "react";
type IconProps = {
    icon: (typeof icons)[number]["name"];
    style?: CSSProperties;
    onClick?: () => void;
};

export const Icon = ({ icon, style, onClick }: IconProps) => {
    const currentIcon = icons.find(({ name }) => name === icon);
    if (!currentIcon) {
        return null;
    }
    const [width, height] = currentIcon.dimensions;
    return (
        <div
            style={{
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
                ...style,
                ...(onClick && {
                    cursor: "pointer",
                }),
            }}
            onClick={onClick}
        >
            <svg
                width={width}
                height={height}
                viewBox={`0 0 ${width} ${height}`}
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                {currentIcon.paths.map((path, index) => (
                    <path
                        key={index}
                        d={path.d}
                        {...(icon === "no-data"
                            ? {
                                  stroke: path.color,
                                  strokeWidth: "3",
                                  strokeMiterlimit: "10",
                                  strokeLinecap: "round",
                                  strokeLinejoin: "round",
                              }
                            : {
                                  fill: style?.color ?? path.color,
                                  ...(icon === "logo" && {
                                      clipRule: "evenodd",
                                      fillRule: "evenodd",
                                  }),
                              })}
                    />
                ))}
            </svg>
        </div>
    );
};
