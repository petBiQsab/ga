import { createRoot } from "react-dom/client";
import { type ComponentProps, StrictMode } from "react";
// View and route data
import { views } from "./views";
// Components
import { AppWrapper } from "../components/wrapper";
import { Error } from "../components/Error";
// Types
import { DetailPops, PracoviskoProps } from "./types";
type AppContext = {
    routeSegments: string[];
    routeQuery: any;
    user: PracoviskoProps["user"];
};
type View = {
    viewNames: string[];
    Component: (props: DetailPops | PracoviskoProps) => JSX.Element;
};
// Context
const {
    routeSegments: [base, slug],
    routeQuery: query,
    user,
    // @ts-ignore // From app.blade template
} = app as AppContext;
// @ts-ignore // From view blade template
const data = routeData;
// @ts-ignore // From view blade template
const meta = routeMeta;
// Set root component and props
let container: HTMLElement | null = null;
document.addEventListener("DOMContentLoaded", () => {
    // Mount component only if it is not already mounted
    if (!container) {
        const rootElement = document.getElementById("root");
        if (rootElement) {
            const root = createRoot(rootElement);
            container = rootElement;
            try {
                // Find current view, get component and props
                const { Component } = views.find(({ viewNames }) =>
                    viewNames.includes(base)
                ) as View;
                const viewProps: ComponentProps<typeof Component> = {
                    user,
                    data,
                    meta,
                    slug,
                    query,
                };
                console.log(data);
                root.render(
                    <StrictMode>
                        <AppWrapper user={user}>
                            <Component {...viewProps} />
                        </AppWrapper>
                    </StrictMode>
                );
            } catch (error) {
                // Fallback to error if current view is not found or if error is thrown
                root.render(
                    <StrictMode>
                        <AppWrapper user={user}>
                            <Error error={error as Error} />
                        </AppWrapper>
                    </StrictMode>
                );
            }
        }
    }
});
