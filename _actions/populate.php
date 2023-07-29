<?php
include ("../vendor/autoload.php");
use Faker\Factory as Faker;

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
if (!($auth->value === 3)) {
  HTTP::redirect('/profile.php', 'access=denied');
}

$faker = Faker::create();
$table = new UsersTable (new MySQL());



if ($table) {

  echo "Database connection open.\n";

  for ($i = 0; $i < 9; $i++)
  {
    $data = [
      'name' => $faker->name,
      'email' => $faker->email,
      'phone' => $faker->phoneNumber,
      'address' => $faker->address,
      'password' => password_hash( 'password', PASSWORD_BCRYPT),
      'role_id' => $i < 5 ? rand(1, 3) : 1
    ];

    $table->insert($data);

  }

  HTTP::redirect('/admin.php', 'populate=done');
}
