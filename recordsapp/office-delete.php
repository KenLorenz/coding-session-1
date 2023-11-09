<?php

require('config/config.php');
require('config/db.php');

$id = $_GET['id'];
$query = "DELETE FROM office WHERE id=" . $id;

if(mysqli_query($conn, $query)){
}else{
    echo 'ERROR: '.mysqli_error($conn);
}

# will do later
# moves transations office_id that had the deleted office
# moves employee that had the deleted office

header("Location:index.php");
