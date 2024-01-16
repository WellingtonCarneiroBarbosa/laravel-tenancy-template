export default function dateFormatter(datetime, format = "short") {
    const date = new Date(datetime);

    if (format === "short") {
        return date.toLocaleDateString("pt-BR", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
        });
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
