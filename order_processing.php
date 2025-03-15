<?php
session_start();
include '../database/db_connect.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Handle order placement
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    
    $checkProductStmt = $conn->prepare("SELECT id, price FROM products WHERE id = ?");
    $checkProductStmt->bind_param("i", $product_id);
    $checkProductStmt->execute();
    $checkProductStmt->bind_result($product_id, $product_price);
    $checkProductStmt->fetch();

if ($product_price === null) {
    echo "<script>alert('Error: Product price not found.');</script>";
    exit();
}

if ($quantity <= 0) {
    echo "<script>alert('Error: Quantity must be greater than zero.');</script>";
    exit();
}

error_log("Product price: " . $product_price); // Debug statement to log the product price
error_log("Quantity: " . $quantity); // Debug statement to log the quantity
$total_amount = $product_price * $quantity; // Calculate total amount



    $checkProductStmt->bind_param("i", $product_id);
    $checkProductStmt->execute();
    $checkProductStmt->store_result();

    if ($checkProductStmt->num_rows > 0) {
        // $stmt = $conn->prepare("INSERT INTO order1 (customer_name, product_id, quantity, order_date, status) VALUES ( ?, ?, ?, ?, 'Pending')");
        // $stmt->bind_param("ssisi", $_POST['customer_name'], $_POST['customer_email'], $product_id, $quantity, $_POST['order_date'], $status);
        $stmt = $conn->prepare("INSERT INTO order1 (customer_name, customer_email, product_id, quantity, order_date, status) VALUES (?, ?, ?, ?, ?, ?)");
        error_log("Status value: " . $_POST['status']); // Debug statement to log the status value
        $stmt->bind_param("ssisis", $_POST['customer_name'], $_POST['customer_email'], $product_id, $quantity, $_POST['order_date'], $_POST['status']);



        if ($stmt->execute()) {
            // Insert data into invoices table
            $order_id = $stmt->insert_id;
            // $invoiceStmt = $conn->prepare("INSERT INTO invoices (customer_name, quantity, order_date) VALUES ( ?, ?, ?)");
            // $invoiceStmt->bind_param("ssisi", $_POST['customer_name'], $_POST['customer_email'], $product_id, $quantity, $_POST['order_date']);
            // $product_price = $_POST['product_price']; // Assuming product price is passed in the form
            $invoiceStmt = $conn->prepare("INSERT INTO invoices (order_id, total_amount, customer_name) VALUES (?, ?, ?)");
            $invoiceStmt->bind_param("ids", $order_id, $total_amount, $_POST['customer_name']);

            $invoiceStmt->execute();

            // Redirect to invoice generation page
            header("Location: invoice_generation.php?customer_name=" . urlencode($_POST['customer_name']) . "&order_id=" . $conn->insert_id . "&total_amount=" . ($quantity * $_POST['product_price']));
            exit();

        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error: Product ID does not exist.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Processing - Inventory System</title>
    <link rel="stylesheet" href="../css/dashboard.css">


</head>
<body>
   
    <div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">


    <div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #333;">Place Order</h2>
        <form method="POST" onsubmit="return confirmOrder();" style="text-align: left;">
            <label style="font-weight: bold;">Customer Name</label>
            <input type="text" name="customer_name" required style="width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px;"><br>
            
            <label style="font-weight: bold;">Customer Email</label>
            <input type="email" name="customer_email" required style="width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px;"><br>
            
            <label style="font-weight: bold;">Product ID</label>
            <input type="number" name="product_id" required style="width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px;"><br>
            
            <label style="font-weight: bold;">Quantity</label>
            <input type="number" name="quantity" required style="width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px;"><br>
            
            <label style="font-weight: bold;">Order Date</label>
            <input type="date" name="order_date" required style="width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px;"><br>
            
            <label style="font-weight: bold;">Status</label>
            <select name="status" required style="width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px;">
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="Canceled">Canceled</option>
            </select><br>

            <button type="submit" name="place_order" style="width: 100%; padding: 10px; background: blue; color: white; border: none; font-size: 16px; border-radius: 4px; cursor: pointer;">Place Order</button>
        </form>

        <h2 style="color: #333; margin-top: 20px;">Order History</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tr style="background: #007BFF; color: white;">
                <th style="padding: 8px;">Order ID</th>
                <th style="padding: 8px;">Product</th>
                <th style="padding: 8px;">Quantity</th>
                <th style="padding: 8px;">Status</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM order1");
            while ($row = $result->fetch_assoc()) {
                echo "<tr style='border-bottom: 1px solid #ddd; background: #fff;'>
                        <td style='padding: 8px;'>{$row['id']}</td>
                        <td style='padding: 8px;'>{$row['product_id']}</td>
                        <td style='padding: 8px;'>{$row['quantity']}</td>
                        <td style='padding: 8px; color: " . ($row['status'] == 'Completed' ? 'green' : ($row['status'] == 'Canceled' ? 'red' : 'orange')) . ";'>{$row['status']}</td>
                      </tr>";
            }
            ?>
        </table>
    </div>

    <script>
        function confirmOrder() {
            return confirm("Are you sure you want to place this order?");
        }
    </script>

</body>
</html>
