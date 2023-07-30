<?php
include('vendor/autoload.php');

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;
use Helpers\HTTP;

$table = new UsersTable(new MySQL());
$all = $table->getAll();

$auth = Auth::check();

if (!($auth->value > 1)) {
  HTTP::redirect("/profile.php", "access=denied");
}

function h($content) {
 return htmlspecialchars($content);
}


$token = sha1(rand(1, 1000) . 'csrf secret');
$_SESSION['csrf'] = $token;

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>

  <body>
    <div class="container">

      <?php if(isset($_GET['populate'])) :?>
        <div class="alert alert-success">
          Population Done.....
        </div>
      <?php endif ?>

      <?php if(isset($_GET['error'])) :?>    <!--someone accessing detele function -->
        <div class="alert alert-danger">
          Your Account is being Accessed by Other Website!!
        </div>
      <?php endif ?>


      <div class="float-right me-5">
        <a href="profile.php">Profile</a>
        <a href="_actions/logout.php" class="text-danger">Logout</a>
      </div>


      <h1 class="mt-5 mb-5">
        Manage Users
        <span class="badge bg-warning text-dark">
          <?= count($all) ?>
        </span>
      </h1>

      <table class="table  table-bordered table-hover">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>

        <?php foreach ($all as $user) : ?>
          <?php if($user->id === $auth->id) : ?>
            <tr class="table-info">
          <?php else : ?>
            <tr>
          <?php endif ?>
              <td><?= h($user->id) ?></td>
              <td><?= h($user->name) ?></td>
              <td><?= h($user->email) ?></td>
              <td><?= h($user->phone) ?></td>

              <td>
                <?php if($user->value === 1) : ?>
                  <span class="badge bg-secondary">
                    <?= h($user->role) ?>
                  </span>
                <?php elseif ($user->value === 2) : ?>
                  <span class="badge bg-primary">
                    <?= h($user->role) ?>
                  </span>
                <?php else : ?>
                  <span class="badge bg-success">
                    <?= h($user->role) ?>
                  </span>
                <?php endif ?>
              </td>

              <td>
                
                  <div class="btn-group dropdown">

                    <a href="#" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                      Change Role
                    </a>

                    <div class="dropdown-menu dropdown-menu-dark">
                      <a href="_actions/role.php?id=<?= $user->id ?>&role=1" class="dropdown-item">
                        User
                      </a>
                      <a href="_actions/role.php?id=<?= $user->id ?>&role=2" class="dropdown-item">
                        Manager
                      </a>
                      <a href="_actions/role.php?id=<?= $user->id ?>&role=3" class="dropdown-item">
                        Admin
                      </a>
                    </div>

                    <?php if($user->id !== $auth->id) : ?>
                      <?php if($user->suspended) : ?>
                        <a href="_actions/unsuspend.php?id=<?= $user->id ?>"
                          class="btn btn-sm btn-danger">
                          Suspended
                        </a>
                      <?php else: ?>
                          <a href="_actions/suspend.php?id=<?= $user->id ?>"
                            class="btn btn-sm btn-outline-success">
                            Active
                          </a>
                      <?php endif ?>
                    <?php endif ?>
                    
                    

                    <?php if($auth->value === 3) : ?>
                      <?php if($user->id === $auth->id) : ?>
                        <span class="text-danger ms-2 ">
                          <small>
                            Can't Delete Your Own Account!
                          </small>
                        </span>
                      <?php else : ?>
                        <a href="_actions/delete.php?id=<?= h($user->id) ?>&csrf=<?= $token ?>"
                          class="btn btn-sm btn-outline-danger"
                          onClick="return confirm('Are you sure?')">Delete
                        </a>
                      <?php endif ?>
                    <?php else : ?>
                      <span class="text-danger">
                        Can't Access to Delete
                      </span>
                    <?php endif ?>


                  </div>
              </td>

            </tr>
        <?php endforeach ?>
      </table>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
