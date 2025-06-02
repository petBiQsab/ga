import {
    type ForwardedRef,
    forwardRef,
    type RefObject,
    useEffect,
    useRef,
} from "react";
// Assets
import { sections } from "./assets";
// Components
import { AMtlColors } from "./AMtlColors";
// Types
type NavigationProps = {
    atl: string;
    mtl: string;
};

export const Navigation = forwardRef(
    ({ atl, mtl }: NavigationProps, ref: ForwardedRef<HTMLDivElement>) => {
        const scrollTo = (id: string) => {
            const element = document.getElementById(id);
            if (element) {
                // Get offset position and subtract header and page header height
                const headerHeight =
                    document.querySelector("header")?.getBoundingClientRect()
                        .height ?? 0;
                const view = (ref as RefObject<HTMLDivElement>).current
                    ?.parentElement as HTMLDivElement;
                const pageHeaderHeight =
                    view.previousElementSibling?.getBoundingClientRect()
                        .height ?? 0;
                const offsetPosition =
                    element.offsetTop - pageHeaderHeight - headerHeight - 24; // Add padding
                view.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth",
                });
                const actualBorderColor = element.style.borderColor;
                element.style.borderColor = "#8c8c8c";
                setInterval(
                    () => (element.style.borderColor = actualBorderColor),
                    1000
                );
            }
        };
        const navRef = useRef(null);
        useEffect(() => {
            const navRefs = (navRef.current as unknown as HTMLDivElement)
                ?.children;
            const sectionElements = (ref as RefObject<HTMLDivElement>).current
                ?.childNodes as NodeListOf<HTMLElement>;
            const navValues = sections.map(({ key }) => key);
            const observer = new IntersectionObserver(
                (entries) =>
                    entries.forEach((entry) => {
                        const navElement =
                            navRefs[navValues.indexOf(entry.target.id)];
                        navElement.classList.toggle(
                            "visible",
                            entry.isIntersecting
                        );
                    }),
                {
                    threshold: 0.63,
                }
            );
            sectionElements.forEach((section) => observer.observe(section));
            return () => observer.disconnect();
        }, [navRef]);
        return (
            <nav ref={navRef}>
                {sections.map(({ name, key }) => (
                    <div key={name} onClick={() => scrollTo(key)}>
                        <p
                            style={{
                                lineHeight: 1.5,
                            }}
                        >
                            {name}
                        </p>
                        {["terminy_projektu", "aktivity"].includes(key) && (
                            <AMtlColors
                                tooltip={key === "terminy_projektu" ? "AMtl2" : "AMtl"}
                                color={("terminy_projektu" === key ? atl : mtl) as string}
                            />
                        )}
                    </div>
                ))}
            </nav>
        );
    }
);
