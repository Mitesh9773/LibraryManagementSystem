<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sidebar</title>
    <!-- <link rel="stylesheet" href="../assets/css/dashboard.css"> -->
    <style>
        /* General Page Styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    
}

/* Layout Setup */
.side_container {
    display: flex;
}

/* Sidebar Styling */
.sidebar {
    width: 250px;
    background: #222;
    color: white;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
    left: 0;
    top: 0;
    overflow-y: auto;
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
    color:white;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    padding: 15px 20px;
    border-bottom: 1px solid #333;
    text-align:left;
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    display: block;
}

.sidebar ul li:hover {
    background: #444;
}
    </style>
</head>
<body>

<div class="side_container">
    <aside class="sidebar">
        <h2>LMS</h2>
        <ul>
            <li><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="profile.php">Update Profile</a></li>
            <li><a href="view_books.php">View Available Books</a></li>
            <li><a href="user_borrow_request.php">Borrow Request</a></li>
            <li><a href="issued_books.php">Issued Books</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>
</div>

</body>
</html>