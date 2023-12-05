<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <script
        src="./chart.js"> // now offline
    </script>
	<title>Light Bootstrap Dashboard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->
        <?php include('includes/sidebar.php') ?>

    	
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
								<p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret hidden-lg hidden-md"></b>
									<p class="hidden-lg hidden-md">
										5 Notifications
										<b class="caret"></b>
									</p>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li>
                        <li>
                           <a href="">
                                <i class="fa fa-search"></i>
								<p class="hidden-lg hidden-md">Search</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="">
                               <p>Account</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <p>
										Dropdown
										<b class="caret"></b>
									</p>

                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                              </ul>
                        </li>
                        <li>
                            <a href="#">
                                <p>Log out</p>
                            </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">

                            <div class="header">
                                <h4 class="title">Top 5 Expensive Products</h4>
                                <p class="category">Most expensive products available</p>
                            </div>
                            <div class="content">

                            <canvas id="chartShippers"></canvas>
                            
                            <?php
                                include('config/config.php');
                                include('config/db.php');

                                $query01 = "select ProductName, UnitPrice from products order by UnitPrice desc limit 5;";

                                $result01 = mysqli_query($conn, $query01);

                                if(mysqli_num_rows($result01) > 0) {
                                    $product_price = array();
                                    $product_name = array();
                                    while($row = mysqli_fetch_array($result01)){
                                        $product_price[] = $row['UnitPrice'];
                                        $product_name[] = $row['ProductName'];
                                    }
                                    mysqli_free_result($result01);
                                    mysqli_close($conn);
                                }else{
                                    echo "No records matching your query were found.";
                                }

                            ?>
                            <script>
                                const product_price = <?php echo json_encode($product_price); ?>;
                                const product_name = <?php echo json_encode($product_name); ?>;
                                const data1 = {
                                    labels: product_name,
                                    datasets: [{
                                        // label: 'My First Dataset',
                                        data: product_price,
                                        backgroundColor: [
                                            'rgb(255,99,132)',
                                            'rgb(54,162,235)',
                                            'rgb(255,165,0)',
                                            'rgb(25,165,100)',
                                            'rgb(105,15,50)',
                                        ],
                                        hoverOffset: 4
                                    }]
                                };

                                const config = {
                                    type: 'bar',
                                    data: data1,
                                    options: {
                                        indexAxis: 'y',
                                        plugins: {
                                            legend: {
                                                position: false
                                            }
                                        }
                                    }
                                };

                                const chartShippers = new Chart(
                                    document.getElementById('chartShippers'),
                                    config
                                );
                            </script>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">

                            <div class="header">
                                <h4 class="title">Employees' Assisted Order Total</h4>
                                <p class="category">Total orders assigned to each employee</p>
                            </div>
                            <div class="content">

                            <canvas id="chartEmployees"></canvas>
                            
                            <?php
                                include('config/config.php');
                                include('config/db.php');

                                $query01 = "select concat(e.LastName, ' ', e.FirstName) as Employee, count(o.EmployeeID) as 'total_assist' 
                                from employees as e inner join orders as o on e.EmployeeID = o.EmployeeID group by Employee;";

                                $result01 = mysqli_query($conn, $query01);

                                if(mysqli_num_rows($result01) > 0) {
                                    $total_assist = array();
                                    $employee = array();
                                    while($row = mysqli_fetch_array($result01)){
                                        $total_assist[] = $row['total_assist'];
                                        $employee[] = $row['Employee'];
                                    }
                                    mysqli_free_result($result01);
                                    mysqli_close($conn);
                                }else{
                                    echo "No records matching your query were found.";
                                }

                            ?>
                            <script>
                                const total_assist = <?php echo json_encode($total_assist); ?>;
                                const employee = <?php echo json_encode($employee); ?>;
                                const data2 = {
                                    labels: employee,
                                    datasets: [{
                                        // label: 'My First Dataset',
                                        data: total_assist,
                                        backgroundColor: [
                                            'rgb(255,99,132)',
                                            'rgb(54,162,235)',
                                            'rgb(255,165,0)',
                                            'rgb(25,165,100)',
                                            'rgb(105,15,50)',
                                        ],
                                        hoverOffset: 4
                                    }]
                                };

                                const config2 = {
                                    type: 'bar',
                                    data: data2,
                                    options: {
                                        indexAxis: 'y',
                                        plugins: {
                                            legend: {
                                                position: false
                                            }
                                        }
                                    }
                                };

                                const chartEmployees = new Chart(
                                    document.getElementById('chartEmployees'),
                                    config2
                                );
                            </script>
                            </div>
                        </div>
                    </div>


                    

                </div> <!-- row end -->



                <div class="col-md-4">
                    <div class="card">

                        <div class="header">
                            <h4 class="title">Customers Orders</h4>
                            <p class="category">orders that are more than 15</p>
                        </div>
                        <div class="content">

                        <canvas id="chartCustomers"></canvas>
                        
                        <?php
                            include('config/config.php');
                            include('config/db.php');

                            $query01 = "select c.CompanyName, count(o.CustomerID) as 'total_orders' from customers as c 
                            inner join orders as o on c.CustomerID = o.CustomerID group by c.CompanyName;";

                            $result01 = mysqli_query($conn, $query01);

                            if(mysqli_num_rows($result01) > 0) {
                                $total_orders = array();
                                $customers = array();
                                while($row = mysqli_fetch_array($result01)){
                                    if($row['total_orders'] > 15){
                                        $total_orders[] = $row['total_orders'];
                                        $customers[] = $row['CompanyName'];
                                    }
                                    
                                }
                                mysqli_free_result($result01);
                                mysqli_close($conn);
                            }else{
                                echo "No records matching your query were found.";
                            }

                        ?>
                        <script>
                            const total_orders = <?php echo json_encode($total_orders); ?>;
                            const customers = <?php echo json_encode($customers); ?>;
                            const data3 = {
                                labels: customers,
                                datasets: [{
                                    // label: 'My First Dataset',
                                    data: total_orders,
                                    backgroundColor: [
                                        'rgb(255,99,132)',
                                        'rgb(54,162,235)',
                                        'rgb(255,165,0)',
                                        'rgb(25,165,100)',
                                        'rgb(105,15,50)',
                                    ],
                                    hoverOffset: 4
                                }]
                            };

                            const config3 = {
                                type: 'doughnut',
                                data: data3,
                                options: {
                                    indexAxis: 'y',
                                    plugins: {
                                        legend: {
                                            position: false
                                        }
                                    }
                                }
                            };

                            const chartCustomers = new Chart(
                                document.getElementById('chartCustomers'),
                                config3
                            );
                        </script>
                        </div>
                    </div>
                </div>
                
                    
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Top 5 popular Products</h4>
                                <p class="category">Most ordered products</p>
                            </div>
                            <div class="content">
                                <canvas id="myChartTopFive"></canvas>


                                <?php
                                require('config/config.php');
                                require('config/db.php');
                                $query04 = "select p.ProductName, count(o.ProductID) as total_order from products as p 
                                inner join order_details as o on o.ProductID = p.ProductID group by p.ProductName order by total_order desc limit 5;";

                                $result04 = mysqli_query($conn, $query04);

                                if(mysqli_num_rows($result04) > 0){
                                    $total_order = array();
                                    $ProductName = array();
                                    while ($row = mysqli_fetch_array($result04)){
                                        $total_order[] = $row['total_order'];
                                        $ProductName[] = $row['ProductName'];
                                    }

                                    mysqli_free_result($result04);
                                    mysqli_close($conn);
                                }else{
                                    echo "No records matching your query were found.";
                                }
                                
                                ?>

                                <script>
                                
                                const ProductName = <?php echo json_encode($ProductName); ?>;
                                const total_order = <?php echo json_encode($total_order); ?>;
                                const data4 = {
                                    labels: ProductName,
                                    datasets: [{
                                        data: total_order,
                                        backgroundColor: [
                                            'rgb(54, 162, 235)',
                                            'rgb(255, 206, 86)',
                                            'rgb(75, 192, 192)',
                                            'rgb(153, 102, 255)',
                                            'rgb(255, 159, 64)'
                                        ],
                                        hoverOffset: 4,
                                        borderWidth: 1
                                    }]
                                };
                                // <!-- config block -->
                                const config4 = {
                                    type: 'pie',
                                    data: data4,
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                };
                                // <!-- render block -->
                                const myChartTopFive = new Chart(
                                    document.getElementById('myChartTopFive'),
                                    config4
                                );

                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                    
                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
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
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                </p>
            </div>
        </footer>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

<!-- 	<script type="text/javascript">
    	$(document).ready(function(){

        	demo.initChartist();

        	$.notify({
            	icon: 'pe-7s-gift',
            	message: "Welcome to <b>Light Bootstrap Dashboard</b> - a beautiful freebie for every web developer."

            },{
                type: 'info',
                timer: 4000
            });

    	});
	</script> -->

</html>
