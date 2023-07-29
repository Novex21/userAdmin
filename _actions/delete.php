<?php
include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;
use Helpers\Auth;

$auth = Auth::check();
$table = new UsersTable(new MySQL());
session_start();

if($_GET['csrf'] === $_SESSION['csrf']) {
  $id = $_GET['id'];
  $table->delete($id);
  HTTP::redirect("/admin.php");
} else {
  HTTP::redirect("/admin.php", "error=delete");
}
