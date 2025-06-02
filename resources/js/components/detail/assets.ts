import { DetailPops } from "../../src/types";
import { Activity } from "./types";

export const sections = [
    {
        open: true,
        key: "zakladne_informacie",
        name: "Základné informácie",
        fields: [
            {
                key: "id_pp",
                name: "ID projektu",
                gridColumn: 1,
            },
            {
                key: "nazov_projektu",
                name: "Názov projektu",
                gridColumn: 5,
            },
            {
                key: "alt_nazov_projektu",
                name: "Rozšírený názov projektu",
            },
            {
                key: "ciel_projektu",
                name: "Cieľ projektu",
                multiline: true,
            },
        ],
    },
    {
        open: false,
        key: "prepojenie_na_ba30",
        name: "Prepojenie na Bratislava 2030",
        fields: [
            {
                key: "strategicky_ciel_PHSR",
                name: "Strategický cieľ",
                list: "prepojenie_na_ba30_strateg_ciel",
                multiple: true,
            },
            {
                key: "specificky_ciel_PHSR",
                name: "Špecifický cieľ PHSR",
                list: "prepojenie_na_ba30_speci_ciel",
                multiple: true,
            },
            {
                key: "program",
                name: "Program",
                list: "prepojenie_na_ba30_program",
                multiple: true,
            },
            {
                key: "meratelny_vystupovy_ukazovatel",
                name: "Merateľný výstupový ukazovateľ",
                multiline: true,
            },
        ],
    },
    {
        open: true,
        key: "zaradenie_projektu",
        name: "Zaradenie projektu",
        fields: [
            {
                key: "typ_projektu",
                name: "Typ projektu",
                list: "typ_projektu",
                gridColumn: 5,
                multiple: true,
            },
            {
                key: "kategoria",
                name: "Kategória",
                list: "kategoria",
                gridColumn: 1,
            },
            {
                key: "prioritne_oblasti",
                name: "Prioritné oblasti",
                list: "prioritne_oblasti",
                multiple: true,
            },
            {
                key: "muscow",
                name: "MuSCoW",
                list: "muscow",
                gridColumn: 3,
            },
            {
                key: "ryg",
                name: "RYG",
                list: "ryg",
                gridColumn: 3,
            },
        ],
    },
    {
        open: true,
        key: "zivotny_cyklus_projektu",
        name: "Životný cyklus projektu",
        fields: [
            {
                key: "stav_projektu",
                name: "Stav projektu",
                list: "stav_projektu",
                gridColumn: 3,
            },
            {
                key: "faza_projektu",
                name: "Fáza projektu",
                list: "faza_projektu",
                gridColumn: 3,
            },
        ],
    },
    {
        open: true,
        key: "terminy_projektu",
        name: "Termíny projektu",
        fields: [
            {
                key: "datum_zacatia_projektu",
                name: "Začiatok projektu",
                gridColumn: 3,
            },
            {
                key: "datum_konca_projektu",
                name: "Koniec projektu",
                gridColumn: 3,
            },
        ],
    },
    {
        open: true,
        key: "aktivity",
        name: "Aktivity projektu",
        fields: [
            {
                key: "zrealizovane_aktivity",
                name: "Zrealizované aktivity za posledný týždeň",
                multiline: true,
            },
            {
                key: "planovane_aktivity_na_najblizsi_tyzden",
                name: "Plánované aktivity na najbližší týždeň",
                multiline: true,
            },
            {
                key: "rizika_projektu",
                name: "Riziká projektu",
                multiline: true,
            },
            {
                key: "mtl",
                name: "Projektový semafor",
                list: ["green", "orange", "red"],
                gridColumn: 2,
            },
            {
                key: "komentar",
                name: "Komentár k semaforu",
                multiline: true,
            },
        ],
    },
    {
        open: true,
        key: "organizacia_projektu",
        name: "Organizácia projektu",
        fields: [
            {
                key: "magistratny_garant",
                name: "Magistrátny garant",
                list: "magistratny_garant",
            },
            {
                key: "utvar_magistratneho_garanta",
                name: "Útvar magistrátneho garanta",
                list: "groups",
                disabled: true,
            },
            {
                key: "politicky_garant",
                name: "Politický garant",
                list: "politicky_garant",
            },
            {
                key: "projektovy_manager",
                name: "Projektový manažér",
                list: "users",
                multiple: true,
            },
            {
                key: "utvar_projektoveho_managera",
                name: "Útvar projektového manažéra",
                list: "groups",
                multiple: true,
                disabled: true,
            },
            {
                key: "coop_utvary",
                name: "Útvary mesta",
                list: "groups",
                multiple: true,
            },
            {
                key: "coop_organizacie",
                name: "Spolupracujúci na projekte",
                list: "organizacie",
                multiple: true,
            },
            {
                key: "externi_stakeholderi",
                name: "Externí stakeholderi",
                multiline: true,
            },
            {
                key: "sprava",
                name: "Správa",
                list: "groups",
                multiple: true,
            },
            {
                key: "udrzba",
                name: "Údržba",
                list: "groups",
                multiple: true,
            },
            {
                key: "riadiace_gremium",
                name: "Riadiace grémium",
                list: "users",
                multiple: true,
            },
            {
                key: "projektovy_tim",
                name: "Projektový tím",
                list: "users",
                multiple: true,
            },
        ],
    },
    {
        open: false,
        key: "schvalenie_projektu",
        name: "Schválenie projektu",
        fields: [
            {
                key: "datum_schvalenie_id",
                name: "Dátum schválenia projektu",
            },
            {
                key: "schvalenie_pi_na_pg",
                name: "Schválenie projektovej idei na portfóliovom grémiu",
                list: "schvaleniePIPZPG",
                gridColumn: 3,
            },
            {
                key: "datum_schvalenia_pi_na_pg",
                name: "Dátum schválenia projektovej idei na portfóliovom grémiu",
                gridColumn: 3,
            },
            {
                key: "hyperlink_na_pi",
                name: "Hyperlink na projektovú ideu",
            },
            {
                key: "pripomienky_k_pi",
                name: "Pripomienky k projektovej idei",
                multiline: true,
            },
            {
                key: "schvalenie_pz_na_pg",
                name: "Schválenie projektového zámeru na portfóliovom grémiu",
                list: "schvaleniePIPZPG",
                gridColumn: 3,
            },
            {
                key: "datum_schvalenia_pz_na_pg",
                name: "Dátum schválenia projektového zámeru na portfóliovom grémiu",
                gridColumn: 3,
            },
            {
                key: "hyperlink_na_pz",
                name: "Hyperlink na projektový zámer",
            },
            {
                key: "pripomienky_k_pz",
                name: "Pripomienky k projektovému zámeru",
                multiline: true,
            },
            {
                key: "datum_schvalenia_projektu_ppp",
                name: "Dátum schválenia projektu na PPP",
            },
            {
                key: "datum_schvalenia_projektu_msz",
                name: "Dátum schválenia projektu na MsZ",
            },
        ],
    },
    {
        open: false,
        key: "doplnujuce_udaje",
        name: "Doplňujúce údaje",
        fields: [
            {
                key: "externe_financovanie",
                name: "Externé financovanie",
                list: "externe_financovanie",
                gridColumn: 2,
            },
            {
                key: "zdroj_externeho_financovania",
                name: "Zdroj externého financovania",
                multiline: true,
                gridColumn: 4,
            },
            {
                key: "suma_externeho_financovania",
                name: "Suma externého financovania",
                gridColumn: 2,
            },
            {
                key: "podiel_externeho_financovania_z_celkovej_ceny",
                name: "Podiel externého financovania",
                gridColumn: 4,
            },
            {
                key: "mestska_cast",
                name: "Mestská časť",
                list: "mestska_cast",
                multiple: true,
            },
            {
                key: "id_priorita",
                name: "Politická priorita",
                list: "politicka_priorita",
            },
            {
                key: "id_priorita_new",
                name: "Priorita",
                list: "priorita",
            },
            {
                key: "verejna_praca",
                name: "Verejná práca",
                list: "verejna_praca",
            },
            {
                key: "suvisiace_projekty",
                name: "Súvisiace projekty",
                list: "suvisiace_projekty",
                multiple: true,
            },
            {
                key: "hashtag",
                name: "Hashtagy",
                list: "hashtag",
                multiple: true,
            },
            {
                key: "specificke_atributy",
                name: "Špecifické atribúty",
                list: "specificke_atributy",
                multiple: true,
            },
            {
                key: "hyperlink_na_ulozisko_projektu",
                name: "Hyperlink na úložisko projektu",
            },
        ],
    },
    {
        open: true,
        key: "celkove_vydavky_projektu",
        name: "Celkové výdavky projektu",
        fields: [
            {
                key: "najaktualnejsia_cena_projektu_vrat_DPH",
                name: "Najaktuálnejšia cena projektu vrátane DPH",
                gridColumn: 3,
            },
            {
                key: "najaktual_rocne_prevadzkove_naklady_projektu_vrat_DPH",
                name: "Najaktuálnejšie ročné prevádzkové náklady projektu vrátane DPH",
                gridColumn: 3,
            },
        ],
    },
    {
        open: false,
        key: "projektova_idea",
        name: "Financovanie: projektová idea",
        fields: [
            {
                key: "celkom_bv_a_kv_vrat_dph",
                name: "Celkom BV a KV vrátane DPH",
            },
            {
                key: "idea_bezne_ocakavane_rocne_naklady_projektu_s_dph",
                name: "Bežné očakávané ročné náklady projektu s DPH",
            },
            {
                key: "idea_kapitalove_ocakavane_rocne_naklady_projektu_s_dph",
                name: "Kapitálové očakávané ročné náklady projektu s DPH",
            },
            {
                key: "rocne_prevadzkove_naklady_projektu_vrat_dph",
                name: "Ročné prevádzkové náklady projektu vrátane DPH",
            },
        ],
    },
    {
        open: false,
        key: "projektovy_zamer",
        name: "Financovanie: projektový zámer",
        fields: [
            {
                key: "bezne_prijmy_celkom_vrat_dph",
                name: "Bežné príjmy celkom vrátane DPH",
            },
            {
                key: "celkom_vrat_dph",
                name: "Celkom vrátane DPH",
            },
            {
                key: "kapitalove_prijmy_celkom_vrat_dph",
                name: "Kapitálové príjmy celkom vrátane DPH",
            },
            {
                key: "rocne_prevadzkove_naklady_vrat_dph",
                name: "Ročné prevádzkové náklady vrátane DPH",
            },
            {
                key: "zamer_bezne_aktualne_ocakavane_rocne_naklady_projektu_s_dph",
                name: "Bežné aktuálne očakávané ročné náklady projektu s DPH",
            },
            {
                key: "zamer_kapitalove_aktualne_ocakavane_rocne_naklady_projektu_s_dph",
                name: "Kapitálové aktuálne očakávané ročné náklady projektu s DPH",
            },
        ],
    },
    {
        open: false,
        key: "kvalifikovany_odhad",
        name: "Financovanie: kvalifikovaný odhad",
        fields: [
            {
                key: "kvalifikovany_odhad_ceny_projektu",
                name: "Kvalifikovaný odhad ceny projektu",
            },
            {
                key: "kvalifikovany_odhad_rocnych_prevadzkovych_nakladov_vrat_dph",
                name: "Kvalifikovaný odhad ročných prevádzkových nákladov vrátane DPH",
            },
            {
                key: "zdroj_info_kvalif_odhad",
                name: "Zdroj informácie kvalifikovaný odhad",
            },
        ],
    },
    {
        open: false,
        key: "interne_udaje",
        name: "Interné údaje",
        fields: [
            {
                key: "max_rok",
                name: "Maximálny rok",
                gridColumn: 2,
            },
            {
                key: "reporting",
                name: "Reporting",
                list: "reporting",
                gridColumn: 2,
            },
            {
                key: "planovanie_rozpoctu",
                name: "Plánovanie rozpočtu",
                list: "planovanie_rozpoctu",
                gridColumn: 2,
            },
            {
                key: "poznamky",
                name: "Poznámky",
                multiline: true,
            },
        ],
    },
] as {
    key: string;
    name: string;
    open: boolean;
    fields: {
        key: string;
        name: string;
        multiline?: boolean;
        list?: string;
        multiple?: boolean;
        gridColumn?: number;
        disabled?: boolean;
    }[];
}[];

