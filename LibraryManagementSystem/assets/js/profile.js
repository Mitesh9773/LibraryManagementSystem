function validateProfileForm() {
    let name = document.getElementById("name").value.trim();
    let mobile = document.getElementById("mobile").value.trim();

    if (name === "" || mobile === "") {
        alert("Please fill in all fields!");
        return false;
    }

    if (!/^[a-zA-Z\s]+$/.test(name)) {
        alert("Name can only contain letters and spaces!");
        return false;
    }

    if (!/^\d{10}$/.test(mobile)) {
        alert("Mobile number must be 10 digits!");
        return false;
    }

    return true;
}
