import { ReactNode } from "react";
type RouteHeaderWrapperProps = {
    children: ReactNode | ReactNode[];
    disabled?: boolean;
};

export const RouteHeaderWrapper = ({
                                       children,
                                       disabled,
                                   }: RouteHeaderWrapperProps) => {
    return (
        <div
            style={{
                zIndex: 1,
                display: "flex",
                flexFlow: "column wrap",
                userSelect: "none",
                backgroundColor: "#fff",
                boxShadow: "0px 2px 8px rgba(0, 0, 0, 0.15)",
                padding: "var(--section-header-padding)",
                ...(disabled && {
                    pointerEvents: "none",
                }),
            }}
        >
            {children}
        </div>
    );
};
