<?php 
                    include ('./admin/required.php');
                    $orderid = rand(0, 999999999);
                    $tafel = $conn->real_escape_string($_POST['tableid']);
                    $productid = $conn->real_escape_string($_POST['productIds']);
                    $totaal = $conn->real_escape_string($_POST['totaal']);
                    $betaling = $conn->real_escape_string($_POST['betaling']);


                  $query1 = "INSERT INTO orders (idorders, tableid, betaling, totaal, description2) VALUES ('$orderid', '$tafel', '$betaling', '$totaal', '$productid')";
                    $sql = mysqli_query($conn, $query1);
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                      if($sql === true) {
                    header("location: ./index.php");
                      }
                }
                ?>