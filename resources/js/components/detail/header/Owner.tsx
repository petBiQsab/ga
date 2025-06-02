// import { useState, useEffect } from "react";
// Types
import { Owner as OwnerType } from ".";

export const Owner = ({ dateTimeFrom, name, role }: OwnerType) => {
    // const editingForBase = new Date() - new Date(dateTimeFrom);
    // const [editingFor, setEditingFor] = useState(editingForBase);
    // // Increase editingFor each minute
    // useEffect(() => {
    //     const interval = setInterval(() => {
    //         setEditingFor((editingFor) => editingFor + 60_000);
    //     }, 60_000);
    //     return () => clearInterval(interval);
    // }, []);
    // // Calculate editingFor values
    // const editingForDays = Math.floor(editingFor / 1_000 / 60 / 60 / 24);
    // const editingForHours = Math.floor(editingFor / 1_000 / 60 / 60) % 24;
    // const editingForMinutes = Math.floor(editingFor / 1_000 / 60) % 60;
    // const editingForSeconds = Math.floor(editingFor / 1_000) % 60;
    // const editingForValues = [
    //     [editingForHours, "hod"],
    //     [editingForMinutes, "min"],
    // ].filter(([value]) => value);
    const boxStyles = {
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
    };
    return (
        <div
            style={{
                paddingRight: "1.5rem",
                borderRight: "#e8e8e8 1px solid",
                marginLeft: "auto",
                marginRight: "0.5rem",
                ...boxStyles,
            }}
        >
            <div
                style={{
                    width: "2.5rem",
                    height: "2.5rem",
                    backgroundColor: "#b75752",
                    borderRadius: "50%",
                    marginRight: "0.75rem",
                    ...boxStyles,
                }}
            >
                <p
                    style={{
                        color: "#fff",
                    }}
                >
                    {name.split(" ").map((word) => word[0])}
                </p>
            </div>
            <div>
                <p
                    style={{
                        fontSize: "14px",
                        fontWeight: 600,
                    }}
                >
                    {name}
                </p>
                <p
                    style={{
                        fontSize: "0.75rem",
                        color: "#595959",
                    }}
                >
                    {/* {role},{" "}
                    {editingForValues.map(([value, unit], index) => (
                        <span key={index}>
                            {value} {unit}{" "}
                        </span>
                    ))} */}
                    aktuálne upravuje projekt
                </p>
            </div>
        </div>
    );
};
