<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Library Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <style>
    /* Reset Default Margins */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      line-height: 1.6;
    }

    header {
      background: url("assets/images/librarybg.jpg") no-repeat center center/cover;
      height: 100vh;
      color: white;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    header h1 {
      font-size: 4rem;
      text-transform: uppercase;
      letter-spacing: 3px;
    }

    header p {
      font-size: 1.5rem;
      margin: 20px 0;
    }

    header .btn {
      background: #030202b0;
      color: white;
      padding: 13px 30px;
      text-decoration: none;
      text-transform: uppercase;
      border: none;
      cursor: pointer;
      border-radius: 9px;
      transition: background 0.3s ease;
      font-size: 1.1rem;
    }

    header .btn:hover {
      background: black;
    }

    section {
      padding: 60px 20px;
    }

    .feature-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .card img {
      max-width: 100%;
      border-radius: 10px;
    }

    .card h3 {
      margin-top: 15px;
      color: #333;
    }

    .footer {
      background-color: #333;
      color: white;
      padding: 20px 0;
      text-align: center;
    }

    .footer a {
      color: #ff6f61;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <!-- Hero Section -->
  <header>
    <h1>Library Management System</h1>
    <p>Explore resources, manage your account, and discover new books.</p>
    <div>
      <a href="admin/login.php" class="btn">Admin Panel</a>
      <a href="pages/login.php" class="btn">User Panel</a>
    </div>
  </header>

    <!-- About Section -->
    <section>
    <div class="feature-grid">
      <div class="card">
        <h3>Easy Book Management</h3>
        <p>Admins can add, update, and delete books, authors, and categories effortlessly.</p>
      </div>
      <div class="card">
        <h3>Student-Friendly</h3>
        <p>Students can request books, view issued books, and check due fines online.</p>
      </div>
      <div class="card">
        <h3>Secure Online Payments</h3>
        <p>Pay fines securely and instantly update your account balance.</p>
      </div>
    </div>
  </section> 

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; 2025 Library Management System. All Rights Reserved.</p>
    <p>Designed to simplify book management and borrowing for libraries and students.</p>
    <p>
      Contact us: <a href="mailto:support@librarysystem.com">support@librarysystem.com</a>
    </p>
    <p>
      Follow us:
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
    </p>
  </footer> 

</body>

</html>