console.log('hello');
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const errorMessage = document.querySelector(".error");

    form.addEventListener("submit", function (event) {
        const email = document.querySelector("input[name='email']").value.trim();
        const password = document.querySelector("input[name='password']").value.trim();

        if (email === "" || password === "") {
            event.preventDefault();
            errorMessage.textContent = " Please fill in both fields.";
            errorMessage.style.color = "red";
        }
    });
});
