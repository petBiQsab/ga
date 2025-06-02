export const toggleModal = () =>
    document
        .querySelectorAll("dialog")
        .forEach((dialog) =>
            dialog.open ? dialog.close() : dialog.showModal()
        );
