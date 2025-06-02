export type User = {
    name: string;
    role: string;
    roleName: string;
    moje_utvary_filter2: string[];
};
export type DataPrimitive = string | string[] | number | null;
export type DataObject = {
    id: string | number;
    value: DataPrimitive;
    type?: string;
    group_name?: string;
    week_num?: number;
    state?: number;
};
export type PracoviskoProps = {
    user: User;
    data: {
        [key: string]:
            | DataPrimitive
            | { [key: string]: DataPrimitive }
            | { [key: string]: DataPrimitive }[];
    }[];
};
export type DetailPops = {
    user: User;
    data: {
        [key: string]: {
            [key: string]: DataPrimitive | DataObject | DataObject[];
        };
    };
    meta: {
        rights: {
            read: string[];
            write: string[];
        };
        nextAvailableId?: string;
        notAvailableIds?: string[];
    };
    slug?: string;
    query?: {
        [key: string]: string | string[] | null;
    };
};
