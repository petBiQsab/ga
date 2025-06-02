import { DetailPops } from "../src/types";
type FetcherType = "login" | "detail" | "delete";
type Data = DetailPops["data"];

export const fetcher = async (type: FetcherType, data: Data | FormData) => {
    try {
        const id = (data as Data)?.zakladne_informacie?.id_original;
        const apiUrl =
            type === "login"
                ? "/login"
                : type === "detail"
                ? `/detail${id ? `/${id}` : ""}`
                : `/delete_projekt/${id}`;
        const token =
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") ?? "";
        const isFormData = data instanceof FormData;
        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
                "Content-Type": isFormData
                    ? "multipart/form-data"
                    : "application/json",
            },
            body: isFormData ? data : JSON.stringify(data),
        });
        const responseData = await response.json();
        const { status, url } = response;
        return { responseData, status, url };
    } catch (error) {
        console.error(error);
        return {
            status: 500,
            error: "Server error, check console for more info",
            url: "",
        };
    }
};
