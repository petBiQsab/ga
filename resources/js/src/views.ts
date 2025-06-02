// Auth
import { LogIn } from "../components/auth/LogIn";
// Pracovisko
import { Home } from "../components/home";
// Detail
import { Detail } from "../components/detail";
// Define views and route names
export const views = [
    {
        viewNames: ["login"],
        Component: LogIn,
    },
    {
        viewNames: ["pracovisko", "pracoviskoLimit"],
        Component: Home,
    },
    {
        viewNames: ["detail"],
        Component: Detail,
    },
];
