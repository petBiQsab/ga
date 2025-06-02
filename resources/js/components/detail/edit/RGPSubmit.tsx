import { useState } from "react";
// Types
type RGPSubmitProps = {
    consent: string;
    consentAction: () => void;
    disagreement: string;
    disagreementAction: () => void;
};

export const RGPSubmit = ({
    consent,
    consentAction,
    disagreement,
    disagreementAction,
}: RGPSubmitProps) => {
    const [submit, setSubmit] = useState(false);
    const actions = [
        {
            description: consent,
            action: consentAction,
        },
        {
            description: disagreement,
            action: disagreementAction,
        },
    ];
    return (
        <div
            style={{
                display: "flex",
                flexDirection: "column",
                gap: "1rem",
                ...(submit && {
                    pointerEvents: "none",
                    opacity: 0.36,
                }),
            }}
        >
            {actions.map(({ description, action }, index) => (
                <div
                    key={index}
                    style={{
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "space-between",
                        gap: "1rem",
                    }}
                >
                    <p>{description}</p>
                    <button
                        type="button"
                        className="btn-primary"
                        onClick={() => {
                            setSubmit(true);
                            action();
                        }}
                    >
                        Potvrdiť
                    </button>
                </div>
            ))}
        </div>
    );
};
