<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Product List</title>
</head>
<body>
    <h1>Inventory Product List</h1>
    <div style="padding-bottom: 100px;">
        <table style="border: 1px solid black;border-collapse: collapse;">
            <tr>
                <th style="padding-right: 150px;">name</th>
                <th style="padding-right: 150px;">price</th>
                <th style="padding-right: 150px;">space</th>
                <th style="padding-right: 50px;">quantity</th>
            </tr>
            <?php 
                include 'dbcon.php';
                $SQLsw ="SELECT names,price,space,quantity from inventoryproducts"; 
                $res = $conn->query($SQLsw);

                foreach ($res as $row)
                {
                    echo"<tr>";
                    //echo $row['names']; 
                    echo "<td>".$row['names']."</td>";
                    echo "<td>".$row['price']."</td>";
                    echo "<td>".$row['space']."</td>";
                    echo "<td>".$row['quantity']."</td>";
                    echo "<td><button>remove</button></td>";
                    echo"</tr>";
                }
            ?>
        </table>
    </div>

    <table>
        <tr>
            <th style="padding-right: 300px;">
                Current amount
            </th>
            <th>
                Updated amount
            </th>
        </tr>
        <tr>
            <td>
                <h2>Total price: 3100</h2> <br>
                <h2>Total space: 160</h2>
            </td>
            <td>
                <h2>Total price: 900</h2> <br>
                <h2>Total space: 45</h2>
            </td>
        </tr>
        <tr>
            <td><button>Update</button></td>
        </tr>
    </table>
</body>
</html>