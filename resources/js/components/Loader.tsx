import { CSSProperties } from "react";
type LoaderProps = {
    color?: string;
    styles?: CSSProperties;
};

export const Loader = ({ color, styles }: LoaderProps) => {
    const dots = [
        "ellipsis-first",
        "ellipsis-mid",
        "ellipsis-mid",
        "ellipsis-last",
    ];
    return (
        <div
            style={{
                width: "72px",
                height: "12px",
                position: "relative",
                ...styles,
            }}
        >
            {dots.map((name, index) => (
                <div
                    key={index}
                    style={{
                        width: "12px",
                        height: "12px",
                        position: "absolute",
                        top: 0,
                        left: `${
                            index > 1 ? (index > 2 ? "54" : "30") : "6"
                        }px`,
                        animation: `${name} 0.6s infinite`,
                        animationTimingFunction: "ease-in-out",
                        backgroundColor: color ?? "#fff",
                        borderRadius: "50%",
                    }}
                />
            ))}
        </div>
    );
};
