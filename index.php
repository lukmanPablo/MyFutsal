<?php
 session_start();

 require_once "authCookieSessionValidate.php";
 require_once "pdo.php";


 if(!$isLoggedIn) {
     header("Location: login.php");
 }

 if ($isLoggedIn && isset($_COOKIE["user_id"])) {
     //session_start();
     //$_SESSION["user_id"] = $user[0]["user_id"];
     $_SESSION["user_id"] = $_COOKIE["user_id"];
     //$util->redirect("index.php");
 }

 if (isset($_SESSION["user_id"])){
   $query = "SELECT * FROM users WHERE user_id = :user_id";
   $statement = $pdo->prepare($query);
   $statement->execute(array('user_id' => $_SESSION["user_id"]));
   $user = $statement->fetch();
 }

 ?>


 <html>
   <head lang="en">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="main.css">

     <title>Footsal Home</title>
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
                         <a class="nav-link" href="#home">Home</a>
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

     <script type="text/javascript" src="jquery.min.js">
     </script>
     <script type="text/javascript">
     $(document).ready(function(){
     alert("Welcome To Footsal Booking System!");
     //window.console && console.log('Hello jQuery..');
     });
     </script>

     <div class="header-container" id="home">
       <h1 class="header-title img-fluid"><span style="color:#BEF446;">FOOTSAL</span> IS WHERE</br> YOUR DREAM STARTS.</h1>
       <img src="images/header.jpg" class="img-fluid"/>
     </div>


       <div class="container features">
         <div class="text-center">
           <img src="images/why.png" class="rounded img-fluid mb-5 mt-5" style="max-width:30%;"/>
         </div>

         <div class="row d-flex align-items-center justify-content-center">

             <div class=" col-lg-4 col-md-4 col-sm-12">
               <div class="shadow p-3 mb-5 bg-body rounded box">
                 <div class="text-center">
                 <img src="images/thunder.png" class="rounded img-fluid" style="max-width:20%;"/>
                   <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4" style="font-size:2em;">Fast Booking</p>
                   <p class="text-center p mx-1 mx-md-4 mt-4">Our booking system has been designed to handle fast booking for your ease.</p>
                 </div>
               </div>
           </div>

            <div class=" col-lg-4 col-md-4 col-sm-12">
             <div class="shadow p-3 mb-5 bg-body rounded box">
               <div class="text-center">
               <img src="images/easy.png" class="rounded img-fluid" style="max-width:20%;"/>
                 <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4" style="font-size:2em;">Easy Booking</p>
                 <p class="text-center p mx-1 mx-md-4 mt-4">Your court booking has been made easy with few clicks away and you're set to go.</p>
               </div>
             </div>
           </div>

           <div

           class="col-lg-4 col-md-4 col-sm-12 ">
             <div class=" shadow p-3 mb-5 bg-body rounded box ">
               <div class="text-center">
               <img src="images/low-price.png" class="rounded img-fluid" style="max-width:20%;"/>
                 <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4" style="font-size:2em;">Low Prices Booking</p>
                 <p class="text-center p mx-1 mx-md-4 mt-4"  id="about_us">We offer the best prices for our high quality futsal courts to you.</p>
               </div>
             </div>
          </div>
         </div>
       </div>

       <div class="container-fluid" style="background:black">
         <div class="container class pb-3">

           <div class="row" >
             <p class="h1 fw-bold mt-3 pt-2" style="color:#BEF446;">About Us</p>
           </div>
           <div class="row">
             <div class="col-lg-7 col-md-4 col-sm-12">
               <p class="text-white text-justify">Footsal has been created since 2019 by 4 founders who dreamed of making
               futsal into a world class sport. Since then, they have been focusing in letting futsal's
               lovers playing this game with high quality court so that they can maximize their playing experience. Ever
               since 2020, a total of 6 courts has been make sure to always be in high quality condition so that our customers
               will feel satisfied with what they're paying.</p>

               <p class="text-white text-justify">Futsal is played between two teams of five players each, one of whom is the goalkeeper.
                 Unlimited substitutions are permitted. Unlike some other forms of indoor soccer, it is played on a hard court surface marked by
                 lines; walls or boards are not used. It is played with a smaller, harder, lower-bounce ball than football.
                 The surface, ball and rules favour ball control and passing in small spaces.
                 The game emphasizes control, improvisation, creativity and technique.</p>
             </div>
             <div class="col-lg-5 col-md-4 col-sm-12">
               <img src="images/about_us.jpg" class=" rounded img-fluid" />
             </div>
           </div>
           <div class="row mt-3 mb-5">
             <p class="h1 fw-bold mt-3 pt-2" style="color:#BEF446;">The Founders</p>
           </div>
           <div class="row">
             <div class=" col-lg-3 col-md-3 col-sm-12 px-lg-5">
               <div class="text-center">
                 <img src="images/daniel.png" class="rounded img-fluid" />
                 <p class="text-center mt-3" style="color:#BEF446; font-size:20px;">Muhammad Daniel</p>
               </div>
             </div>
             <div class=" col-lg-3 col-md-3 col-sm-12 px-md-5">
               <div class="text-center">
                 <img src="images/luk.png" class="rounded img-fluid" />
                 <p class="text-center mt-3" style="color:#BEF446; font-size:20px;">Lukman Hakim</p>
               </div>
             </div>
             <div class=" col-lg-3 col-md-3 col-sm-12 px-md-5">
               <div class="text-center">
                 <img src="images/jon.png" class="rounded img-fluid" />
                 <p class="text-center mt-3" id="location" style="color:#BEF446; font-size:20px;">Afiq Ikmal</p>
               </div>
             </div>
             <div class=" col-lg-3 col-md-3 col-sm-12 px-md-5">
               <div class="text-center">
                 <img src="images/al.png" class="rounded img-fluid" />
                 <p class="text-center mt-3" id="location" style="color:#BEF446; font-size:20px;">Mohammed AlQasabi</p>
               </div>
             </div>
           </div>
         </div>
       </div>

       <div class="container-fluid" style="background:#fff">
         <!-- <div class="container class mb-5">
            <p class="h1 fw-bold mt-5 pt-2 text-center mb-5">Our Location</p>

            <div class="row">
              <div class="col-lg-6 col-md-4 col-sm-12 px-md-5">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1237.004469700359!2d101.70906473576376!3d2.995449563432513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdcb947e3d8321%3A0xa78c118a75c0e809!2sGelanggang%20Serbaguna!5e0!3m2!1sen!2smy!4v1673549647596!5m2!1sen!2smy"
                width="600" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
              <div class="col-lg-6 col-md-4 col-sm-12 px-md-5">

              </div>
            </div>
         </div> -->

         <div class="container">
 <div class="row">
   <div class="col-sm">
     <div class="container-fluid" style="background:#fff">
       <div class="container class mb-5">
          <p class="h1 fw-bold mt-5 pt-2 text-center mb-5">Our Location</p>
          <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-12 px-md-5">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1237.004469700359!2d101.70906473576376!3d2.995449563432513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdcb947e3d8321%3A0xa78c118a75c0e809!2sGelanggang%20Serbaguna!5e0!3m2!1sen!2smy!4v1673549647596!5m2!1sen!2smy"
              width="600" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-12 px-md-5">
            </div>
          </div>
       </div>
     </div>
   </div>
   <!-- grid3 -->
   <div class="col-sm">
   </div>
   <div class="col-sm">
     <div class="container-fluid" style="background:#fff">
       <div class="container class mb-5">
       <p class="h1 fw-bold mt-5 pt-1 text-center mb-3">Operating hours</p>
       <table class="table table-hover">
         <tr>
           <th>Monday</th>
           <td >08:00 AM</td>
           <td>-</td>
           <td >11:00 PM</td>
         </tr>
         <tr>
           <th>Tuesday</th>
           <td >08:00 AM</td>
           <td>-</td>
           <td >11:00 PM</td>
         </tr>
         <tr>
           <th>wednesday </th>
           <td >08:00 AM</td>
           <td>-</td>
           <td >11:00 PM</td>
         </tr>
         <tr>
           <th>Thursday</th>
           <td >08:00 AM</td>
           <td>-</td>
           <td >11:00 PM</td>
         </tr>
         <tr>
           <th>Friday</th>
           <td >08:00 AM</td>
           <td>-</td>
           <td >11:00 PM</td>
         </tr>
         <tr>
           <th>Saturday</th>
           <td >08:00 AM</td>
           <td>-</td>
           <td >11:00 PM</td>
         </tr>
         <tr>
           <th>Sunday</th>
           <td >Closed</td>
           <td ></td>
           <td ></td>
         </tr>
       </table>
<p><i>Staff are unavailable during weekend due to weekly holidays</i></p>
   </div>
 </div>
</div>
 </div>
   </div>


       </div>

       <script src="/path/to/flash.min.js">

         window.FlashMessage.success($_SESSION["user_id"]);

       </script>

     <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-
      9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

   </body>
 </html>
