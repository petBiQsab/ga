import {
    type CSSProperties,
    type ReactNode,
    useEffect,
    useRef,
    useState,
} from "react";
// Types
type AccordionProps = {
    children: ReactNode | ReactNode[];
    id: string;
    title?: string;
    open?: boolean;
    disabled?: boolean;
    styles?: CSSProperties;
};

export const Accordion = ({
    children,
    id,
    title,
    open,
    disabled,
    styles,
}: AccordionProps) => {
    const ref = useRef<HTMLDivElement>(null);
    const [expanded, setExpanded] = useState(open);
    const handleToggleAccordion = (state?: boolean) => {
        // Update transition property (unable to use state in inline styles transition property)
        if (ref.current) {
            Object.assign(ref.current.style, {
                transition: `grid-template-rows ${transitionDuration}, border-color ${transitionDuration}${
                    expanded
                        ? ` ${Number(transitionDuration.slice(0, -1)) / 2}s`
                        : ""
                }`,
            });
            setExpanded(state ?? !expanded);
        }
    };
    useEffect(() => {
        if (!title) {
            handleToggleAccordion(open);
        }
    }, [open]);
    // Styles
    const transitionDuration = styles?.transitionDuration ?? "0.5s";
    const padding = (styles?.padding ?? "1rem 1.5rem") as string;
    const border = (styles?.border ?? "#d9d9d9 1px solid") as string;
    const borderColor = border.split(" ")[0];
    return (
        <div
            id={id}
            style={{
                transition: `all ${transitionDuration}`,
                backgroundColor: styles?.backgroundColor ?? "transparent",
                border,
                borderRadius: styles?.borderRadius ?? 0,
                ...(styles?.width && { width: styles?.width }),
                ...(styles?.margin && { margin: styles?.margin }),
                ...(disabled && {
                    pointerEvents: "none",
                    opacity: 0.3,
                }),
            }}
        >
            {title && (
                <p
                    style={{
                        transition: `all ${transitionDuration}`,
                        textAlign: styles?.textAlign ?? "left",
                        userSelect: "none",
                        cursor: "pointer",
                        fontWeight: 700,
                        fontSize: "1.25rem",
                        color: styles?.color ?? expanded ? "#000" : "#383636",
                        padding,
                    }}
                    onClick={() => handleToggleAccordion()}
                >
                    {title}
                </p>
            )}
            <div
                ref={ref}
                style={{
                    display: "grid",
                    gridTemplateRows: expanded ? "1fr" : "0fr",
                    transition: `gridTemplateRows ${transitionDuration}, borderColor ${transitionDuration} 0.25s`,
                    backgroundColor: styles?.backgroundColor ?? "transparent",
                    borderTop: border,
                    borderColor: expanded ? borderColor : "transparent",
                    borderBottomRightRadius: styles?.borderRadius ?? 0,
                    borderBottomLeftRadius: styles?.borderRadius ?? 0,
                }}
            >
                <div
                    style={{
                        overflow: "hidden",
                        transition: `margin ${transitionDuration}`,
                        margin: expanded
                            ? padding
                            : `0 ${padding.split(" ")[1]}`,
                    }}
                >
                    {children}
                </div>
            </div>
        </div>
    );
};
