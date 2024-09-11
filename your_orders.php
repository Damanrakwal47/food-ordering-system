<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if(empty($_SESSION['user_id']))  //if user is not login redirected back to login page
{
    header('location:login.php');
}
else
{
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Your Orders</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css" rel="stylesheet">
        .indent-small {
            margin-left: 5px;
        }
        .form-group.internal {
            margin-bottom: 0;
        }
        .dialog-panel {
            margin: 10px;
        }
        .datepicker-dropdown {
            z-index: 200 !important;
        }
        .panel-body {
            background: #e5e5e5;
            background: -moz-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #e5e5e5), color-stop(100%, #ffffff));
            background: -webkit-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            background: -o-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            background: -ms-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
            background: radial-gradient(ellipse at center, #e5e5e5 0%, #ffffff 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e5e5e5', endColorstr='#ffffff', GradientType=1);
            font: 600 15px "Open Sans", Arial, sans-serif;
        }
        label.control-label {
            font-weight: 600;
            color: #777;
        }
        table {
            width: 750px;
            border-collapse: collapse;
            margin: auto;
        }
        tr:nth-of-type(odd) {
            background: #eee;
        }
        th {
            background: #ff3300;
            color: white;
            font-weight: bold;
        }
        td, th {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 14px;
        }
        @media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
            table {
                width: 100%;
            }
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                border: 1px solid #ccc;
            }
            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }
            td:before {
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                content: attr(data-column);
                color: #000;
                font-weight: bold;
            }
        }
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 28.7041, lng: 77.1025}  // Default to New Delhi
            });

            <?php 
            $query_res = mysqli_query($db, "SELECT * FROM users_orders WHERE u_id='".$_SESSION['user_id']."'");
            while($row = mysqli_fetch_array($query_res)) {
                echo "var marker = new google.maps.Marker({";
                echo "position: {lat: " . $row['latitude'] . ", lng: " . $row['longitude'] . "},";
                echo "map: map,";
                echo "title: '" . $row['title'] . "'";
                echo "});";
            }
            ?>
        }
    </script>
