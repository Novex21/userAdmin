<?php
  session_start();
  include("../vendor/autoload.php");
  use Libs\Database\MySQL;
  use Libs\Database\UsersTable;
  use Helpers\HTTP;

  $table = new UsersTable(new MySQL());

  $email = $_POST['email'];
  $hash_password = $table->hashPassword($email);
  $array_password = json_decode(json_encode($hash_password), true);
  $password = $array_password['password'];


  if(password_verify($_POST['password'], $password)) {

    $user = $table->findByEmailAndPassword($email, $password);

  }else {
    HTTP::redirect("/index.php", "incorrect=2");
  }

  if($user) {
    $_SESSION['user'] = $user;

    if($user->suspended) {
        HTTP::redirect("/index.php", "suspended=1");
      }
    HTTP::redirect("/profile.php");
  } else {
    HTTP::redirect("/index.php", "incorrect=1");
  }
