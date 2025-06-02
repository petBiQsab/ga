type Object = { id: string; value: string };
export type Activity = {
    flag?: string;
    headerTitle?: string | Object;
    id_aktivita: number;
    koniec_aktivity: string;
    skutocny_koniec_aktivity: string;
    skutocny_zaciatok_aktivity: string;
    value: string | Object;
    zaciatok_aktivity: string;
    zodpovedni: Object[];
};
