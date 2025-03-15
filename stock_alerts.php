<?php
session_start();
include '../database/db_connect.php';

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
    <title>Stock Alerts - Inventory System</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/styles.css">


    <style type="text/css">

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .alert {
            background: #ffcccc;
        }

        button {
            padding: 10px;
            border: none;
            background: blue;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: darkblue;
        }

    </style>
</head>
<body>
   

    <div class="container">
        <h2>Low Stock Alerts</h2>
        <table class="table">
            <tr><th>Product</th><th>Stock</th><th>Reorder Level</th></tr>
            <?php
            $result = $conn->query("SELECT * FROM inventory WHERE quantity <= reorder_level");
            while ($row = $result->fetch_assoc()) {
                echo "<tr class='alert'><td>{$row['item_name']}</td><td>{$row['quantity']}</td><td>{$row['reorder_level']}</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>



