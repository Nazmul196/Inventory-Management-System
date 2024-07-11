<?php
$servername = "localhost";
$username = "root"; // Different in real life
$password ="";  // STRONG PASS real life 
$dbname ="inventoryms"; // Different real life 

$conn = new mysqli($servername,$username,$password,$dbname); 

if ($conn->connect_error)
echo "<script>
  alert('Hello\nHow are you?');
</script>";

else 
echo "<script>
  alert('Hello\nHow are you?');
</script>";
?>