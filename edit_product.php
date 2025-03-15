<?php
session_start();


if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}


include '../database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM inventory WHERE item_id = $product_id");
    $product = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $description = $_POST['description'];
    $reorder_level = $_POST['reorder_level'];
    
    $sql = "UPDATE inventory SET item_name='$product_name', description='$description', price='$product_price', quantity='$product_quantity', reorder_level='$reorder_level' WHERE item_id=$product_id";
    $conn->query($sql);
    header("Location: product_management.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Inventory Management System</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/product_management.js" defer></script>

</head>
<body>
    <h1 class="text-center">Edit Product</h1>
    <form method="POST" action="" class="form-inline" onsubmit="return validateForm();">

        <input type="hidden" name="product_id" value="<?php echo $product['item_id']; ?>">
        <input type="text" name="product_name" placeholder="Product Name" value="<?php echo $product['item_name']; ?>" required>
        <textarea name="description" placeholder="Description" required><?php echo $product['description']; ?></textarea>
        <input type="number" name="product_price" placeholder="Product Price" value="<?php echo $product['price']; ?>" required>
        <input type="number" name="product_quantity" placeholder="Quantity" value="<?php echo $product['quantity']; ?>" required>
        <input type="number" name="reorder_level" placeholder="Reorder Level" value="<?php echo $product['reorder_level']; ?>" required>
        <button type="submit">Update Product</button>
    </form>
</body>
</html>
