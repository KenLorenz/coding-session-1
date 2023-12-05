<?php

$conn = mysqli_connect(DB_HOST,DB_NAME,DB_PASS,DB_DATABASE,DB_PORT);

if(mysqli_connect_errno()){
    echo 'Failed to Connect to MySQL ' . mysqli_connect_errno();
}