import { modalState, snackBarState } from "../../../store";
// Assets
import { toggleModal } from "../../modal/assets";
import { fetcher } from "../../../lib/api";
import { formatDate } from '../../../lib/format';
// Components
import { EditSubmit } from "../edit/EditSubmit";
import { RouteHeaderWrapper } from "../../RouteHeaderWrapper";
import { Tooltip } from "../../Tooltip";
import { Icon } from "../../icon/Icon";
import { Loader } from "../../Loader";
import { Owner } from "./Owner";
// Types
import { FormEvent } from "react";
import {AMtlColors} from "../AMtlColors";
export type Owner = {
    dateTimeFrom: string;
    name: string;
    role: string;
};
type HeaderProps = {
    role: string,
    id: number,
    id_interne: number,
    updatedAt: string,
    updatedBy: string,
    weekNumber: number,
    mtlState: number,
    mtlValue: string,
    mtlReporting: number,
    isEdit: boolean,
    title: string,
    owner: Owner,
    post: () => void,
    submit: boolean
};

export const Header = ({
                           role,
                           id,
                           id_interne,
                           updatedAt,
                           updatedBy,
                           weekNumber,
                           mtlState,
                           mtlValue,
                           mtlReporting,
                           isEdit,
                           title,
                           owner,
                           post,
                           submit,
                       }: HeaderProps) => {
    const toggleEdit = () => {
        const { origin, pathname } = window.location;
        window.location.replace(`${origin}${pathname}${isEdit ? "" : "?edit"}`);
    };
    const deleteProject = () => {
        toggleModal();
        modalState.setState({
            type: "edit-submit",
            title: "Vymazať projekt",
            content: (
                <EditSubmit description="Naozaj chcete zmazať tento projekt?" />
            ),
            onSubmit: async (e: FormEvent<HTMLFormElement>) => {
                e.preventDefault();
                const { status } = await fetcher("delete", {
                    zakladne_informacie: { id_original: id },
                });
                if (status === 200) {
                    window.location.href = "/pracovisko";
                } else {
                    snackBarState.setState({
                        open: true,
                        message: "Projekt sa nepodarilo vymazať",
                        type: "error",
                    });
                }
            },
            submitTitle: "Vymazať",
        });
    };
    return (
        <RouteHeaderWrapper disabled={submit}>
            {/* First div remains unchanged */}
            <div
                style={{
                    display: "flex",
                    gap: "1rem",
                }}
            >
                <h1>({id_interne}) {title}</h1>

                <div
                    style={{
                        display: "flex",
                        gap: "1rem",
                        marginLeft: "auto",
                    }}
                >
                    {isEdit && (
                        <button className="btn-primary" onClick={post}>
                            {submit ? (
                                <Loader
                                    styles={{
                                        margin: "auto 0",
                                    }}
                                />
                            ) : (
                                "Uložiť"
                            )}
                        </button>
                    )}
                    {[
                        "Administrátor",
                        "Supervízia projektov",
                        "Projektové vedenie",
                        "Procesný partner",
                    ].includes(role) && (
                        <Tooltip
                            value={
                                isEdit
                                    ? undefined
                                    : "Formulár je možné upravovať až po uložení predchádzajúcim editorom."
                            }
                        >
                            <button
                                className={`btn-${
                                    isEdit ? "secondary" : "primary"
                                }`}
                                onClick={toggleEdit}
                            >
                                {isEdit ? "Zatvoriť" : "Upraviť"}
                            </button>
                        </Tooltip>
                    )}
                    {role === "Administrátor" && (
                        <button
                            className="btn-secondary"
                            style={{
                                color: "#c5362e",
                                borderColor: "#c5362e",
                            }}
                            onClick={deleteProject}
                        >
                            Vymazať
                        </button>
                    )}
                    <Tooltip value="Vygenerovať RGP report.">
                        <a
                            href={`/export/rgp/${id}`}
                            target="_blank"
                            className="btn-secondary"
                            style={{
                                width: 42,
                                cursor: "pointer",
                            }}
                        >
                            <Icon icon="export-csv"/>
                        </a>
                    </Tooltip>
                </div>
            </div>

            {/* Add a new div stacked below the first div */}
            <div
                style={{
                    marginTop: "0.5rem",
                    textAlign: "left", // Adjust text alignment as needed
                    padding: "5px 0px",
                    fontSize: "16px",
                }}
            >


                <div style={{padding: "10px 0px"}}>
                    <span style={{fontWeight: "bold"}}>Dátum poslednej aktualizácie projektu:</span>
                    <span style={{marginLeft: "5px"}}>{formatDate(updatedAt, "d.m.Y H:M")}</span>
                    {updatedBy && (
                        <span
                            style={{
                                borderRadius: "0.25rem",
                                color: "rgb(51, 51, 51)",
                                padding: "3px 6px",
                                marginLeft: "10px",
                                backgroundColor: "rgb(232, 232, 232)",
                            }}
                        >
                         {updatedBy}
                    </span>
                    )}

                    {mtlReporting !== undefined && mtlReporting !== null ? (
                        mtlReporting === 1 ? (
                            <>
                                <span style={{ fontWeight: "bold", marginLeft: "15px" }}>Stav projektu:</span>
                                {mtlState === 0 ? (
                                    <span style={{ marginLeft: "5px" }}>Nezreportované ({weekNumber}. týždeň)</span>
                                ) : (
                                    <>
                                        <div style={{ display: "inline-block", marginLeft: "10px" }}>
                                            <AMtlColors color={mtlValue} hidetooltip />
                                        </div>
                                        <span style={{ marginLeft: "5px" }}>
                        Zreportované ({weekNumber}. týždeň)
                    </span>
                                    </>
                                )}
                            </>
                        ) : null
                    ) : null}

                </div>

            </div>
        </RouteHeaderWrapper>
    );
};
