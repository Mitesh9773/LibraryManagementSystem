document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", () => {
            let bookId = button.getAttribute("data-id");
            if (confirm("Are you sure you want to delete this book?")) {
                fetch("../includes/db.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "DELETE FROM books WHERE id=" + bookId
                })
                .then(response => response.text())
                .then(data => {
                    if (data === "success") {
                        button.closest("tr").remove();
                    } else {
                        alert("Error deleting book");
                    }
                });
            }
        });
    });
});