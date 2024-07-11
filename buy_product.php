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

    foreach ($_POST['productName'] as $key => $productName) {
        $productName = $conn->real_escape_string($productName);
        $price = floatval($_POST['price'][$key]);
        $space = $conn->real_escape_string($_POST['space'][$key]);
        $quantity = intval($_POST['quantity'][$key]);

        // Check if the product with the same name already exists
        $existingProductQuery = "SELECT * FROM stock WHERE productName = '$productName'";
        $existingProductResult = $conn->query($existingProductQuery);

        if ($existingProductResult->num_rows > 0) {
            // Product with the same name exists, update the existing record
            $existingProduct = $existingProductResult->fetch_assoc();
            $existingPrice = floatval($existingProduct['price']);
            $existingSpace = $existingProduct['space'];
            $existingQuantity = intval($existingProduct['quantity']);

            // Calculate the average price
            $newPrice = ($existingPrice * $existingQuantity + $price * $quantity) / ($existingQuantity + $quantity);

            // Update the existing record, adding new space to the existing space
            $newSpace = $existingSpace + $space;
            $updateQuery = "UPDATE buy_products SET price = $newPrice, space = '$newSpace', quantity = quantity + $quantity WHERE productName = '$productName'";
            $conn->query($updateQuery) or die("Error updating record: " . $conn->error);
        } else {
            // Product with the same name does not exist, insert a new record
            $insertQuery = "INSERT INTO stock (productName, price, space, quantity) VALUES ('$productName', $price, '$space', $quantity)";
            $conn->query($insertQuery) or die("Error: " . $conn->error);
        }
    }

    $conn->close();

    echo '<script type="text/javascript">window.onload = function () { alert("Products Successfully Added to Order."); } </script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

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
    <h2>Buy Products</h2>

    <form method="post" action="">
        <table>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Space</th>
                <th>Quantity</th>
            </tr>
            <tr>
                <td><input type="text" name="productName[]"></td>
                <td><input type="number" name="price[]"></td>
                <td><input type="number" name="space[]"></td>
                <td><input type="number" name="quantity[]" min="1"></td>
            </tr>
        </table>

        <div id="order-button">
            <center><br>
                <button type="submit" class="btn">Buy</button>
            </center>
        </div>

    </form>
    <div>
        <center><br>
            <a href="buy_product_list_page.php"><button class="btn">Order List</button></a>
        </center>
    </div>
</body>

</html>
