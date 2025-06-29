<?php
session_start();
include '../includes/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch issued books for the logged-in user with fine details
$query = "SELECT ib.issue_id, b.title AS book_title, ib.issue_date, ib.due_date, ib.return_status, 
                 f.fine_id, f.amount AS fine_amount, f.status AS fine_status
          FROM issued_books ib
          JOIN books b ON ib.book_id = b.book_id
          LEFT JOIN fines f ON ib.issue_id = f.issue_id
          WHERE ib.user_id = ?"; // Only show books issued to logged-in user

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$issued_books = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin-left: 260px;
            margin-top: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .pay-button {
            background-color: green;
            color: white;
            padding: 8px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .pay-button:hover {
            background-color: darkgreen;
        }

        .paid {
            color: green;
            font-weight: bold;
        }

        .unpaid {
            color: red;
            font-weight: bold;
        }

    </style>
</head>
<?php include 'sidebar.php'; ?>
<body>
    <div class="container">
        <h2>Issued Books</h2>

        <?php
        if (isset($_SESSION['success_message'])) {
            echo "<p style='color: green; text-align: center;'>" . $_SESSION['success_message'] . "</p>";
            unset($_SESSION['success_message']);
        } elseif (isset($_SESSION['error_message'])) {
            echo "<p style='color: red; text-align: center;'>" . $_SESSION['error_message'] . "</p>";
            unset($_SESSION['error_message']);
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Book Title</th>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Fine Amount</th>
                    <th>Payment Status</th>
                    <th>Return Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    <?php
    $sn = 1;
    foreach ($issued_books as $book) {
        echo "<tr>
                <td>{$sn}</td>
                <td>{$book['book_title']}</td>
                <td>{$book['issue_date']}</td>
                <td>{$book['due_date']}</td>
                <td>₹" . number_format($book['fine_amount'] ?? 0, 2) . "</td>
                <td class='" . ($book['fine_status'] === 'unpaid' ? 'unpaid' : 'paid') . "'>" . ucfirst($book['fine_status'] ?? 'No Fine') . "</td>
                <td>" . ucfirst($book['return_status'] ?? 'Not Returned') . "</td>
                <td>";

        if (!empty($book['fine_id'])) {
            if ($book['fine_status'] === 'unpaid' && $book['fine_amount'] > 0) {
                echo "<form action='pay_fine.php' method='POST'>
                        <input type='hidden' name='fine_id' value='{$book['fine_id']}'>
                        <input type='hidden' name='fine_amount' value='{$book['fine_amount']}'>
                        <button type='submit' class='pay-button'>Pay Fine</button>
                      </form>";
            } else {
                echo "<span class='paid'>Payment Done</span>";
            }
        } else {
            echo "No Fine";
        }

        echo "</td></tr>";
        $sn++;
    }
    ?>
</tbody>

        </table>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get all Pay Fine buttons
        const payButtons = document.querySelectorAll(".pay-button");

        payButtons.forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault(); // Prevent direct form submission

                let confirmation = confirm("Are you sure you want to pay the fine?");
                if (confirmation) {
                    this.closest("form").submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>

</html>
