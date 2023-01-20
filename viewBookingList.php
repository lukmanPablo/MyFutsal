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


    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
      </symbol>
      <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
      </symbol>
      <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
      </symbol>
      <symbol id="bi-eye" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
      </symbol>
      <symbol id="bi-pen" fill="currentColor" viewBox="0 0 16 16">
        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
      </symbol>
      <symbol id="bi-trash-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
      </symbol>
    </svg>

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

    <?php
    //Flash message after success signup
    if(isset($_SESSION["success"])){

         ?>
         <div class="alert alert-success d-flex align-items-center" role="alert">
           <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
           <div>
             <strong><?php echo " ".$_SESSION["success"];
                            unset($_SESSION["success"]);?></strong>
           </div>
         </div>
         <?php


         //unset($_SESSION["button"]);
       }
     ?>




    <?php if (isset($_SESSION['user_id'])): ?>

    <p></p>

    <div class="container">
      <div class="text-center">
        <h2>List Booking</h2>
      </div>

      <?php
      echo "<p></p>";
      echo "<p></p>";

        echo('<table class="table table-hover">'."\n");

        echo "<thead>";
          echo "<tr>";
          echo "<th>#</th>";
            echo "<th>Booking ID</th>";
            echo "<th>Court Number</th>";
            echo "<th>Booking Date</th>";
            echo "<th>Start Time</th>";
            echo "<th>End Time</th>";
            echo "<th>Payment Method</th>";
            echo "<th>Price (RM)</th>";
            echo "<th>Action</th>";
          echo "</tr>";
        echo "</thead>";

        // Kena guna join statement tu fetch court number from table COURT
        $stmt = $pdo->query("SELECT booking_id, user_id, court_id, booking_date, start_time, end_time, payment_method, price FROM booking WHERE user_id = $user_id");
        // $query = "SELECT  FROM users WHERE email = :email AND password_hash = :password_hash";
        // $statement = $pdo->prepare($query);
        // $statement->execute(array('email' => $_POST["email"],
        //                           'password_hash' => $password_hash));

        $counter = 1;
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
          echo "<tr><td>";
          echo(htmlentities($counter));
          echo("</td><td>");
          echo(htmlentities($row['booking_id']));
          echo("</td><td>");
          echo(htmlentities($row['court_id']));
          echo("</td><td>");
          echo(htmlentities($row['booking_date']));
          echo("</td><td>");
          echo(htmlentities($row['start_time']));
          echo("</td><td>");
          echo(htmlentities($row['end_time']));
          echo("</td><td>");
          echo(htmlentities($row['payment_method']));
          echo("</td><td>");
          echo(htmlentities($row['price']));
          echo("</td><td>");
          echo('<a href="viewDetailsBooking.php?booking_id='.$row['booking_id'].'"><svg class="bi bi-eye" width="18" height="18" role="img" aria-label="Success:"><use xlink:href="#bi-eye"/></svg></a> / ');
          echo('<a href="update.php?booking_id='.$row['booking_id'].'"><svg class="bi bi-pen" width="15" height="15" role="img" aria-label="Success:"><use xlink:href="#bi-pen"/></svg></a> / ');
          echo('<a href="delete.php?booking_id='. $row['booking_id'].'" onclick="return deleteFunction()"><svg class="bi bi-trash-fill" width="15" height="15" role="img" aria-label="Success:"><use xlink:href="#bi-trash-fill"/></svg></a>');
          echo("\n</form>\n");
          echo("</td></tr>\n");
          $counter++;
        }
      ?>
      </table>

      <p></p>
      <a href="booking.php">Add New Booking</a>
      <p></p>
      <a href="index.php">Back</a>


    </div>

    <?php endif; ?>

    <script src='script.js'></script>

    <script>
      function deleteFunction(){
        return confirm("Are you sure to delete your booking?");
      }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-
    9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

  </body>
</html>
