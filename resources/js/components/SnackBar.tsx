import { useEffect } from "react";
import { snackBarState } from "../store";
// Components
import { Icon } from "./icon/Icon";

export const SnackBar = () => {
    const { open, message, type } = snackBarState.useState((state) => state);
    const hideSnackBar = () => {
        snackBarState.setState({ open: false, message, type });
    };
    useEffect(() => {
        if (open) {
            const timeout = setTimeout(
                hideSnackBar,
                message?.length * 100 ?? 0
            );
            return () => clearTimeout(timeout);
        }
    }, [open]);
    return (
        <div
            style={{
                position: "fixed",
                bottom: "1rem",
                left: 0,
                zIndex: 999,
            }}
        >
            <div
                style={{
                    visibility: open ? "visible" : "hidden",
                    display: "flex",
                    alignItems: "center",
                    transform: open
                        ? "translate3d(1rem, 0, 0)"
                        : "translate3d(-100%, 0, 0)",
                    transition: "transform 0.5s, visibility 0.5s",
                    backgroundColor: type === "success" ? "#000" : "#c5362e",
                    padding: "1rem",
                    borderRadius: "0.25rem",
                }}
            >
                <p
                    style={{
                        color: "#fff",
                    }}
                >
                    {message}
                </p>
                <Icon
                    icon="close"
                    style={{
                        color: "#fff",
                        marginLeft: "1rem",
                    }}
                    onClick={hideSnackBar}
                />
            </div>
        </div>
    );
};
