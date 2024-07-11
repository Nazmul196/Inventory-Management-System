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
    <h2>Add sold Products</h2>

    <form method="post" action="">
        <table>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            <tr>
                <td><input type="text" name="productName[]"></td>
                <td><input type="number" name="price[]"></td>
                <td><input type="number" name="quantity[]" min="1"></td>
            </tr>
        </table>

        <div id="order-button">
            <center><br>
                <button type="submit" class="btn">Sell!</button>
            </center>
        </div>

    </form>
    <div>
        <center><br>
            <a href="sell_list.php"><button class="btn">Sold List</button></a>
        </center>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the sold products data
        $productNames = $_POST['productName'];
        $prices = $_POST['price'];
        $quantities = $_POST['quantity'];

        // Create a connection to the MySQL database
        $servername = "localhost";
        $username = "root"; // MySQL username
        $password = "";
        $dbname = "ims"; // Your database name

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Save each product to the database
        for ($i = 0; $i < count($productNames); $i++) {
            $productName = $conn->real_escape_string($productNames[$i]);
            $price = floatval($prices[$i]);
            $quantity = intval($quantities[$i]);

            // Corrected SQL query
            $sql = "INSERT INTO sell_products (productName, price, quantity) VALUES ('$productName', '$price', '$quantity')";

            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Update stock by subtracting the sold quantity
            $updateStockQuery = "UPDATE stock SET quantity = GREATEST(quantity - $quantity, 0) WHERE productName = '$productName'";
            $conn->query($updateStockQuery) or die("Error updating stock record: " . $conn->error);
        }

        // Close the database connection
        $conn->close();

        // Display a success message
        echo '<script type="text/javascript">
            window.onload = function () { alert("Sell Products Successfully Added."); } 
         </script>';
    }
    ?>

</body>

</html>
