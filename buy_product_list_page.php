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

    if (isset($_POST['delete'])) {
        $productId = $_POST['delete'];
        $deleteSql = "DELETE FROM stock WHERE id = $productId";
        $conn->query($deleteSql) or die("Error deleting record: " . $conn->error);
    } else {
        foreach ($_POST['productName'] as $key => $productName) {
            $productName = $conn->real_escape_string($productName);
            $price = floatval($_POST['price'][$key]);
            $space = $conn->real_escape_string($_POST['space'][$key]);
            $quantity = intval($_POST['quantity'][$key]);

            $sql = "INSERT INTO stock (productName, price, space, quantity) VALUES ('$productName', $price, '$space', $quantity)";

            $conn->query($sql) or die("Error: " . $sql . "<br>" . $conn->error);
        }
    }

    $conn->close();

    echo '<script type="text/javascript">window.onload = function () { alert("Products Successfully Deleted."); } </script>';
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM stock");

$totalSpace = $totalCost = 0;

if ($result->num_rows > 0) {
    echo "<h2>Product List</h2><form method='post' action=''>
            <table style='border-collapse: collapse; width: 100%;'>
                <tr><th style='border: 1px solid #dddddd; padding: 8px;'>Product Name</th><th style='border: 1px solid #dddddd; padding: 8px;'>Price</th><th style='border: 1px solid #dddddd; padding: 8px;'>Space</th><th style='border: 1px solid #dddddd; padding: 8px;'>Quantity</th><th style='border: 1px solid #dddddd; padding: 8px;'>Actions</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td style='border: 1px solid #dddddd; padding: 8px;'>{$row['productName']}</td>
                <td style='border: 1px solid #dddddd; padding: 8px;'>{$row['price']}</td>
                <td style='border: 1px solid #dddddd; padding: 8px;'>{$row['space']}</td>
                <td style='border: 1px solid #dddddd; padding: 8px;'>{$row['quantity']}</td>
                <td style='border: 1px solid #dddddd; padding: 8px;'>
                    <button type='submit' name='delete' value='{$row['id']}'>Delete</button>
                </td>
              </tr>";

        $totalSpace += intval($row['space']) * intval($row['quantity']);
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
                <a href="buy_product.php"><button type="submit" class="btn">Buy More</button></a>
            </center> 
        </div> 
    </body>
</html>
