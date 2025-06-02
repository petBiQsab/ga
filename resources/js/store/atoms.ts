import { useSyncExternalStore } from "react";
// Types
type Atom<AtomType> = {
    get: () => AtomType;
    set: (newValue: AtomType) => void;
    subscribe: (callback: (newValue: AtomType) => void) => () => void;
    _subscribers: () => number;
};
type AtomGetter<AtomType> = (
    get: <Target>(a: Atom<Target>) => Target
) => AtomType;
// Atom
export const atom = <AtomType>(
    initialValue: AtomType | AtomGetter<AtomType>
): Atom<AtomType> => {
    let value: AtomType =
        typeof initialValue === "function" ? (null as AtomType) : initialValue;
    // Set to store subscribers
    const subscribers = new Set<(newValue: AtomType) => void>();
    const subscribed = new Set<Atom<any>>();
    // Function to get the current value
    const get = <Target>(atom: Atom<Target>) => {
        let currentValue = atom.get();
        if (!subscribed.has(atom)) {
            subscribed.add(atom);
            atom.subscribe(function (newValue) {
                if (currentValue === newValue) return;
                currentValue = newValue;
                computeValue();
            });
        }
        return currentValue;
    };
    // Function to compute the value
    const computeValue = async () => {
        const newValue =
            typeof initialValue === "function"
                ? (initialValue as AtomGetter<AtomType>)(get)
                : value;
        value = null as AtomType;
        value = await newValue;
        subscribers.forEach((callback) => callback(value));
    };
    computeValue();
    // Return the Atom
    return {
        get: () => value,
        set: (newValue) => {
            value = newValue;
            computeValue();
        },
        subscribe: (callback) => {
            subscribers.add(callback);
            return () => {
                subscribers.delete(callback);
            };
        },
        _subscribers: () => subscribers.size,
    };
};
// useAtom hook [get, set]
export const useAtom = <AtomType>(
    atom: Atom<AtomType>
): [AtomType, (newValue: AtomType) => void] => {
    return [useSyncExternalStore(atom.subscribe, atom.get), atom.set];
};
// useAtomValue hook
export const useAtomValue = <AtomType>(atom: Atom<AtomType>) => {
    return useSyncExternalStore(atom.subscribe, atom.get);
};
