<?php
global $conn;
$bookings = array();
$conn = new mysqli('localhost', 'root', '', 'book', 3306);
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
if(isset($_GET['date']) && validateDate($_GET['date'], 'Y-m-d')){
    $date = $_GET['date'];
    $stmt = $conn->prepare("SELECT timeslot FROM bookings WHERE date = ?");
    $stmt->bind_param('s', $date);
    
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows>0){
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row['timeslot'];
        }
    }
}else {
    // Invalid date provided in the URL
    echo "Invalid input";
    exit; // Stop further execution
}


// Check if the selected date has passed the current date
$current_date = date('Y-m-d');
$date_has_passed = ($date < $current_date);

$date = isset($_GET['date']) ? $_GET['date'] : '';
// Include the config.php file to get database connection parameters
include 'config.php';

// Process form data
if(isset($_POST['submit_booking'])){ // Changed the name of the submit button to match the form
    $name = $_POST['name'];
    $date = date('Y-m-d'); // Assuming date is submitted from the form, and converting it to the format MySQL expects
    $timeslot = $_POST['timeslot']; // Retrieve the timeslot value from the form

    // Create connection using parameters from config.php
    $conn = new mysqli($servername, $username, $password, $dbname, 3306);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO bookings (name, date, timeslot) VALUES (?, ?, ?)");

    $stmt->bind_param('sss', $name, $date, $timeslot);
    $stmt->execute();

    // Check for errors
    if ($stmt->errno) {
        $msg = "Failed to insert data: " . $stmt->error;
    } else {
        $msg = "Data inserted successfully!";
    }
    $bookings []=$timeslot;

    // Close statement
    $stmt->close();

    // Close connection
    $conn->close();
}

$duration = 30;
$cleanup = 10;
$start = "08:30";
$end = "16:00";

function timeslot($start, $end, $duration, $cleanup) {
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M"); // Construct DateInterval correctly
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M"); // Construct DateInterval correctly
    $slots = array();

    for ($intStart = clone $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }
        $slots[] = $intStart->format("H:iA") . "-" . $endPeriod->format("H:iA");

    }

    return $slots;

    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content here -->
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>IST - CISL </title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="ist cisl" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	<meta name="author" content="ist.edu.pk" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="js/modernizr-2.6.2.min.js"></script>
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
	<link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="css/textonly.css">
    

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>

	<![endif]-->
    <style>
           /* Center the modal content vertically and horizontally */
        .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        /* Style the form inside the modal */
        .modal-content form {
            width: 400px;
            height: 150px; /* Adjust the width as needed */
        }
        .modal-content button {
            text-align: left; /* Adjust the width as needed */
        }

        /* Center the input fields */
        .modal-content form .form-group {
            
            width: 350px;
            margin-left: 20px;
        }

        /* Style the button */
        .form-group.pull-right button {
            text-align: center; /* Center the text */
            height: 40px; /* Adjust the height as needed */
            background-color: black; /* Change the background color */
            color: white; /* Change the text color */
            border: none; /* Remove the border */
            border-radius: 5px;
            margin-left: 100px; /* Add border radius */
        }

        /* Style the button on hover */
        .form-group.pull-right button:hover {
            background-color: #9da8b4; /* Change the background color on hover */
        }
    /* Style for the buttons */
        .book {
            margin-bottom: 20px; /* Increase margin to create more space between buttons */
            padding: 15px 3px;
            background-color: #244069; /* Add padding to increase button height */
            height: auto; /* Set height to auto to allow the button to adjust based on content */
            line-height: 1; /* Reset line-height to ensure vertical alignment */
            color: #fff; /* Text color */
            border: none; /* Remove default button border */
            border-radius: 5px; /* Add border radius for rounded corners */
        }

        /* Hover style for the buttons */
        .book:hover {
            background-color: #9da8b4; /* Darker background color on hover */
        }

</style>



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
                        <li class="active">
                            <a href="index.html">Home</a>
                        </li>
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
<!-- Header content here -->

        <div class="container">
            <h1 class="text-center">BOOK FOR DATE: <?php echo date('m/d/Y', strtotime($date)); ?> </h1>
            <hr>
            <div class="row">
               <div class="col-md-6 col-md-offset-3">
                 <?php echo isset($msg) ? "<div class='alert alert-success'>$msg</div>" : ''; ?>
               </div>

                <?php 
                $timeslot = timeslot($start, $end, $duration, $cleanup);
                foreach($timeslot as $ts){
                ?>
                <div class="col-md-2">
                    <div class="form-group">
                    <?php if(in_array($ts, $bookings) || $date_has_passed){ ?>
                            <button class="btn btn-danger" disabled><?php echo $ts; ?></button>
                        <?php }else{ ?>
                            <button class="btn btn-success book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
                        <?php } ?>
                        <!-- Update class to 'book' instead of 'timeslot' -->
                        
                    </div>
                </div>
                <?php }?>
            </div>
        </div> <!-- Move this closing </div> tag inside the foreach loop -->

        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Booking: <span id = "slot"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="timeslot">Timeslot</label>
                                    <!-- Add id to timeslot input field -->
                                    <input required type="text" readonly name="timeslot" id ="timeslot" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <!-- Update 'readonly' attribute to remove it -->
                                    <input required type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary"type="submit"name="submit_booking">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--<div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div> -->
                </div>
            </div>
        </div>
       <!-- Include jQuery -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <!--<script src="js/bootstrap.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-pzDqJlct6fI7KIi+jr3ZD4cnjhk5iS2CY4nv/iJrV+oowCt2wX4rCgqpxvXa1r0M" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->
        


        <script>
            $(".book").click(function() {
                var timeslot = $(this).attr('data-timeslot');
                $("#slot").html(timeslot);
                $("#timeslot").val(timeslot);
                $("#myModal").modal("show");
            });
        </script>  


    
    </body>
</html>