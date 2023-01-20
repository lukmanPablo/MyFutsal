<?php
  session_start();

  require "Util.php";
  $util = new Util();

  //Clear Session
  $_SESSION["user_id"] = "";
  session_destroy();

  // clear cookies
  $util->clearAuthCookie();

  //setcookie("user_login", "");
  //setcookie("user_password", "");
  header("Location: login-admin.php");
  exit;

 ?>
