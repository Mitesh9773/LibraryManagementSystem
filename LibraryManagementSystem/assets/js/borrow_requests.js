// document.addEventListener("DOMContentLoaded", function () {
//     document.querySelectorAll(".accept-btn").forEach(button => {
//         button.addEventListener("click", function () {
//             let requestId = this.getAttribute("data-id");
//             updateRequestStatus(requestId, "Accepted", this);
//         });
//     });

//     document.querySelectorAll(".reject-btn").forEach(button => {
//         button.addEventListener("click", function () {
//             let requestId = this.getAttribute("data-id");
//             updateRequestStatus(requestId, "Rejected", this);
//         });
//     });

//     function updateRequestStatus(requestId, status, button) {
//         fetch("process_borrow_request.php", {
//             method: "POST",
//             headers: {
//                 "Content-Type": "application/x-www-form-urlencoded"
//             },
//             body: `request_id=${requestId}&status=${status}`
//         })
//         .then(response => response.text())
//         .then(data => {
//             alert(data);
//             button.closest("tr").querySelector(".status").innerText = status;
//         })
//         .catch(error => console.error("Error:", error));
//     }
// });
