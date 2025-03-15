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
    <title>Sales Reporting - Inventory System</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>

    <div class="container">
        <h2>Sales Report</h2>
        <canvas id="salesChart"></canvas>
    </div>


    <script>
        let ctx = document.getElementById("salesChart").getContext("2d");
        let salesChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["January", "February", "March", "April", "May"],
                datasets: [{
                    label: "Sales",
                    data: [3000, 2500, 4000, 4500, 3800],
                    backgroundColor: "blue"
                }]
            }
        });
    </script>
</body>
</html>
