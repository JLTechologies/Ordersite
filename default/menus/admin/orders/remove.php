<?php 
include ('../required.php');
session_start();
$_SESSION['message'] = '';
$id = htmlspecialchars($_GET["id"]);

$remove = "DELETE FROM orders WHERE idorders = '$id'";
if ($conn->query($remove) === true) {
    header("location: ./index.php");
}
else {
    $_SESSION['message'] = "order could not be removed";
}
mysqli_close($conn);

?>