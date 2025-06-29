document.addEventListener("DOMContentLoaded", function() {
    const sidebarLinks = document.querySelectorAll(".sidebar ul li a");

    sidebarLinks.forEach(link => {
        link.addEventListener("click", function() {
            sidebarLinks.forEach(l => l.classList.remove("active"));
            this.classList.add("active");
        });
    });
});
