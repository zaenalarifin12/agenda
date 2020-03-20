<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$db         = "agenda";

$conn = mysqli_connect($servername, $username, $password, $db) or die(mysqli_error());

// $result = mysqli_query($conn, $sql);

// if (mysqli_num_rows($result) > 0) {
//     echo "ada";
// } else {
//     echo "data tidak ada";
// }


// mysqli_close($conn);

?>