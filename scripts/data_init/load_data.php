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

# Creates n total of fake rows for office

function faker_office($faker,$conn): void {
    for($i = 1 ;$i <= 50; $i++){ # 50
        $sql = "INSERT INTO recordsapp_db.office(`name`,`contactnum`,`email`,`address`,`city`,`country`,`postal`) VALUES
        ('$faker->company','$faker->phoneNumber','$faker->email','$faker->address','$faker->city','$faker->country','$faker->postcode');";
    
        try{
            mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
        }catch(Exception){
            $i--;
        }
    }

}

# Creates n total of fake rows for employee
# 
# Office_id is acquired by getting the id rows from office table
# Office_id index is then randomized by faker
function faker_employee($faker,$conn): void {
    for($i = 1 ;$i <= 200; $i++){ # 200

        $query = "SELECT id from office order by id asc";
        $result = mysqli_query($conn, $query);
        
        $office_id = [];
        while($x = mysqli_fetch_column($result, 0)){
            array_push($office_id, $x);
        }

        $random_office_id = $faker->numberBetween($min = 0, $max = count($office_id) - 1);
        $sql = "INSERT INTO recordsapp_db.employee(`lastName`,`firstName`,`office_id`,`address`) VALUES
        ('$faker->lastName','$faker->firstName','$office_id[$random_office_id]','$faker->address');";
    
        try{
            mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
        } catch(Exception $e){
            $i--;
        }
    }
}

# Creates n total of fake rows for employee
# 
# Office_id is acquired by getting the id rows from office table, and Employee_id is acquired from employee table
# Office_id and Employee_id index is then randomized by faker while maintaining relevancy to current id rows.
function faker_transaction($faker,$conn): void {
    for($i = 1 ;$i <= 500; $i++){ # 500
        $newtime = $faker->dateTime($max = 'now')->format('Y-m-d H:i:s');
        #$newtime = $newtime->format('Y-m-d H:i:s');

        # Get Employee_id value
        $query = "SELECT id from employee order by id asc";
        $result = mysqli_query($conn, $query);
        
        $employee_id = [];
        while($x = mysqli_fetch_column($result,0)){
            array_push($employee_id, $x);  
        }
        
        # Get Office_id value
        $query = "SELECT id from office order by id asc";
        $result = mysqli_query($conn, $query);
        
        $office_id = [];
        while($x = mysqli_fetch_column($result,0)){
            array_push($office_id, $x);
        }
        
        $random_office_id = $faker->numberBetween($min = 0, $max = count($office_id) - 1);
        $random_employee_id = $faker->numberBetween($min = 0, $max = count($employee_id) - 1);

        $sql = "INSERT INTO recordsapp_db.transaction(`employee_id`,`office_id`,`datelog`,`action`,`remarks`,`documentcode`) VALUES
        ('$employee_id[$random_employee_id]','$office_id[$random_office_id]','$newtime','".$faker->randomElement(['IN','OUT','COMPLETE'])."','$faker->word','$faker->numberBetween($min = 100, $max = 400)');";
    
    
        mysqli_query($conn, $sql); # since mysql hates some faker generation, we let iteration rerun.
    }
}

# The order of calling these functions extremely matters due to foreign keys.
faker_office($faker,$conn);
faker_employee($faker,$conn);
faker_transaction($faker,$conn);

mysqli_close($conn);