</head>
<body>
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/food-picky-logo1.png" alt=""> </a>
                <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span class="sr-only"></span></a> </li>
                        <?php
                        if(empty($_SESSION["user_id"])) {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link active">login</a></li>';
                            echo '<li class="nav-item"><a href="registration.php" class="nav-link active">signup</a></li>';
                        } else {
                            echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">your orders</a></li>';
                            echo '<li class="nav-item"><a href="logout.php" class="nav-link active">logout</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-wrapper">
        <div class="inner-page-hero bg-image" data-image-src="images/img/res.jpeg">
            <div class="container"></div>
        </div>
        <div class="result-show">
            <div class="container">
                <div class="row"></div>
            </div>
        </div>
        <section class="restaurants-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
                        <div class="widget clearfix">
                            <div class="widget-heading">
                                <h3 class="widget-title text-dark">Popular tags</h3>
                                <div class="clearfix"></div>
                            </div>
                            <div class="widget-body">
                                <ul class="tags">
                                    <li><a href="https://www.grabon.in/food-coupons/" class="tag">Coupons on GrabOn</a></li>
                                    <li><a href="https://www.grabon.in/food-coupons/" class="tag">Discounts on Grabon</a></li>
                                    <li><a href="https://www.grabon.in/food-coupons/" class="tag">Deals on GrabOn</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-7 ">
                        <div class="bg-gray restaurant-entry">
                            <div class="row">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $query_res = mysqli_query($db, "SELECT * FROM users_orders WHERE u_id='".$_SESSION['user_id']."'");
                                        if(!mysqli_num_rows($query_res) > 0) {
                                            echo '<td colspan="6"><center>You have No orders Placed yet. </center></td>';
                                        } else {                
                                            while($row = mysqli_fetch_array($query_res)) {
                                        ?>
                                        <tr>
                                            <td data-column="Item"> <?php echo $row['title']; ?> </td>
                                            <td data-column="Quantity"> <?php echo $row['quantity']; ?> </td>
                                            <td data-column="Price">₹<?php echo $row['price']; ?></td>
                                            <td data-column="Status">
                                                <?php 
                                                $status = $row['status'];
                                                if ($status == "" or $status == "NULL") {
                                                ?>
                                                <button type="button" class="btn btn-info"><span class="fa fa-bars" aria-hidden="true"></span> Dispatch</button>
                                                <?php 
                                                } elseif ($status == "in process") { ?>
                                                <button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin" aria-hidden="true"></span> On The Way!</button>
                                                <?php
                                                } elseif ($status == "closed") {
                                                ?>
                                                <button type="button" class="btn btn-success"><span class="fa fa-check-circle" aria-hidden="true"></span> Delivered</button>
                                                <?php 
                                                } elseif ($status == "rejected") {
                                                ?>
                                                <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i> Cancelled</button>
                                                <?php 
                                                } 
                                                ?>
                                            </td>
                                            <td data-column="Date"> <?php echo $row['date']; ?> </td>
                                            <td data-column="Action"> <a href="delete_orders.php?order_del=<?php echo $row['o_id'];?>" onclick="return confirm('Are you sure you want to cancel your order?');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a> 
                                            </td>
                                        </tr>
                                        <?php }} ?>                 
                                    </tbody>
                                </table>
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer">
            <div class="container">
                <!-- top footer statrs -->
                <div class="row top-footer">
                    <div class="col-xs-12 col-sm-3 footer-logo-block color-gray">
                        <a href="index.php"> <img src="images/food-picky-logo1.png" alt="Footer logo"> </a> <span>Order Delivery &amp; Take-Out </span> </div>
                    <div class="col-xs-12 col-sm-2 about color-gray">
                        <h5>About Us</h5>
                        <ul>
                            <li><a href="about-us.php">About us</a> </li>
                            <li><a href="history.php">History</a> </li>
                            <li><a href="our-team.php">Our Team</a> </li>
                            <li><a href="we-are-hiring.php">We are hiring</a> </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-2 how-it-works-links color-gray">
                        <h5>How it Works</h5>
                        <ul>
                            <li><a href="restaurants.php">Choose restaurant</a> </li>
                            <li><a href="your_orders.php">Choose food</a> </li>
                            <li><a href="checkout.php">Pay via credit card</a> </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-2 pages color-gray">
                        <h5>Pages</h5>
                        <ul>
                            <li><a href="login.php">User Sign Up Page</a> </li>
                            <li><a href="checkout.php">Make order</a> </li>
                            <li><a href="checkout.php">Add to cart</a> </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-3 popular-locations color-gray">
                        <h5>Top Locations</h5>
                        <ul>
                        <li><a href="https://www.google.com/maps?q=Jammu" target="_blank">Jammu</a></li>
                        <li><a href="https://www.google.com/maps?q=Udhampur" target="_blank">Udhampur</a></li>
                        <li><a href="https://www.google.com/maps?q=Reasi" target="_blank">Reasi</a></li>
                        <li><a href="https://www.google.com/maps?q=Dehradun" target="_blank">Dehradun</a></li>
                        <li><a href="https://www.google.com/maps?q=New+Delhi" target="_blank">New Delhi</a></li>
                        <li><a href="https://www.google.com/maps?q=Srinagar" target="_blank">Srinagar</a></li>
                        </ul>
                    </div>
                </div>
                <!-- top footer ends -->
                <!-- bottom footer statrs -->
                <div class="bottom-footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 payment-options color-gray">
                            <h5>Pay Options</h5>
                            <ul>
                                <li>
                                    <a href="#"> <img src="images/paypal.png" alt="Paypal"> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="images/mastercard.png" alt="Mastercard"> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="images/maestro.png" alt="Maestro"> </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-4 address color-gray">
                            <a href="https://www.google.com/maps/place/Karan+Nagar,+Udhampur+182101/@32.9187219,75.1391184,15z/data=!3m1!4b1!4m15!1m8!3m7!1s0x391dd2bf6294ee91:0xe536574cfe583d14!2sUdhampur+182101!3b1!8m2!3d32.9159847!4d75.1416173!16zL20vMDV6aDJj!3m5!1s0x391dd2bd43249c97:0x263aa7d5c7a0aa23!8m2!3d32.9192156!4d75.1384848!16s%2Fg%2F11h08chtt?entry=ttu">Address
                            <p>Food Hub , Jammu(180001) Jammu and Kashmir</p>
                        </div>
                        <div>
                        <h5>Phone: <a href="tel:+917051622832">+91 7051622832</a></h5> </div>
                        </div>
                    </div>
                </div>
                
                <!-- bottom footer ends -->
            </div>
        </footer>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>
</html>
<?php
}
?>
