<?php

require ('scripts/data_init/vendor/autoload.php');

define('ROOT_URL','http://localhost/recordsapp/');
define('DB_HOST', 'localhost');
define('DB_USER', 'ren');
define('DB_PASS', '122846');
define('DB_NAME', 'recordsapp_db');
define('DB_PORT', '3307');

$faker = Faker\Factory::create('en_PH');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

function iteration_reset($conn): void{ # likely to delete
    foreach (['office','employee','transaction'] as $x){
        $query = "alter table ".$x." auto_increment = 1";
        mysqli_query($conn, $query);
    }
}

function faker_office($faker,$conn): void {
    for($i = 1 ;$i <= 10; $i++){ # 50
        $sql = "INSERT INTO recordsapp_db.office(`name`,`contactnum`,`email`,`address`,`city`,`country`,`postal`) VALUES
        ('$faker->company','$faker->phoneNumber','$faker->email','$faker->address','$faker->city','$faker->country','$faker->postcode');";
    
        try{
            mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
        }catch(Exception){
            $i--;
        }
    }

}

function faker_employee($faker,$conn): void {
    for($i = 1 ;$i <= 200; $i++){ # 200

        $query = "SELECT id from office order by id asc";
        $result = mysqli_query($conn, $query);
        $off = [];
        
        while($x = mysqli_fetch_column($result, 0)){
            array_push($off, $x);
        }

        $random_office_id = $faker->numberBetween($min = 0, $max = count($off) - 1);
        $sql = "INSERT INTO recordsapp_db.employee(`lastName`,`firstName`,`office_id`,`address`) VALUES
        ('$faker->lastName','$faker->firstName','$off[$random_office_id]','$faker->address');";
    
        try{
            mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
        } catch(Exception $e){
            $i--;
        }
    }
}

function faker_transaction($faker,$conn): void {
    for($i = 1 ;$i <= 500; $i++){ # 500
        $newtime = $faker->dateTime($max = 'now', $timezone = null);
        $newtime = $newtime->format('Y-m-d H:i:s');
        
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
    
        $sql = "INSERT INTO recordsapp_db.transaction(`employee_id`,`office_id`,`datelog`,`action`,`remarks`,`documentcode`) VALUES
        ('$emp','$off','$newtime','".$faker->randomElement(['IN','OUT','COMPLETE'])."','$faker->word','$faker->numberBetween($min = 100, $max = 400)');";
    
    
        mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
    }
}
#iteration_reset($conn); # temporary
#faker_office($faker,$conn);
faker_employee($faker,$conn);
#faker_transaction($faker,$conn);

mysqli_close($conn);

