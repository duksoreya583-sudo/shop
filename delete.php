<?php

include 'db.php';

$id = $_GET['id'];

$result = mysqli_query(
$conn,
"SELECT img FROM products WHERE id='$id'"
);

$row = mysqli_fetch_assoc($result);

if(file_exists($row['img'])){
    unlink($row['img']);
}

mysqli_query(
$conn,
"DELETE FROM products WHERE id='$id'"
);

header("Location: dashboard.php");

?>