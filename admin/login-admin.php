<?php

session_start();
//require_once "pdo.php";
require_once "Auth.php";
require_once "Util.php";

$auth = new Auth();
$db_handle = new DBController();
$util = new Util();

require_once "authCookieSessionValidate.php";

if ($isLoggedIn && isset($_COOKIE["user_id"])) {
    //session_start();
    //$_SESSION["user_id"] = $user[0]["user_id"];
    $_SESSION["user_id"] = $_COOKIE["user_id"];
    $util->redirect("home-admin.php");
}

$salt = 'XyZzy12*_';

// if(isset($_POST["back"])){
//   header("Location: C:\xampp\htdocs\footsal\Project-daniel\login.php");
//   return;
// }

if (isset($_POST["login"])) {
  $isAuthenticated = false;

  $username = $_POST["email"];
  $password = $_POST["password"];

  if($username === "admin@gmail.com"){
    $user = $auth->getUserByUsername($username);
    $password_hash = hash('sha512', $salt.$_POST['password']);
    if ($password_hash === $user[0]["password_hash"]) {
        $isAuthenticated = true;
    }

  }




  if ($isAuthenticated) {
      $_SESSION["user_id"] = $user[0]["user_id"];

      // Set Auth Cookies if 'Remember Me' checked
      if (! empty($_POST["remember"])) {
          setcookie("user_login", $username, $cookie_expiration_time);
          setcookie("user_id", $_SESSION["user_id"], $cookie_expiration_time);

          $random_password = $util->getToken(16);
          setcookie("random_password", $random_password, $cookie_expiration_time);

          $random_selector = $util->getToken(32);
          setcookie("random_selector", $random_selector, $cookie_expiration_time);

          $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
          $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);

          $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);

          // mark existing token as expired
          $userToken = $auth->getTokenByUsername($username, 0);
          if (! empty($userToken[0]["id"])) {
              $auth->markAsExpired($userToken[0]["id"]);
          }
          // Insert new token
          $auth->insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date);
      } else {
          $util->clearAuthCookie();
      }
      $util->redirect("home-admin.php");
  } else {
      $_SESSION['error'] = "Wrong email and password or maybe you're not an admin";
      if (empty($_POST['email']) || empty($_POST['password']) ) {
        $_SESSION['error'] = "Email and password is required";
      }
      header("Location: login-admin.php");
      return;
  }

}

if (isset($_POST['cancel'])) {
  session_unset();
  session_destroy();
  header('Location: login-admin.php');
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Footsal | Login</title>
  <link rel="icon" type="image/x-icon" href="football.png">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="main.css">


    <title>Login</title>
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
              <a class="navbar-brand" href="home-admin.php"><img src="images/Footsal.png" max-width="100%" height="36"/></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".dual-collapse2">
                  <span class="navbar-toggler-icon"></span>
              </button>
          </div>
          <!-- <div class="navbar-collapse collapse order-1 order-md-1 dual-collapse2">
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
          </div> -->
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
              <a href="login-admin.php"><button class="btn btn-primary mx-2 px-4 my-xs-3" type="button">Login</button></a>
              <!-- <a href="signup.php"><button class="btn btn-sm btn-outline-secondary px-4 py-1" type="button">Register</button></a> -->
            <?php endif; ?>
            </form>
          </div>
      </div>
  </nav>



  <form method="post">

   <section class="h-100" style="background-color: #eee;">
     <?php
         if (isset($_SESSION["error"])) {
           ?>
           <div class="alert alert-danger d-flex align-items-center" role="alert">
             <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Error:"><use xlink:href="#exclamation-triangle-fill"/></svg>
             <div>
               <strong><?php echo " ".$_SESSION["error"];
                            unset($_SESSION["error"]);?></strong>
             </div>
           </div>
           <?php
         }


      ?>
     <div class="container py-5 h-100"  >
       <div class="row d-flex justify-content-center align-items-center h-100">
         <div class="col">
           <div class="card card-registration my-4" style="border-radius: 40px;">
             <div class="row g-0">

               <div class="col-xl-6">
                 <div class="card-body p-md-5 text-black" style="border-radius:40px;">
                   <h3 class="text-center h1 fw-bold mb-3 mx-1 mx-md-4 mt-2">Login: Admin</h3>
                   <p class="text-center mb-5" style="color:#292929;">Welcome Back! Sign into your account.</p>

                   <div class="form-outline mb-4">
                     <input type="text" id="email" name="email" class="form-control form-control-lg" />
                     <label class="form-label" for="form3Example8">Email</label>
                   </div>

                   <div class="form-outline mb-4">
                     <input type="password" id="password" name="password" class="form-control form-control-lg" />
                     <label class="form-label" for="form3Example90">Password</label>
                   </div>

                   <div class="row">
                     <div class="col d-flex justify-content-start">
                        <!-- Checkbox -->
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="remember" id="remember"/>
                          <label class="form-check-label" for="remember"> Remember me </label>
                        </div>

                    </div>
                   </div>


                   <!-- <div class="d-flex justify-content-center pt-3">

                   </div> -->

                   <div class="d-flex justify-content-center pt-3">
                     <!-- <button type="submit" class="btn btn-primary text-black px-5" name="back">Back</button> -->
                     <button type="submit" class="btn btn-primary text-black px-5" name="login">Login</button>
                   </div>

                   <!-- Register buttons -->
                  <div class="text-center">
                  </div>


                 </div>
               </div>

                 <div class="col-xl-6 d-none d-xl-block">
                   <img src="images/futsal_signin.jpg"
                     alt="login" class="img-fluid"
                     style="border-radius: 40px;" />
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
