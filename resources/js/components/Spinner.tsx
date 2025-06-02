type LoaderProps = {
    title?: string;
};

export const Spinner = ({ title }: LoaderProps) => {
    const circles = [
        {
            fill: "#383636",
            d: "M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z",
            duration: "1.5s",
        },
        {
            fill: "#c5362e",
            d: "M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5L82,35.7z",
            duration: "2s",
        },
        {
            fill: "#fafafa",
            d: "M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z",
            duration: "2.5s",
        },
    ];
    return (
        <div
            style={{
                width: "100vw",
                height: "100vh",
                position: "fixed",
                top: 0,
                left: 0,
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
                flexDirection: "column",
                zIndex: 99_999,
                backgroundColor: "rgba(0, 0, 0, 0.4)",
            }}
        >
            {title && (
                <h3
                    style={{
                        fontSize: "2rem",
                        color: "#FFFBFE",
                        margin: "0 0 1rem",
                    }}
                >
                    {title}
                </h3>
            )}
            <div
                style={{
                    width: "80px",
                    height: "80px",
                }}
            >
                <svg
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 100 100"
                    enableBackground="new 0 0 100 100"
                    xmlSpace="preserve"
                >
                    {circles.map(({ fill, d, duration }, index) => (
                        <path key={index} fill={fill} d={d}>
                            <animateTransform
                                attributeName="transform"
                                attributeType="XML"
                                type="rotate"
                                dur={duration}
                                from="0 50 50"
                                to={`${index === 1 ? "-" : ""}360 50 50`}
                                repeatCount="indefinite"
                            />
                        </path>
                    ))}
                </svg>
            </div>
        </div>
    );
};
