<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ims";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM sell_products");

$totalSpace = $totalCost = 0;

if ($result->num_rows > 0) {
    echo "<h2>Sell Product List</h2><form method='post' action=''>
            <table style='border-collapse: collapse; width: 100%;'>
                <tr><th style='border: 1px solid #dddddd; padding: 8px;'>Product Name</th><th style='border: 1px solid #dddddd; padding: 8px;'>Price</th><th style='border: 1px solid #dddddd; padding: 8px;'>Quantity</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td style='border: 1px solid #dddddd; padding: 8px;'>{$row['productName']}</td>
                <td style='border: 1px solid #dddddd; padding: 8px;'>{$row['price']}</td>
                <td style='border: 1px solid #dddddd; padding: 8px;'>{$row['quantity']}</td>
              </tr>";

       
        $totalCost += floatval($row['price']) * intval($row['quantity']);
    }

    echo "</table></form><div><h2>Total Space: $totalSpace</h2><h2>Total Cost: $totalCost</h2></div>";
} else {
    echo "<p>No products found.</p>";
}

$conn->close();
?>
<html>
    <head>
        <title>Inventory Management System</title>
        <style>
            .btn {
            background-color: green;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        </style>
    </head>
    <body>
    <div id="order-button"><center><br>
                <a href="sell.php"><button type="submit" class="btn">Sell More</button></a>
            </center> 
        </div> 
    </body>
</html>
