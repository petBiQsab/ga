import { ReactNode, useSyncExternalStore } from "react";
// Store
const createStore = <StoreType>(initialState: StoreType) => {
    // Initial state
    let currentState = initialState;
    const listeners = new Set<(state: StoreType) => void>();
    // Methods
    const getState = () => currentState;
    const setState = (newState: StoreType) => {
        currentState = newState;
        listeners.forEach((listener) => listener(currentState));
    };
    const subscribe = (listener: (state: StoreType) => void) => {
        listeners.add(listener);
        return () => listeners.delete(listener);
    };
    const useState = <SelectorOutput>(
        selector: (state: StoreType) => SelectorOutput
    ): SelectorOutput =>
        useSyncExternalStore(
            subscribe,
            () => selector(currentState),
            () => selector(initialState)
        );
    return {
        getState,
        setState,
        useState,
    };
};
// Modal state
type ModalType = {
    type: "ask-for-change" | "edit-submit" | null;
    title: string;
    content: ReactNode | ReactNode[] | null;
    onSubmit?: (e: React.FormEvent<HTMLFormElement>) => void;
    submitTitle?: string;
    onClose?: () => void;
};
export const modalStateInitial = {
    type: null,
    title: "Odhlásenie",
    content: null,
};
export const modalState = createStore<ModalType>(modalStateInitial);
// Drawer state
const drawerStateInitial = {
    open: false,
    position: "right",
};
export const drawerState = createStore(drawerStateInitial);
export const toggleDrawer = () => {
    drawerState.setState({
        open: !drawerState.getState().open,
        position: drawerState.getState().position,
    });
};
// SnackBar state
const snackBarStateInitial = {
    open: false,
    message: "",
    type: "success",
};
export const snackBarState = createStore(snackBarStateInitial);

export const notImplemented = () =>
    snackBarState.setState({
        open: true,
        message: "Funkcia nie je dostupná v aktuálnej verzii.",
        type: "error",
    });
