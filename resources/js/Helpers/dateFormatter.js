export default function dateFormatter(datetime, format = "short") {
    const date = new Date(datetime);

    if (format === "short") {
        return date.toLocaleDateString("pt-BR", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
        });
    }

    if (format === "medium") {
        let string = date.toLocaleDateString("pt-BR", {
            day: "numeric",
            month: "short",
            year: "numeric",
        });

        string = string.replace(".", ",");
        string = string.replace("de ", "");
        string = string.replace("de ", "");

        return string;
    }

    if (format === "long") {
        return date.toLocaleDateString("pt-BR", {
            day: "2-digit",
            month: "long",
            year: "numeric",
        });
    }

    return date;
}
