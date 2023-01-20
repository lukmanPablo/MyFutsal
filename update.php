<?php
  // Dekat sini pun nanti kena letak logic yg booking takleh duplicate

  session_start();
  require_once "pdo.php";
  require_once "authCookieSessionValidate.php";


  $month = date('m');
  $day = date('d');
  $year = date('Y');
  $today = $year . '-' . $month . '-' . $day;

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

  if(isset($_POST['update'])){

    // if(isset($_POST['court']) && isset($_POST['booking_date']) && isset($_POST['start_time']) &&
    //   isset($_POST['end_time']) && isset($_POST['payment_method'])){

        if(empty($_POST["court"])){
          $_SESSION["error"] = "Please choose your court.";
        }
        elseif (empty($_POST["booking_date"])) {
          $_SESSION["error"] = "Please choose your booking date.";
        }
        elseif (empty($_POST["start_time"])) {
          $_SESSION["error"] = "Please choose your start time.";
        }
        elseif (empty($_POST["end_time"])) {
          $_SESSION["error"] = "Please choose your end time.";
        }
        elseif (empty($_POST["payment_method"])) {
          $_SESSION["error"] = "Please choose your payment method.";
        }
        else {

          $start_time = $_POST['start_time'];
          $end_time = $_POST['end_time'];


          $time1 = strtotime($start_time);
          $time2 = strtotime($end_time);
          $total_hour = round(abs($time2 - $time1) / 3600,2);

          $price = 40 * round($total_hour);

          //prevent overlap booking_id
          $new_start_time = $time1;
          $new_end_time = $time2;

          //SELECT * FROM booking WHERE booking_date = '2023-01-11' AND court_id = 1 AND end_time >='09:30:00' AND start_time <= '10:30:00';
          $stmt = $pdo->prepare("SELECT * FROM booking WHERE booking_date = :booking_date AND court_id = :court_id AND end_time >= '$start_time' AND start_time <= '$end_time'");
          $stmt->execute(array(':booking_date' => $_POST['booking_date'],
                               ':court_id' => $_POST['court']));
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          //echo "sdadasdd";
          //print_r($row);
          //echo "string";
          if ( $row !== false ) {
            $_SESSION["error"] = "Your Booking is clash with another customer";
            header('Location: update.php');
            return;
          }
          else{
            $sql = "UPDATE booking SET court_id = :court_id, booking_date = :booking_date, start_time = :start_time,
              end_time = :end_time, payment_method = :payment_method, price = :price WHERE booking_id = :booking_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':booking_id' => $_POST['booking_id'],
                                 ':court_id' => $_POST['court'],
                                 ':booking_date' => $_POST['booking_date'],
                                 ':start_time' => $_POST['start_time'],
                                 ':end_time' => $_POST['end_time'],
                                 ':payment_method' => $_POST['payment_method'],
                                 ':price' => $price));
            $_SESSION['success'] = 'Booking updated';
            header( 'Location: viewBookingList.php' ) ;
            return;

          }

        }
        header("Location: update.php");
        return;


    //}
  }

  $stmt = $pdo->prepare("SELECT * FROM booking where booking_id = :xyz");
  $stmt->execute(array(":xyz" => $_GET['booking_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  // if ( $row === false ) {
  //   $_SESSION['error'] = 'Bad value for user_id';
  //   header( 'Location: index.php' ) ;
  //   return;
  // }

  $b = htmlentities($row['booking_id']);
  $c = htmlentities($row['court_id']);
  $bd = htmlentities($row['booking_date']);
  $st = htmlentities($row['start_time']);
  $et = htmlentities($row['end_time']);
  //$pm = htmlentities($row['payment_method']);


  if (isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
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
      <symbol id="bi-cash" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
        <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
      </symbol>
      <symbol id="bi-credit-card" fill="currentColor" viewBox="0 0 16 16">
        <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
      </symbol>
    </svg>

  </head>
  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
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
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
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
            if (isset($_SESSION["error"])) {
              ?>
              <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                  <strong><?php echo " ".$_SESSION["error"];
                               unset($_SESSION["error"]);?></strong>
                </div>
              </div>
              <?php
            }


         ?>


    <!--HABIS DAH NAVBAR--------------------->
    <form method="post">
      <section class="intro">
          <div class="mask d-flex align-items-center" style="background-color: #eee;">
            <div class="container  mt-5">
              <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                  <p><i>You are <b>encouraged</b> to refer at our operating hours first in the Home Page before make the booking.
                   If your booking is clash with another customer, please try on different time or court number.</i></p>
                  <div class="card" style="border-radius: 50px;">
                    <div class="card-body p-5 text-center">

                      <div class="my-md-2">

                        <h2 class="fw-bold mb-3"><u>Update Booking</u></h2>

                        <div class="row"> <!--Select Date -->
                          <div class="col-xl-7 d-flex justify-content-start">
                            <!-- <p class="fw-bold"></p> -->
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xl-12">
                               <td><input type="hidden" name="booking_id" value="<?= $b ?>"></td>
                          </div>
                        </div> <!--Select Date -->


                        <div class="row"> <!--Select Court -->
                          <div class="col-xl-4 d-flex justify-content-start mt-3">
                            <p class="fw-bold">Select Court</p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xl-12">
                            <select class="form-select mb-3" name="court" id="court">
                              <option value="none" selected disabled hidden></option>
                              <option value="1">Court 1</option>
                              <option value="2">Court 2</option>
                              <option value="3">Court 3</option>
                              <option value="1">Court 4</option>
                              <option value="2">Court 5</option>
                              <option value="3">Court 6</option>
                            </select>
                          </div>
                        </div> <!--Select Court -->

                        <div class="row"> <!--Select Date -->
                          <div class="col-xl-7 d-flex justify-content-start">
                            <p class="fw-bold">Select A Date</p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xl-12">
                              <input type="date" value="<?= $bd ?>" class="form-control" id="booking_date" name="booking_date">
                          </div>
                        </div> <!--Select Date -->

                        <div class="row mt-3"> <!--Start Time -->
                          <div class="col-xl-12 d-flex justify-content-start">
                            <p class="fw-bold">Select Start and End Time</p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xl-6">
                            <div class="cs-form">
                              <input type="time" class="form-control" name="start_time" value="<?= $st ?>" step="900" />
                            </div>
                        </div>
                        <div class="col-xl-6">
                          <div class="cs-form">
                            <input type="time" class="form-control" name="end_time" value="<?= $et ?>" step="900"  />
                          </div>
                        </div>
                      </div> <!--End Time -->

                      <div class="row mt-3"> <!--Select Payment method -->
                        <div class="col-xl-12 d-flex justify-content-start">
                          <p class="fw-bold">Select Payment Method</p>
                        </div>
                      </div>

                        <div class="row">
                          <div class="col-6">
                            <input type="radio" class="btn-check" name="payment_method" id="option1" autocomplete="off" value="Cash"/>
                            <label class="btn btn-secondary px-5" for="option1">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Cash"><use xlink:href="#bi-cash"/></svg>
                            Cash</label>
                          </div>

                          <div class="col-6">
                            <input type="radio" class="btn-check" name="payment_method" id="option2" autocomplete="off" value="Card" />
                            <label class="btn btn-secondary px-5" for="option2">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Card"><use xlink:href="#bi-credit-card"/></svg>
                            Card</label>
                          </div>
                        </div> <!--Select Payment method -->

                        <div class="row mt-5">
                          <input type="submit" class="btn btn-primary" name="update" value="Update Booking">
                        </div>


                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </section>
    </form>



    <script src='script.js'></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-
    9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

  </body>



</html>
