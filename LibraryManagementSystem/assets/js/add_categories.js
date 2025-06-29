document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            const categoryId = this.getAttribute("data-id");

            if (confirm("Are you sure you want to delete this category?")) {
                fetch("add_categories.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `delete_category=true&category_id=${categoryId}`
                })
                .then(response => response.text())
                .then(data => {
                    alert("Category deleted successfully!");
                    location.reload();
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });
});
