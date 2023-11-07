<?php

require ('scripts/data_init/vendor/autoload.php');

$faker = Faker\Factory::create('en_PH');

$conn = mysqli_connect("localhost", "ren", "122846", "recordsapp_db", 3307); 

# transaction
for($i = 1 ;$i <= 500; $i++){
    $newtime = $faker->dateTime($max = 'now', $timezone = null);
    $newtime = $newtime->format('Y-m-d H:i:s');
    
    /* $arr = array('IN','OUT','COMPLETE');
    $ok = $arr[rand(0,2)]; */
    
    $query = "SELECT id from employee order by id desc LIMIT 1";
    $result = mysqli_query($conn, $query);

    while($x = mysqli_fetch_array($result)){
        $emp = $faker->numberBetween($min = 1, $x['id']);    
    }
    

    $query = "SELECT id from office order by id desc LIMIT 1";
    $result = mysqli_query($conn, $query);
    

    while($x = mysqli_fetch_array($result)){
        $off = $faker->numberBetween($min = 1, $x['id']);
    }

    $sql = "INSERT INTO recordsapp_db.transaction(`employee_id`,`office_id`,`datelog`,`action`,`remarks`,`documentcode`) VALUES('$emp','$off','$newtime','".$faker->randomElement(['IN','OUT','COMPLETE'])."','$faker->word','$faker->numberBetween($min = 100, $max = 400)');";


    $test = mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
}

# employee
for($i = 1 ;$i <= 200; $i++){
    $query = "SELECT id from office order by id desc LIMIT 1";
    $result = mysqli_query($conn, $query);

    
    while($x = mysqli_fetch_array($result)){
        $off = $faker->numberBetween($min = 1, $x['id']);
    }

    $sql = "INSERT INTO recordsapp_db.employee(`lastName`,`firstName`,`office_id`,`address`) VALUES('$faker->lastName','$faker->firstName','$off','$faker->address');";

    try{
        $test = mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
    } catch(Exception $e){
        $i--;
    }
}

# office

for($i = 1 ;$i <= 50; $i++){
    $sql = "INSERT INTO recordsapp_db.office(`name`,`contactnum`,`email`,`address`,`city`,`country`,`postal`) VALUES('$faker->company','$faker->phoneNumber','$faker->email','$faker->address','$faker->city','$faker->country','$faker->postcode');";

    try{
        $test = mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
    } catch(Exception $e){
        $i--;
    }
}

mysqli_close($conn);

?>