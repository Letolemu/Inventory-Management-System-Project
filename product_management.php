<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include '../database/db_connect.php';

// Handle product addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $product_quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $reorder_level = $_POST['reorder_level'];

    $stmt = $conn->prepare("INSERT INTO products (name, description, quantity, price, restocking_threshold) VALUES (?, ?, ?, ?, ?)");



    $stmt->bind_param("ssiii", $product_name, $description, $product_quantity, $price, $reorder_level);
    $stmt->execute();
}
?>

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
    <title>Product Management - Inventory System</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/295/295128.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/product_management.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Product Management</h1>

        <!-- Add Product Form -->
        <form method="POST" action="" class="form-container">
            <h2 class="mt-4">Add New Product</h2>
            <input type="text" name="product_name" placeholder="Product Name" required><br>
            <input type="text" name="description" placeholder="Description" required><br>
            <input type="number" name="quantity" placeholder="Product Quantity" required><br>
            <input type="number" name="price" placeholder="Price of Product" required><br>
            <input type="number" name="reorder_level" placeholder="Reorder Level" required><br>
            <button type="submit" name="add_product" class="btn">Add Product</button>
        </form>

        <!-- Display Existing Products -->
        <h2 class="mt-4">Existing Products</h2>
        <table class="table">
            <tr class="table-header">
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM products");



            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['name']}</td>

                        <td>{$row['price']}</td>
                        <td>{$row['quantity']}</td>
                        <td>
                            <a href='edit_product.php?id={$row['id']}' class='btn-edit'>Edit</a>
                            <a href='delete_product.php?id={$row['id']}' class='btn-delete' onclick='return confirmDelete()'>Delete</a>

                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
