<?php
require_once('config.php');
// MySQL database name
include 'app.php';

function build_calendar($month, $year) {
    global $conn;
   //$conn = new mysqli('localhost', 'root', '', 'book', 3307);
    // Your existing code for database connection and insert query

    // Retrieve booked dates from the database
   /* $stmt = $conn->prepare("SELECT date FROM bookings WHERE MONTH(date) = ? AND YEAR(date) = ?");
    $stmt->bind_param('ss', $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = array();
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row['date'];
    }
    $stmt->close(); */




    // Close statement



    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    
    $numberDays = date('t', $firstDayOfMonth);
    
    $dateComponents = getdate($firstDayOfMonth);
    
    $monthName = $dateComponents['month'];
    
    $dayOfWeek = $dateComponents['wday'];
    
    $dateToday = date('Y-m-d');
    
    // adding new here
    $prev_month = date('m', mktime(0, 0, 0, $month - 1, 1, $year));
    $prev_year = date('Y', mktime(0, 0, 0, $month - 1, 1, $year));
    $next_month = date('m', mktime(0, 0, 0, $month + 1, 1, $year));
    $next_year = date('Y', mktime(0, 0, 0, $month + 1, 1, $year));
    
    $calendar = "<center><h2>$monthName $year </h2>";
    $calendar .= "<a class='btn btn-primary btn-xs' href='?month=" . $prev_month . "&year=" . $prev_year . "'>Prev Month</a>";
    $calendar .= "<a class='btn btn-primary btn-xs' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a>";
    $calendar .= "<a class='btn btn-primary btn-xs' href='?month=" . $next_month . "&year=" . $next_year . "'>Next Month</a></center>";
    
    $calendar .= "<br><table class='table table-bordered'>";
    $calendar .= "<tr>";
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }
    $calendar .= "</tr>";
    
    // Calculate empty cells before the first day of the month
    $calendar .= "<tr>";
    $currentDay = 1;
    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td class='empty'></td>";
        }
    }
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>"; // Start a new row
        }
        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $dayOfWeek = date("w", strtotime($date)); // Correct way to get the day of the week
        $today = $date == date('Y-m-d') ? 'today' : '';
        if ($date < date('Y-m-d')) { // Check if the date has surpassed the current date
            $calendar .= "<td><h4>$currentDay</h4><button class='btn btn-success btn-xs rounded-pill' style='background-color: red;'>N/A</button>";
        } elseif ($dayOfWeek == 0 || $dayOfWeek == 6) { // Checking for Sunday (0) and Saturday (6)
            $calendar .= "<td><h4>$currentDay</h4><button class='btn btn-success btn-xs rounded-pill' style='background-color: red;'>Holiday</button>";
        } else {
            $calendar .= "<td class='$today'><h4>$currentDayRel</h4><a href='book.php?date=$date' class='btn btn-success btn-xs rounded-pill' style='background-color: black;'>Book</a></td>";
        }
        $currentDay++;
        $dayOfWeek++;
    }
    
    
    
    if ($dayOfWeek < 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($i = 0; $i < $remainingDays; $i++) {
            $calendar .= "<td class='empty'></td>";
        }
    }
    $calendar .= "</tr></table>";
    return $calendar;
    
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>IST - CISL </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="ist cisl" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="ist.edu.pk" />

  	<!-- 
	//////////////////////////////////////////////////////

	FREE HTML5 TEMPLATE 
	DESIGNED & DEVELOPED by FREEHTML5.CO
	
	Website: 		http://freehtml5.co/
	Email: 			info@freehtml5.co
	Twitter: 		http://twitter.com/fh5co
	Facebook: 	https://www.facebook.com/fh5co

	//////////////////////////////////////////////////////
	 -->

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

  	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
  	<link rel="shortcut icon" href="favicon.ico">

  	<!-- Google Webfont -->
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
	<!-- Themify Icons -->
	<link rel="stylesheet" href="css/themify-icons.css">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">
	<!-- Superfish -->
	<link rel="stylesheet" href="css/superfish.css">
	<!-- Easy Responsive Tabs -->
	<link rel="stylesheet" href="css/easy-responsive-tabs.css">
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Theme Style -->
	<link rel="stylesheet" href="css/style.css">

	<link rel="stylesheet" href="css/textonly.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>

	<![endif]-->
    <style>
 header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Logo styles */
        .logo {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Navigation styles */
        nav ul {
            list-style-type: none;
            display: flex;
            flex-wrap: wrap; /* Allow items to wrap to the next line */
        }

        nav li {
            margin-right: 20px;
        }

        nav li:last-child {
            margin-right: 0;
        }

        nav a {
            color: #fff;
            text-decoration: none;
        }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            /* Adjustments for smaller screens */
            header {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
            }

            nav {
                margin-top: 10px;
            }

            nav ul {
                flex-direction: column;
            }

            nav li {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
</style>

	</head>
	<body>

		<!-- START #fh5co-header -->
		<header id="fh5co-header-section" role="header" class="" >

			<!-- Add this button inside your header or footer -->
			

			<div class="container">

				

				<!-- <div id="fh5co-menu-logo"> -->
					<!-- START #fh5co-logo -->
					<h1 id="fh5co-logo" class="pull-left"><a href="index.html"><img src="images/logo.png" class="imgist" alt="IST CISL"></a></h1>
					
					<!-- START #fh5co-menu-wrap -->
					<nav id="fh5co-menu-wrap" role="navigation">
						
						
						<ul class="sf-menu" id="fh5co-primary-menu">
							
								<a href="index.html">Home</a>
							
							<li>
								<a href="members.html">Core Members</a>
							</li>
							<li><a href="projects.html">Projects</a></li>
							<li><a href="publications.html">List of Publication</a></li>
							<li><a href="newsandadv.html">News & Advisories</a></li>
							
							<li><a href="contact.html">Contact Us</a></li>
							
							<li><img src="images/textmode3.png" id="icontextonly"></li>
							<li><img src="images/moon.png" id="icon"></li>
							
						</ul>
						
						
					</nav>
				<!-- </div> -->

			</div>
		</header>
        <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                $dateComponents = getdate();
                if(isset($_GET['month']) && isset($_GET['year'])){
                    $month = $_GET['month'];
                    $year = $_GET['year'];
                } else{
                    $month = $dateComponents['mon'];
                    $year = $dateComponents['year'];
                }
                echo build_calendar($month, $year)

                ?>



            </div>
        </div>
    </div>


</body>
</html>
   