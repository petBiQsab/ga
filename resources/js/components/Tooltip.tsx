import {
    type MouseEvent,
    type ReactNode,
    useCallback,
    useEffect,
    useRef,
    useState,
    type CSSProperties,
} from "react";
// Types
type TooltipProps = {
    children: ReactNode | ReactNode[];
    value?: string;
    alignment?: "left" | "right" | "auto";
    isOpen?: boolean;
    isNotificationType?: "info" | "warning";
    isNotificationCallback?: () => void;
    delay?: number;
    offsetTop?: number;
    offsetLeft?: number;
    wrapperStyles?: CSSProperties;
};

export const Tooltip = ({
    children,
    value,
    alignment = "auto",
    isOpen,
    isNotificationType = "info",
    isNotificationCallback,
    delay = 250,
    offsetTop = 0,
    offsetLeft = 0,
    wrapperStyles,
}: TooltipProps) => {
    if (!value) return children;
    const parentElementRef = useRef<HTMLDivElement | null>(null);
    const tooltipContainerRef = useRef<HTMLDivElement | null>(null);
    const [show, setShow] = useState(false);
    const [position, setPosition] = useState({ top: 0, left: 0 });
    const timeoutRef = useRef<number | null>(null);
    const updatePosition = useCallback(() => {
        if (parentElementRef.current) {
            const { height, top, right, left } =
                parentElementRef.current.getBoundingClientRect();
            const tooltipWidth = tooltipContainerRef.current?.offsetWidth ?? 0;
            // Get top position, add padding and custom offset (if any)
            const tooltipTop = top + height + 4 + offsetTop;
            const alignLeft = left + offsetLeft;
            const alignRight = right - tooltipWidth - offsetLeft;
            const tooltipLeft =
                alignment === "auto"
                    ? left <= tooltipWidth
                        ? // If tooltip is too close to the left edge, set it to the left edge
                          alignLeft
                        : // Otherwise, set it to the right edge
                          alignRight
                    : alignment === "left"
                    ? alignLeft
                    : alignRight;
            setPosition({
                top: tooltipTop,
                left: tooltipLeft,
            });
        }
    }, [offsetLeft, offsetTop, parentElementRef.current, setPosition]);
    const toggle = useCallback(
        (e: MouseEvent<HTMLDivElement>) => {
            if (isOpen === undefined) {
                const tooltipMounted =
                    tooltipContainerRef.current?.parentNode === document.body;
                if (parentElementRef.current && tooltipContainerRef.current) {
                    if (!show) {
                        updatePosition();
                    }
                    if (!tooltipMounted) {
                        document.body.appendChild(tooltipContainerRef.current);
                    }
                    if (e.type === "mouseenter") {
                        timeoutRef.current = setTimeout(
                            () => setShow(true),
                            delay
                        );
                    } else {
                        if (timeoutRef.current) {
                            clearTimeout(timeoutRef.current);
                            setTimeout(() => {
                                if (tooltipMounted) {
                                    (
                                        parentElementRef.current as HTMLDivElement
                                    ).appendChild(
                                        tooltipContainerRef.current as HTMLDivElement
                                    );
                                }
                            }, delay);
                        }
                        setShow(false);
                    }
                }
            }
        },
        [show, setShow, timeoutRef, updatePosition]
    );
    const { top, left } = position;
    // I is notification
    useEffect(() => {
        updatePosition();
        setShow(!!isOpen);
    }, [isOpen]);
    return (
        <div
            ref={parentElementRef}
            style={wrapperStyles}
            onMouseEnter={toggle}
            onMouseLeave={toggle}
            onClick={toggle}
        >
            {children}
            <div
                ref={tooltipContainerRef}
                className={`tooltip ${
                    show ? "show" : ""
                } ${isNotificationType}`}
                style={{
                    top,
                    left,
                    pointerEvents: isOpen ? "all" : "none",
                }}
            >
                <div onClick={isNotificationCallback}>
                    <p
                        dangerouslySetInnerHTML={{
                            __html: value,
                        }}
                    />
                </div>
            </div>
        </div>
    );
};
