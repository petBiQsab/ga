import { modalState, modalStateInitial } from "../../store";
// Assets
import { toggleModal } from "./assets";
// Components
import { Icon } from "../icon/Icon";
import { LogOut } from "../auth/LogOut";

export const Modal = () => {
    const { type, title, content, onSubmit, submitTitle, onClose } =
        modalState.useState((state) => state);
    const onCloseModal = () => {
        toggleModal();
        modalState.setState(modalStateInitial);
        onClose && onClose();
    };
    const appHeaderHeight = "144px";
    const modalHeaderHeight = "56px";
    const modalFooterHeight = "89px";
    const borderStyle = { borderTop: "#e8e8e8 1px solid" };
    return (
        <dialog onClick={onCloseModal}>
            <form onSubmit={onSubmit} onClick={(e) => e.stopPropagation()}>
                <div style={{ display: "flex" }}>
                    <h3
                        style={{
                            fontFamily: "Open Sans",
                            fontWeight: 700,
                            fontSize: "1rem",
                            lineHeight: "1.5rem",
                            color: "#262626",
                            padding: "1rem 1.5rem",
                        }}
                    >
                        {title}
                    </h3>
                    <Icon
                        icon="close"
                        style={{
                            cursor: "pointer",
                            marginRight: "1.5rem",
                            marginLeft: "auto",
                        }}
                        onClick={onCloseModal}
                    />
                </div>
                <div
                    style={{
                        maxHeight: `calc(100vh - ${appHeaderHeight} - ${modalHeaderHeight} - ${
                            onSubmit ? modalFooterHeight : 0
                        })`,
                        padding: "1.25rem 1.5rem",
                        // overflow: "scroll",
                        ...borderStyle,
                    }}
                >
                    {content ?? <LogOut />}
                </div>
                {onSubmit && (
                    <div
                        style={{
                            display: "flex",
                            justifyContent: "flex-end",
                            padding: "1.5rem",
                            ...borderStyle,
                        }}
                    >
                        <button
                            type="button"
                            className="btn-cancel"
                            onClick={onCloseModal}
                        >
                            Zrušiť
                        </button>
                        <button
                            className="btn-primary"
                            type="submit"
                            style={{ marginLeft: "1rem" }}
                        >
                            {submitTitle ?? "Odoslať"}
                        </button>
                    </div>
                )}
            </form>
        </dialog>
    );
};
