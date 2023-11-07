<?php

require ('vendor/autoload.php');
$faker = Faker\Factory::create('en_PH');

$conn = mysqli_connect("localhost", "ren", "122846", "recordsapp_db", 3307); 

# transaction
for($i = 1 ;$i <= 100; $i++){
    $newtime = $faker->dateTime($max = 'now', $timezone = null);
    $newtime = $newtime->format('Y-m-d H:i:s');
    
    $arr = array('IN','OUT','COMPLETE');
    $ok = $arr[rand(0,2)];

    # the two foreign keysssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss
    $emp = $faker->numberBetween($min = 1000, $max = 9000);
    $off = $faker->numberBetween($min = 1000, $max = 9000);

    $sql = "INSERT INTO recordsapp_db.transaction(`employee_id`,`office_id`,`datelog`,`action`,`remarks`,`documentcode`) VALUES('$sure','$sure','$newtime','$ok','$faker->word','$sure');";

    try{
        $test = mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
    } catch(Exception $e){
        $i--;
    }
}

# employee
for($i = 1 ;$i <= 50; $i++){
    $sql = "INSERT INTO recordsapp_db.employee(`lastName`,`firstName`,`office_id`,`address`) VALUES('$faker->lastName','$faker->firstName','$faker->randomDigit','$faker->address');";

    try{
        $test = mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
    } catch(Exception $e){
        $i--;
    }
}

# office
for($i = 1 ;$i <= 200; $i++){
    $sql = "INSERT INTO recordsapp_db.office(`name`,`contactnum`,`email`,`address`,`city`,`country`,`postal`) VALUES('$faker->company','$faker->phoneNumber','$faker->email','$faker->address','$faker->city','$faker->country','$faker->postcode');";

    try{
        $test = mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
    } catch(Exception $e){
        $i--;
    }
}


mysqli_close($conn);

?>