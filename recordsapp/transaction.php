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

    //gets the value sent over search form
    $search = $_GET['search'];

    //define total number of results you want per page
    $results_per_page = 10;
    $query = "SELECT * FROM transaction";
    $result = mysqli_query($conn, $query);
    $number_of_result = mysqli_num_rows($result);

    //determine the total number of pages available
    $number_of_page = ceil($number_of_result / $results_per_page);

    //determine which page number is currently on
    if(!isset($_GET['page'])){
        $page = 1;
    }else{
        $page = $_GET['page'];
    }

    // determine the sql LIMIT starting number for the results on the display page
    $page_first_result = ($page-1) * $results_per_page;



    # create query
    if(strlen($search) > 0){ #searcher
        $query = 'SELECT x.id, x.datelog, x.documentcode, x.action, y.name as office_name, CONCAT(z.lastname, ",", z.firstname) as employee, remarks from employee as z, office as y, transaction as x
        WHERE z.office_id = y.id AND x.employee_id = z.id and x.documentcode =' . $search . ' ORDER BY x.documentcode, x.datelog LIMIT '.$page_first_result . ',' . $results_per_page;
    }else{
        $query = 'SELECT x.id, x.datelog, x.documentcode, x.action, y.name as office_name, CONCAT(z.lastname, ",", z.firstname) as employee, remarks from employee as z, office as y, transaction as x
        WHERE z.office_id = y.id AND x.employee_id = z.id ORDER BY x.documentcode, x.datelog LIMIT '.$page_first_result . ',' . $results_per_page;    
    }
    /* $query = 'SELECT x.datelog, x.documentcode, x.action, y.name as office_name, CONCAT(z.lastname, ",", z.firstname) as employee, remarks from employee as z, office as y, transaction as x
    WHERE z.office_id = y.id AND x.employee_id = z.id LIMIT '.$page_first_result . ',' . $results_per_page; */
    
    # get result
    $result = mysqli_query($conn, $query);
    # fetch data
    $transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    # free result
    mysqli_free_result($result);
    # close connection
    mysqli_close($conn);
    
    ?>
    <div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">1
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
            -->
            <div class="sidebar-wrapper">
                <?php include('includes/sidebar.php'); ?>
                <!-- 1 -->
            </div>
        </div>
        <div class="main-panel">
            <?php include('includes/navbar.php') ?>
            
            <div class="content">
                <div class="container-fluid">
                    <div class="section">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <br/>
                                <div class="col-md-12">
                                    <form action="transaction.php" method="GET">
                                        <input type="text" name="search">
                                        <input type="submit" value="Search" class="btn btn-info bin-fill">
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <a href="/transaction-add.php">
                                        <button type="submit" class="btn btn-info btn-fill pull-right">Add New Transaction</button>
                                    </a>
                                </div>
                                <div class="card-header ">
                                    <h4 class="card-title">Transactions</h4>
                                    <p class="card-category">Table for transactions</p>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>Date Log</th>
                                            <th>Document Code</th>
                                            <th>Action</th>
                                            <th>Office Name</th>
                                            <th>Employee</th>
                                            <th>Remarks</th>
                                            <th>Options</th>
                                            
                                        </thead>
                                        <tbody>
                                            <?php foreach($transactions as $x) : ?>
                                            <tr>
                                                <td><?php echo $x['datelog']; ?></td>
                                                <td><?php echo $x['documentcode']; ?></td>
                                                <td><?php echo $x['action']; ?></td>
                                                <td><?php echo $x['office_name']; ?></td>
                                                <td><?php echo $x['employee']; ?></td>
                                                <td><?php echo $x['remarks']; ?></td>
                                                <td>
                                                    <a href="transaction-edit.php?id=<?php echo $x['id']?>">
                                                    <button type="submit" class="btn btn-warning btn-fill pull-right">Edit</button>
                                                    </a>
                                                    <p>*</p>
                                                    <a href="employee-delete.php?id=<?php echo $x['id'] ?>">
                                                        <button type="submit" class="btn btn-warning btn-fill pull-right" onclick="return confirm('Delete this Row?')">Delete</button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php
                        for($page = 1; $page <= $number_of_page; $page++){
                            echo '<a href="transaction.php?page='. $page . '">' . $page . '</a>';
                        }?>
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
