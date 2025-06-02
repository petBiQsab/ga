import { type CSSProperties, type ReactNode, useMemo } from "react";
import { drawerState, toggleDrawer } from "../store";
// Types
type DrawerProps = {
    // open: boolean;
    // setOpen: (open: boolean) => void;
    children: ReactNode | ReactNode[];
    // position?: "left" | "right";
    duration?: number;
    size?: number;
};

export const Drawer = ({
    // open,
    // setOpen,
    children,
    // position = "left",
    duration = 300,
    size = 360,
}: DrawerProps) => {
    const { open, position } = drawerState.useState((state) => state);
    const drawerStyles = useMemo(
        () => ({
            width: ["left", "right"].includes(position)
                ? `min(100%, ${size}px)`
                : "100%",
            height: ["top", "bottom"].includes(position) ? size : "100%",
            visibility: open ? "visible" : "hidden",
            marginTop: "4.5rem",
            position: "fixed",
            zIndex: 11,
            boxShadow: "0 0 8px 4px rgba(0, 0, 0, 0.1)",
            backgroundColor: "#fff",
            transform: open
                ? "translate3d(0, 0, 0)"
                : position === "left"
                ? "translate3d(-100%, 0, 0)"
                : position === "right"
                ? "translate3d(100%, 0, 0)"
                : position === "bottom"
                ? "translate3d(0, 100%, 0)"
                : "translate3d(0, -100%, 0)",
            transition: `all ${duration}ms`,
            ...(position === "bottom"
                ? {
                      bottom: 0,
                  }
                : {
                      top: 0,
                  }),
            ...(position !== "right" && {
                left: 0,
            }),
            ...(position !== "left" && {
                right: 0,
            }),
        }),
        [position, open, size]
    ) as CSSProperties;
    return (
        <div>
            <input
                type="checkbox"
                checked={open}
                style={{
                    display: "none",
                }}
                onChange={toggleDrawer}
            />
            <aside style={drawerStyles}>{children}</aside>
            <label
                style={{
                    width: "100%",
                    height: "100%",
                    position: "fixed",
                    zIndex: open ? 9 : 0,
                    opacity: open ? 0.36 : 0,
                    transition: `all ${duration}ms ease-in-out`,
                    backgroundColor: "#000",
                    ...(!open && {
                        pointerEvents: "none",
                    }),
                }}
                onClick={toggleDrawer}
            />
        </div>
    );
};
