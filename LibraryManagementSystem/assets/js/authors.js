document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll(".delete-form");

    deleteForms.forEach(form => {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            if (confirm("Are you sure you want to delete this author?")) {
                this.submit();
            }
        });
    });
});
