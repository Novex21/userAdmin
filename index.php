<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
      .wrap {
        width: 100%;
        max-width: 400px;
        margin: 40px auto;
      }
    </style>
  </head>
  <body class="text-center">
    <div class="wrap">
      <h1 class="h3 mb-3">Log In</h1>

      <?php if (isset($_GET['registered'])) : ?>
        <div class="alert alert-success">
          Account Created, Please Login.
        </div>
      <?php endif ?>

      <?php if (isset($_GET['suspended'])) : ?>
        <div class="alert alert-danger">
          Your Account is banned due to our community rules.
        </div>
      <?php endif ?>

      <?php if (isset($_GET['incorrect'])) : ?>
        <div class="alert alert-danger">
          Incorrect Email or Password
        </div>
      <?php endif ?>

      <form action="_actions/login.php" method="post">
        <input
          type="email" name="email"
          class="form-control mb-2"
          placeholder="Email" required
        >
        <input
          type="password" name="password"
          class="form-control mb-2"
          placeholder="Password" required
        >
        <button type="submit" class="w-100 btn btn-lg btn-primary">Login</button>
      </form>
      <br>
      <a href="register.php" class="btn btn-success btn-s">Register</a>
    </div>

</html>
