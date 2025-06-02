import { Icon } from "../../../icon/Icon";

export const NoData = () => {
    return (
        <div
            style={{
                width: "fit-content",
                position: "sticky",
                top: "50%",
                left: "50%",
                transform: "translate(-50%, -50%)",
            }}
        >
            <div>
                <Icon icon="no-data" style={{ marginBottom: "1rem" }} />
                <p>Nie sú k dispozícii žiadne dáta.</p>
            </div>
        </div>
    );
};
