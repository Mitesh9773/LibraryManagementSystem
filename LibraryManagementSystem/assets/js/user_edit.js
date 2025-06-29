document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("editUserForm");

    form.addEventListener("submit", function (event) {
        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const mobile = document.getElementById("mobile").value.trim();

        if (name === "" || email === "" || mobile === "") {
            alert("All fields are required!");
            event.preventDefault();
        } else if (!/^\d{10}$/.test(mobile)) {
            alert("Mobile number must be 10 digits.");
            event.preventDefault();
        }
    });
});
