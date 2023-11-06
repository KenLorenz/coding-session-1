<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Light Bootstrap Dashboard - Free Bootstrap 4 Admin Dashboard by Creative Tim</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="/assets/css/demo.css" rel="stylesheet" />
</head>

<body>
    
<?php

require('config/config.php');
require('config/db.php');

$id = $_GET['id'];

$query = "SELECT * FROM transaction WHERE id=" . $id;

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result)==1){
    //fetch them datas
    $transaction = mysqli_fetch_array($result);
    $documentcode = $transaction['documentcode'];
    $action = $transaction['action'];
    $remarks = $transaction['remarks'];
    $employee_id = $transaction['employee_id'];
    $office_id = $transaction['office_id'];
}
?>

    <div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
            
            <div class="sidebar-wrapper">
                <?php include('includes/sidebar.php') ?>
                <!-- 1 -->
            </div>
        </div>
        <div class="main-panel">
            <?php include('includes/navbar.php') ?>
<?php

    require('config/config.php');
    require('config/db.php');

    // check if submitted
    if(isset($_POST['submit'])){
        // Get form data
        $documentcode = mysqli_real_escape_string($conn,$_POST['documentcode']);
        $action = mysqli_real_escape_string($conn,$_POST['action']);
        $remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
        $employee_id = mysqli_real_escape_string($conn,$_POST['employee_id']);
        $office_id = mysqli_real_escape_string($conn,$_POST['office_id']);
        
        // Create insert query
        $query = "UPDATE transaction SET documentcode='$documentcode', action='$action', remarks='$remarks', employee_id='$employee_id', office_id='$office_id'
        WHERE id=" . $id;
        // Execute query    
        if(mysqli_query($conn, $query)){
        }else{
            echo 'ERROR: '.mysqli_error($conn);
        }
    }
    

?>
            <div class="content">
                <div class="container-fluid">
                    <div class="section">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Edit Profile</h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                                        <div class="row">
                                            <div class="col-md-3 pr-1">
                                                <div class="form-group">
                                                    <label>Document Code</label>
                                                    <input type="text" class="form-control" name="documentcode" value="<?php echo $documentcode ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 px-1">
                                                <div class="form-group">
                                                    <label>Action</label>
                                                    <select class="form-control" name="action">
                                                        
                                                        <?php
                                                        echo "<option selected>" . $action . '</option>';

                                                        if($action != "IN") echo "<option>" . 'IN' . '</option>';
                                                        if($action != "OUT") echo "<option>" . 'OUT' . '</option>';
                                                        if($action != "COMPLETE") echo "<option>" . 'COMPLETE' . '</option>';
                                                        ?>
                                                        
                                                        <!-- <option>IN</option>
                                                        <option>OUT</option>
                                                        <option>COMPLETE</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 pr-1">
                                                <div class="form-group">
                                                    <label>Remarks</label>
                                                    <input type="text" class="form-control" name="remarks" value="<?php echo $remarks ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 pl-1">
                                                <div class="form-group">
                                                    <label for="employee_id">Employee</label>
                                                    <select class="form-control" name="employee_id">
                                                    <option>Select</option>
                                                    <?php
                                                    $query = "SELECT id, CONCAT(lastname, ' ', firstname) as 'name' FROM employee";
                                                    $result = mysqli_query($conn, $query);
                                                    while($row = mysqli_fetch_array($result)){
                                                        if($row['id'] == $employee_id){
                                                            echo "<option value=". $row['id'] . " selected>" . $row['name'] . '</option>';
                                                        }else{
                                                            echo "<option value=". $row['id'] . ">" . $row['name'] . '</option>';
                                                        }
                                                    }

                                                    ?>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-3 pl-1">
                                                <div class="form-group">
                                                    <label for="office_id">Office</label>
                                                    <select class="form-control" name="office_id">
                                                    <option>Select</option>
                                                    <?php
                                                    $query = "SELECT id, name FROM office";
                                                    $result = mysqli_query($conn, $query);
                                                    while($row = mysqli_fetch_array($result)){
                                                        if($row['id'] == $office_id){
                                                            echo "<option value=". $row['id'] . " selected>" . $row['name'] . '</option>';
                                                        }else{
                                                            echo "<option value=". $row['id'] . ">" . $row['name'] . '</option>';
                                                        }
                                                    }

                                                    
                                                    ?>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" name="submit" value="Submit" class="btn btn-info btn-fill pull-right">Save</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-center">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                        </p>
                    </nav>
                </div>
            </footer>
        </div>
    </div>
    
</body>
<!--   Core JS Files   -->
<script src="assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<script src="assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>

</html>


