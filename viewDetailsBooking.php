<?php
  session_start();
  require_once "pdo.php";
  require_once "authCookieSessionValidate.php";

  if(!$isLoggedIn) {
      header("Location: login.php");
  }

  if ($isLoggedIn && isset($_COOKIE["user_id"])) {
      //session_start();
      //$_SESSION["user_id"] = $user[0]["user_id"];
      $_SESSION["user_id"] = $_COOKIE["user_id"];
      //$util->redirect("index.php");
  }

  //$user_id = $_SESSION['user_id'];

  if (isset($_SESSION["user_id"])){
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute(array('user_id' => $_SESSION["user_id"]));
    $user = $statement->fetch();
  }

  if (isset($_GET["booking_id"]) && !empty(trim($_GET["booking_id"]))) {

    // Include config file
    require_once "pdo.php";

    // Prepare a select statement
    $sql = "SELECT * FROM booking WHERE booking_id = :booking_id";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":booking_id", $param_id);

        // Set parameters
        $param_id = trim($_GET["booking_id"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve individual field value
                $court_id = $row["court_id"];
                $booking_date = $row["booking_date"];
                $start_time = $row["start_time"];
                $end_time = $row["end_time"];
                $payment_method = $row["payment_method"];
                $price = $row["price"];


            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);

  }else{
      // URL doesn't contain id parameter. Redirect to error page
      header("location: error.php");
      exit();
  }

 ?>


 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

     <link rel="stylesheet" type="text/css" href="main.css">

      <title>Footsal </title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

   </head>
   <body>

     <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
         <div class="container-fluid">
             <div class=" w-100 mx-auto order-0">
                 <a class="navbar-brand" href="index.php"><img src="images/Footsal.png" max-width="100%" height="36"/></a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".dual-collapse2">
                     <span class="navbar-toggler-icon"></span>
                 </button>
             </div>
             <div class="navbar-collapse collapse order-1 order-md-1 dual-collapse2">
                 <ul class="navbar-nav me-auto">
                     <li class="nav-item active">
                         <a class="nav-link" href="index.php">Home</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="#about_us">About</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="#location">Location</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="booking.php">Booking</a>
                     </li>
                 </ul>
             </div>
             <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
               <form class="navbar-nav ms-auto">

                 <?php if (isset($user)): ?>

                 <div class="dropdown">
                   <button class="btn bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                     <p class="user">Hello, <?=htmlspecialchars($user["fname"])?></p>
                   </button>
                   <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                     <!-- <li><a class="dropdown-item" href="#">Profile</a></li> -->
                     <li><a class="dropdown-item" href="viewBookingList.php">Booking List</a></li>
                     <li><hr class="dropdown-divider"></li>
                     <li><a class="dropdown-item" href="logout.php"  onclick="return confirm('Are you sure to logout?');">Logout</a></li>
                   </ul>
                 </div>

               <?php else: ?>
                 <a href="login.php"><button class="btn btn-primary mx-2 px-4 my-xs-3" type="button">Login</button></a>
                 <a href="signup.php"><button class="btn btn-sm btn-outline-secondary px-4 py-1" type="button">Register</button></a>
               <?php endif; ?>
               </form>
             </div>
         </div>
     </nav>


     <?php if (isset($_SESSION['user_id'])): ?>

     <section class="intro">
               <div class="mask d-flex align-items-center" style="background-color: #eee;">
                 <div class="container  mt-5">
                   <div class="row justify-content-center">
                     <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                       <div class="card" style="border-radius: 50px;">
                         <div class="card-body p-5 text-center">
                           <div class="my-md-2">
                             <h2 class="fw-bold mb-3"><u>Court Booking Details</u></h2>
                             <div class="row"> <!--Select Court -->
                               <div class="col-xl-7 d-flex justify-content-start mt-3">
                                 <p class="fw-bold">Court Number:</p>
                               </div>
                             </div>
                             <div class="row">
                               <div class="col-xl-4">
                                 <?php echo $court_id; ?>
                               </div>
                             </div> <!--Select Court -->

                             <div class="row"> <!--Select Date -->
                               <div class="col-xl-7 d-flex justify-content-start">
                                 <p class="fw-bold">Booking Date:</p>
                               </div>
                             </div>
                             <div class="row">
                               <div class="col-xl-7">
                                    <?php echo $booking_date  ; ?>
                               </div>
                             </div> <!--Select Date -->

                             <div class="row mt-3"> <!--Start Time -->
                               <div class="col-xl-12 d-flex justify-content-start">
                                 <p class="fw-bold">Start Time:</p>
                               </div>
                             </div>
                             <div class="row">
                               <div class="col-xl-6">
                                 <div class="cs-form">
                                 <?php echo $start_time; ?>
                                 </div>
                             </div>

                           </div>

                           <div class="row mt-3"> <!--Start Time -->
                             <div class="col-xl-12 d-flex justify-content-start">
                               <p class="fw-bold">End Time:</p>
                             </div>
                           </div>
                           <div class="row">
                             <div class="col-xl-6">
                               <div class="cs-form">
                               <?php echo $end_time; ?>
                               </div>
                           </div>
                         </div>

                           <div class="row mt-3"> <!--Select Payment method -->
                             <div class="col-xl-12 d-flex justify-content-start">
                               <p class="fw-bold">Payment Method:</p>
                             </div>
                           </div>
                           <div class="row">
                             <div class="col-xl-5">
                               <div class="cs-form">
                               <?php echo $payment_method; ?>
                               </div>
                           </div>
                         </div>

                           <div class="row mt-3"> <!--display price method -->
                             <div class="col-xl-12 d-flex justify-content-start">
                               <p class="fw-bold">Total Price:</p>
                             </div>
                           </div>
                           <div class="row">
                             <div class="row">
                               <div class="col-6">
                               RM <?php echo $price; ?>
                               </div>
                           </div>
                         </div>

                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </section>

   <?php else: ?>

     <?php
          header("Location: login.php");
          return;
      ?>

   <?php endif; ?>

   </body>
 </html>
