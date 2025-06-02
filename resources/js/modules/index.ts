/*
    All non React related JavaScript goes here
*/
// import { toggleModal } from "../components/modal/assets";
// // Toggle user menu and logout modal
// const userBar = document.getElementById("user-bar");
// if (userBar) {
//     const userMenu = userBar.lastElementChild as HTMLElement;
//     if (userMenu) {
//         const userMenuHiddenStyles = {
//             transform: "translateX(100%)",
//             boxShadow: "none",
//         };
//         const userMenuVisibleStyles = {
//             transform: "translateY(0)",
//             boxShadow: "0px 2px 8px rgba(0, 0, 0, 0.1",
//         };
//         const toggleMenu = (e: MouseEvent) => {
//             e.stopPropagation();
//             if ((e.target as HTMLParagraphElement)?.id === "logout") {
//                 toggleModal();
//             }
//             const userBarWidth = userBar.getBoundingClientRect().width;
//             if (
//                 window.getComputedStyle(userMenu).transform ===
//                 `matrix(1, 0, 0, 1, ${userBarWidth}, 0)`
//             ) {
//                 Object.assign(userMenu.style, userMenuVisibleStyles);
//             } else {
//                 Object.assign(userMenu.style, userMenuHiddenStyles);
//             }
//         };
//         // Mount event listeners
//         userBar.addEventListener("click", toggleMenu);
//         document.addEventListener("click", (e) => {
//             if (
//                 window.getComputedStyle(userMenu).transform ===
//                 "matrix(1, 0, 0, 1, 0, 0)"
//             ) {
//                 Object.assign(userMenu.style, userMenuHiddenStyles);
//             }
//         });
//     }
// }
