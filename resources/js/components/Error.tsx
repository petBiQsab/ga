import { CSSProperties } from "react";
type ErrorProps = {
    error?: Error;
};

export const Error = ({ error }: ErrorProps) => {
    const boxStyles = {
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        flexDirection: "column",
    } as CSSProperties;
    return (
        <div style={boxStyles}>
            <div
                style={{
                    ...boxStyles,
                    alignItems: "flex-start",
                    justifyContent: "flex-start",
                    padding: "1.5rem 2rem",
                }}
            >
                <h1
                    style={{
                        fontSize: "1.5rem",
                        fontWeight: 500,
                    }}
                >
                    Chyba aplikácie
                </h1>
                {error && (
                    <p
                        style={{
                            color: "#c5362e",
                            padding: "1rem",
                            borderTop: "#c5362e 1px solid",
                            borderBottom: "#c5362e 1px solid",
                            margin: "1rem 0",
                        }}
                    >
                        {error.message ?? "Nastala chyba pri načítaní údajov"}
                    </p>
                )}
                <p
                    style={{
                        fontSize: "1rem",
                        ...(!error && {
                            borderTop: "#c5362e 1px solid",
                            paddingTop: "0.5rem",
                            marginTop: "0.5rem",
                        }),
                    }}
                >
                    Kontaktujte správcu systému
                </p>
            </div>
        </div>
    );
};
