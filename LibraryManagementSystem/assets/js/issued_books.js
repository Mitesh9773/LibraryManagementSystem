document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".return-btn").forEach(button => {
        button.addEventListener("click", function () {
            const issueId = this.dataset.id;

            if (confirm("Are you sure you want to return this book?")) {
                fetch("process_return.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "issue_id=" + issueId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Book returned successfully!");
                        location.reload();
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => console.error("Fetch error:", error));
            }
        });
    });
});
