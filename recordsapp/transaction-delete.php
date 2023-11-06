<?php

require('config/config.php');
require('config/db.php');

$id = $_GET['id'];
$query = "DELETE FROM transaction WHERE id=" . $id;

if(mysqli_query($conn, $query)){
}else{
    echo 'ERROR: '.mysqli_error($conn);
}

header("Location:index.php");
?>