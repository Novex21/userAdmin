<?php
include('vendor/autoload.php');
use Helpers\Auth;

$auth = Auth::check();

function h($content) {
 return htmlspecialchars($content);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Profile</title>
  </head>
  <body>
    <div class="container">

      <h1 class=" mt-5 mb-5">
        <?= $auth->name ?>
        <span class="fw-normal text-muted">
          <?= $auth->role ?>
        </span>
      </h1>

      <?php if(isset($_GET['error'])) :?>
        <div class="alert alert-warning">
          Cannot upload file
        </div>
      <?php endif ?>

      <?php if (isset($_GET['access'])) : ?>
        <div class="alert alert-danger">
          Can't Access!! No Permission Allowed.
        </div>
      <?php endif ?>

      <?php if($auth->photo) : ?>
        <img
          class="img-thumbnail mb-3"
          src="_actions/photos/<?= h($auth->photo) ?>"
          alt="Profile Picture" width="200" height="400">
      <?php endif ?>

      <form action="_actions/upload.php" enctype="multipart/form-data" method="post">
        <div class="input-group mb-3">
          <input  type="file" name="photo" class="form-control">
          <button class="btn btn-secondary">Upload</button>
        </div>
      </form>

      <ul class="list-group">
        <li class="list-group-item">
          <b>Email : </b><?= h($auth->email) ?>
        </li>
        <li class="list-group-item">
          <b>Phone : </b><?= h($auth->phone) ?>
        </li>
        <li class="list-group-item">
          <b>Address : </b><?= h($auth->address) ?>
        </li>
      </ul>

      <br>
      <a href="admin.php" class="btn btn-sm btn-warning">Manage Users</a>
      <a href='_actions/populate.php' class="btn btn-sm btn-success">Populate Users</a>
      <a href="_actions/logout.php" class="btn btn-sm btn-danger">Logout</a>
    </div>
  </body>


</html>
