function toggleSearchField() {
    const reportType = document.getElementById("reportType").value;
    const searchGroup = document.getElementById("searchFieldGroup");
    const searchLabel = document.getElementById("searchLabel");
    const paramInput = document.getElementById("param");

    const needsParam = {
        workshops_by_user: "Usuario",
        users_by_workshop: "Taller"
    };

    if (needsParam[reportType]) {
        searchGroup.classList.add("show");
        searchLabel.textContent = `Valor de Búsqueda (${needsParam[reportType]})`;
        paramInput.required = true;
    } else {
        searchGroup.classList.remove("show");
        paramInput.required = false;
        paramInput.value = "";
    }
}
