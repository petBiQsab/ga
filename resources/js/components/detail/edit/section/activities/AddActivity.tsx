import { Icon } from "../../../../icon/Icon";
// Types
type AddActivityProps = { title: string; addActivity?: () => void };

export const AddActivity = ({ title, addActivity }: AddActivityProps) => {
    return (
        <div
            style={{
                cursor: "pointer",
                display: "flex",
                alignItems: "center",
                gap: "0.5rem",
                margin: "0.5rem 0",
            }}
            onClick={addActivity}
        >
            <Icon
                icon="close"
                style={{
                    transform: "rotate(45deg) scale(0.81)",
                    color: "#262626",
                    padding: "6px",
                    border: "#262626 1px solid",
                    borderRadius: "50%",
                }}
            />
            <p
                style={{
                    fontSize: "14px",
                    fontWeight: 600,
                }}
            >
                {title}
            </p>
        </div>
    );
};
