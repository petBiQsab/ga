import { type ComponentProps, useRef, useState } from "react";
import { toggleModal } from "../modal/assets";
import { modalState } from "../../store";
import { fetcher } from "../../lib/api";
// Components
import { EditSubmit } from "./edit/EditSubmit";
import { RGPSubmit } from "./edit/RGPSubmit";
import { Navigation } from "./Navigation";
import { Header } from "./header";
import { Edit } from "./edit";
import { View } from "./view";
// Types
import { DataObject, DetailPops } from "../../src/types";

export const Detail = ({ user, data, meta, slug, query }: DetailPops) => {
    const { lists, ...rest } = data;
    const stateDefault = meta.nextAvailableId
        ? {
            ...rest,
            zakladne_informacie: {
                ...rest.zakladne_informacie,
                id_pp: meta.nextAvailableId,
            },
        }
        : rest;
    const [state, setState] = useState(stateDefault);
    const [submit, setSubmit] = useState(false);

    const post = async () => {
        setSubmit(true);
        let manuallyClosed = false; // Track manual closure

        // Submit the data to the backend
        const { status } = await fetcher("detail", state);
        toggleModal();

        const handleModalClose = () => {
            manuallyClosed = true; // Mark as manually closed
            setSubmit(false); // Ensure submit state is reset
        };

        // Display the modal with success or failure message
        modalState.setState({
            type: "edit-submit",
            title: status === 201 ? "Odoslané" : "Neodoslané",
            content: (
                <EditSubmit
                    description={
                        status === 201
                            ? "Zmeny boli úspešne uložené"
                            : status === 202
                                ? "Neboli vykonané žiadne zmeny v projekte"
                                : "Zmeny neboli uložené"
                    }
                />
            ),
            onClose: handleModalClose,
        });

        // Automatically close the modal after 1.5 seconds if not manually closed
        setTimeout(() => {
            if (!manuallyClosed) {
                setSubmit(false);
                toggleModal();
            }
        }, 1500); // 1500ms = 1.5 seconds
    };

    // Content
    const isEdit = (!slug || query?.hasOwnProperty("edit")) ?? false;
    const ContentTag = isEdit ? "form" : "div";
    const sectionsWrapper = useRef<HTMLDivElement>(null);
    // Props
    const headerProps: ComponentProps<typeof Header> = {
        role: user.role,
        updatedAt: data.zakladne_informacie.updated_at as string,
        updatedBy: data.zakladne_informacie.updated_by as string,
        weekNumber: (data.interne_udaje.mtl as DataObject).week_num as number,
        mtlState: (data.interne_udaje.mtl as DataObject).state as number,
        mtlValue: (data.interne_udaje.mtl as DataObject).value as string,
        mtlReporting: data.interne_udaje.reportingIsON as number,
        id: data.zakladne_informacie.id_original as number,
        id_interne: data.zakladne_informacie.id_pp as number,
        isEdit,
        title:
            (data.zakladne_informacie?.nazov_projektu as string) ??
            "Nový projekt",
        owner: {
            dateTimeFrom: "2023-09-13T09:00:00.000Z",
            name: "Peter Repka",
            role: "Editor",
        },
        post,
        submit,
    };

    console.log(data.interne_udaje.reporting);

    const editProps: ComponentProps<typeof Edit> = {
        ref: sectionsWrapper,
        isCreate: !slug,
        role: user.role,
        data: state,
        setData: setState,
        lists: lists as { [key: string]: DataObject[] },
        meta,
    };
    const viewProps: ComponentProps<typeof View> = {
        ref: sectionsWrapper,
        data: state,
        lists: lists as { [key: string]: DataObject[] },
        rights: meta.rights ?? { read: [], write: [] },
    };
    const navigationProps: ComponentProps<typeof Navigation> = {
        ref: sectionsWrapper,
        atl: (state.terminy_projektu.atl as string) ?? "",
        mtl:
            (typeof state.aktivity.mtl === "string"
                ? state.aktivity.mtl
                : ((state.aktivity.mtl as DataObject)?.value as string)) ?? "",
    };
    return (
        <section>
            <Header {...headerProps} />
            <ContentTag data-submit={submit} className="detail">
                {isEdit ? <Edit {...editProps} /> : <View {...viewProps} />}
                <Navigation {...navigationProps} />
            </ContentTag>
        </section>
    );
};
