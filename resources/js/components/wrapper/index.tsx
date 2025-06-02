import { type ReactNode, useState } from "react";
import { modalState } from "../../store";
// Assets
import { toggleModal } from "../modal/assets";
import { capitalize } from "../../lib/format";
// Components
import { AskForChangeForm } from "./AskForChangeForm";
import { Modal } from "../modal";
import { SnackBar } from "../SnackBar";
import { Tooltip } from "../Tooltip";
import { Icon } from "../icon/Icon";
// Types
import { User } from "../../src/types";
type AppWrapperProps = {
    children: ReactNode | ReactNode[];
    user: User | null;
};

const actions = [
    {
        icon: "help",
        title: "Technické problémy s aplikáciou nahlásite na HelpDesk.",
    },
    // {
    //     icon: "message",
    //     title: "Nahlásenie zmien v projekte.",
    // },
] as const;

export const AppWrapper = ({ children, user }: AppWrapperProps) => {
    const [menu, setMenu] = useState(false);
    const data = (children as any).props.data;
    return (
        <>
            <header>
                <Icon icon="logo" />
                <h1>Bratislava</h1>
                {user && (
                    <>
                        {actions.map(({ icon, title }) => {
                            const ActionTag = icon === "help" ? "a" : "button";
                            const actionTagProps = {
                                icon,
                                className: "btn-header",
                                ...(icon === "help"
                                    ? {
                                          href: "https://helpdesk.bratislava.sk/Tickets/New?categoryId=81",
                                          target: "_blank",
                                      }
                                    : {
                                          onClick: () => {
                                              toggleModal();
                                              modalState.setState({
                                                  type: "ask-for-change",
                                                  title: "Nahlásenie zmien v projekte",
                                                  content: (
                                                      <AskForChangeForm
                                                          data={data}
                                                      />
                                                  ),
                                              });
                                          },
                                      }),
                            };
                            return (
                                <Tooltip key={icon} value={title}>
                                    <ActionTag {...actionTagProps}>
                                        <Icon icon={icon} />
                                    </ActionTag>
                                </Tooltip>
                            );
                        })}
                        <div
                            style={{
                                cursor: "pointer",
                            }}
                            onClick={() => setMenu(!menu)}
                        >
                            <div>
                                <p>TU</p>
                            </div>
                            <div>
                                <p
                                    style={{
                                        fontWeight: 600,
                                    }}
                                >
                                    {user.name}
                                </p>
                                <p>{capitalize(user.roleName)}</p>
                            </div>
                            <div
                                style={{
                                    transform: `translateX(${
                                        menu ? 0 : "100%"
                                    })`,
                                }}
                            >
                                <p onClick={toggleModal}>Odhlásiť</p>
                            </div>
                        </div>
                    </>
                )}
            </header>
            {children}
            <SnackBar />
            <Modal />
        </>
    );
};
