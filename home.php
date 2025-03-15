<?php
session_start();

// Check if the user is logged in, if not then redirect them to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Inventory Management System</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/295/295128.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="styles.css">
</head>

<body>
    
    <main>
        <h1>Welcome to the Inventory Management System</h1>
        <p>This system helps you manage your inventory efficiently, keeping track of stock levels, orders, sales, and deliveries.</p>
        <p>To get started, please visit the following sections:</p>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="product_management.php">Product Management</a></li>
            <li><a href="order_processing.php">Order Processing</a></li>
            <li><a href="stock_alerts.php">Stock Alerts</a></li>
            <li><a href="invoice_generation.php">Invoice Generation</a></li>
            <li><a href="sales_reporting.php">Sales Reporting</a></li>
        </ul>

    </main>

    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="username" name="email" required placeholder="Enter your email">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>
        <button type="submit">
            Login

        </button>
        <p>Don't have an account? <a href="signup.php">sign up here!</a></p>
    </form>


    
</body>
</html>
