document.addEventListener("DOMContentLoaded", () => {
    const editForm = document.getElementById("edit-author-form");

    editForm.addEventListener("submit", function (event) {
        const authorName = document.getElementById("author_name").value.trim();
        
        if (authorName === "") {
            alert("Author name cannot be empty!");
            event.preventDefault();
        }
    });
});
