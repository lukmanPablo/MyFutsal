 <?php
    session_start();
    require_once "pdo.php";
    require_once "authCookieSessionValidate.php";


    if(!$isLoggedIn) {
        header("Location: login-admin.php");
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

<html>
<head>
  <!-- <link rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
  integrity="sha384-
  TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
  crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="main.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="main.css">

   <title>Footsal</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    <symbol id="bi-search" fill="currentColor" viewBox="0 0 16 16">
      <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
    </symbol>
    <symbol id="bi-trash-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
    </symbol>
  </svg>

</head>

<body>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <div class="container-fluid">
          <div class=" w-100 mx-auto order-0">
              <a class="navbar-brand" href="home-admin.php"><img src="images/Footsal.png" max-width="100%" height="36"/></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".dual-collapse2">
                  <span class="navbar-toggler-icon"></span>
              </button>
          </div>
          <div class="navbar-collapse collapse order-1 order-md-1 dual-collapse2">
              <ul class="navbar-nav me-auto">
                  <!-- <li class="nav-item active">
                      <a class="nav-link" href="#home">Home</a>
                  </li> -->
                  <!-- <li class="nav-item">
                      <a class="nav-link" href="#about_us"></a>
                  </li> -->
                  <li class="nav-item active">
                      <a class="nav-link" href="home-admin.php">Home</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="viewAllBooking.php">ViewBooking</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="booking-admin.php">Booking</a>
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
                  <li><a class="dropdown-item" href="viewAllBooking.php">Booking List</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="logout-admin.php">Logout</a></li>
                </ul>
              </div>

            <?php else: ?>
              <!-- <a href="login-admin.php"><button class="btn btn-sm btn-outline-secondary px-4 py-1" type="button">Log Out</button></a> -->
              <a href="login-admin.php"><button class="btn btn-primary mx-2 px-4 my-xs-3" type="button">Login</button></a>
              <!-- <a href="signup.php"><button class="btn btn-sm btn-outline-secondary px-4 py-1" type="button">Register</button></a> -->
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

  <div class="container">
  <div class="row mt-5">
    <div class="col-sm">
    <h2 class="fw-bold mb-3">Booking list</h2>
    </div>
    <div class="col-sm">
    </div>
    <div class="col-sm">
      <form method="post">
      <div class="input-group d-flex justify-content-end">
        <div class="form-outline">
          <input type="search" id="form1" name="keyword" class="form-control" autofocus placeholder="Search" />
        </div>
         <button type="submit" name="cari" ><i class="fa fa-search"></i></button>

        </button>
      </div>
          </form>
    </div>
  </div>
    <div class="row">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Booking ID</th>
            <th scope="col">Court Number</th>
            <th scope="col">First Name</th>
            <th scope="col">Booking Date</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
            <th scope="col">Payment Method</th>
            <th scope="col">Price (RM)</th>
            <th scope="col">Action</th>

          </tr>
        </thead>
        <tbody>
          <?php
          $stmt = $pdo->query("SELECT booking.booking_id, booking.court_id, users.fname, booking.start_time, booking.end_time, booking.booking_date,
            booking.payment_method, booking.price FROM booking join users on booking.user_id=users.user_id");

            if( isset($_POST["cari"]) ) {
                $keyword = $_POST["keyword"];
                $stmt = $pdo->query("SELECT booking.user_id,users.fname,users.lname,booking.booking_id,booking.start_time,
                booking.end_time,booking.booking_date,booking.payment_method, booking.price, booking.user_id,
                booking.court_id FROM booking join users on booking.user_id=users.user_id
                            WHERE
                            booking.user_id LIKE '%$keyword%' OR
                            users.fname LIKE '%$keyword%' OR
                            users.lname LIKE '%$keyword%' OR
                            booking.booking_id LIKE '%$keyword%' OR
                            booking.start_time LIKE '%$keyword%' OR
                            booking.end_time LIKE '%$keyword%' OR
                             booking.payment_method LIKE '%$keyword%' OR
                             booking.price LIKE '%$keyword%' OR
                             booking.user_id LIKE '%$keyword%' OR
                             booking.court_id LIKE '%$keyword%' OR
                            booking.booking_date LIKE '%$keyword%'");

    }

        $counter = 1;

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // code...

            echo "<tr><td>";
            echo(htmlentities($counter));
            echo("</td><td>");
            echo(htmlentities($row['booking_id']));
            echo("</td><td>");
            echo(htmlentities($row['court_id']));
            echo("</td><td>");
            echo(htmlentities($row['fname']));
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
            echo('<a href="delete-admin.php?booking_id='. $row['booking_id'].'" onclick="return deleteFunction()"><svg class="bi-trash-fill" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#bi-trash-fill"/></svg></a>');
            $counter++;
            ;
          }
            ?>
        </tbody>
      </table>
    </div>
  </div>

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
