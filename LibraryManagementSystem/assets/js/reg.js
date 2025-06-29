document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            const password = form.querySelector("input[name='password']");
            if (password.value.length < 4) {
                alert("Password must be at least 4- characters long!");
                event.preventDefault();
            }
        });
    });
});
