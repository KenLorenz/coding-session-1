<?php

require('config/config.php');
require('config/db.php');

$id = $_GET['id'];
$query = "DELETE FROM employee WHERE id=" . $id;

if(mysqli_query($conn, $query)){
}else{
    echo 'ERROR: '.mysqli_error($conn);
}

# will do later
# moves transations employee_id that had the deleted employee


header("Location:index.php");
