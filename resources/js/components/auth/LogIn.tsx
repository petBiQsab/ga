import { useState } from "react";
// Components
import { Checkbox } from "../Checkbox";
import { Input } from "../Input";

export const LogIn = () => {
    const inputs = [
        {
            label: "E-mail",
            name: "email",
        },
        {
            label: "Heslo",
            name: "password",
        },
    ];
    const [showPassword, setShowPassword] = useState(false);
    const _token =
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content") ?? "";
    return (
        <section>
            <form
                method="POST"
                className="login"
                action={"/login"}
                style={{
                    width: "36rem",
                    display: "grid",
                    gridTemplateColumns: "repeat(2, 1fr)",
                    gap: "1.5rem",
                    backgroundColor: "#fff",
                    padding: "3rem 4rem",
                    borderRadius: "0.5rem",
                    margin: "3rem auto 0",
                }}
            >
                <h1
                    style={{
                        gridColumn: "1 / -1",
                        fontWeight: 500,
                        fontSize: "30px",
                        lineHeight: "38px",
                        textAlign: "center",
                    }}
                >
                    Prihlásenie
                </h1>
                {inputs.map(({ label, name }) => (
                    <Input
                        key={name}
                        name={name}
                        label={label}
                        type={showPassword ? "text" : (name as "text")}
                        required
                        styles={{
                            gridColumn: "1 / -1",
                            marginTop: 0,
                        }}
                    />
                ))}
                <input type="hidden" name="_token" value={_token} />
                <Checkbox
                    label="Zobraziť heslo"
                    checked={showPassword}
                    onCheck={() => setShowPassword(!showPassword)}
                />
                <button
                    className="btn-primary"
                    style={{
                        margin: "00 0.5rem auto",
                    }}
                >
                    Prihlásiť sa
                </button>
            </form>
        </section>
    );
};