export const isListField = (name: string) =>
    [
        "zrealizovane_aktivity",
        "planovane_aktivity_na_najblizsi_tyzden",
        "rizika_projektu",
        "pripomienky_k_pi",
        "pripomienky_k_pz",
    ].includes(name);

const activityKeys = [
    "koniec_aktivity",
    "skutocny_koniec_aktivity",
    "skutocny_zaciatok_aktivity",
    "value",
    "headerTitle",
    "zaciatok_aktivity",
    "zodpovedni,",
];
export const getPermittedActivities = (
    activities: Activity[],
    rights: DetailPops["meta"]["rights"]
) =>
    activities.filter(
        () =>
            activityKeys.filter(
                (key) => rights.write.includes(key) || rights.read.includes(key)
            ).length
    );

export const tooltips = {
    AMtl: `
        PROJEKTOVÝ SEMAFOR:<br/>
        Červená - závažné problémy s realizáciou, ktoré ohrozujú životaschopnosť projektu<br/>
        Oranžová - mierne riziká týkajúce sa implementácie, ale projekt je vo všeobecnosti v dobrom stave<br/>
        Zelená - projekt je na dobrej ceste - podľa harmonogramu, financovanie je zabezpečené, personál a zdroje sú dostatočné
    `,
    AMtl2: `
        TERMÍNOVÝ SEMAFOR:<br/>
        Portfólio automaticky vyhodnocuje termínovú situáciu projektu, vychádzajúc z termínov začiatku a konca projektu schválených na Portfóliovom grémiu a Projektového semafora, ktoré sú zapísané v aplikácii.<br/>
        Tieto automaticky porovnáva s aktivít, míľnikov a projektového semafora, ktoré PM potvrdzuje každý mesiac počas reportingu. Automatizovaný semafor je zobrazený v ľavom stĺpci hlavnej obrazovky.<br/><br/>
        Zelená - projekt beží podľa plánu, všetky projektové míľniky a aktivity (začiatok, koniec) s termínom v minulosti sú potvrdené ako zrealizované<br/>
        Žltá - projekt má meškajúci termín realizácie míľnika alebo aktivity (začiatok, koniec) menej ako 45 dní<br/>
        Červená - projekt má meškajúci termín realizácie míľnika alebo aktivity (začiatok, koniec) 45 dní a viac
    `,
};
