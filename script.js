document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector("input#searchbar");
    const uniRows = document.querySelectorAll("table.table > tbody > tr");

    searchInput.addEventListener("input", (e) => {
        const value = e.target.value.toLowerCase();

        uniRows.forEach(row => {
            const uniName = row.querySelectorAll("td")[1].textContent.toLowerCase();
            const isVisible = uniName.includes(value);
            
            row.style.display = isVisible ? "" : "none";
        });
    });
    
    
    




});
