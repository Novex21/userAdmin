<?php
namespace Libs\Database;
use PDOException;

class UsersTable {

  private $db = null;

  public function __construct(MySQL $db) {      //Dependency Injection design pattern
    $this->db = $db->connect();
  }
  public function insert($data) {         //For Registeration
    try {
      $query = "INSERT INTO users (
        name, email, phone, address,
        password, role_id, created_at
      ) VALUES (
        :name, :email, :phone, :address,
        :password, :role_id, NOW()
      )
      ";
      $statement = $this->db->prepare($query);
      $statement->execute($data);
      return $this->db->lastInsertId();
    } catch(PDOException $e) {
      return $e->getMessage();
    }
  }

  public function getAll() {                        //To get all informations from users and rolename and value
    $statement = $this->db->query (
      "SELECT users.*, roles.name AS role, roles.value FROM users LEFT JOIN roles ON users.role_id = roles.id"
    );
    return $statement->fetchall();
  }

  public function hashPassword($email) { //For checking password
    $statement = $this->db->prepare(
      "SELECT users.password FROM users WHERE users.email = :email");

      $statement->execute([':email'=>$email]);
      $row = $statement->fetch();
      return $row ?? false;
  }



  public function findByEmailAndPassword ($email, $password) {    //For Login by checking email and password
    $statement = $this->db->prepare(
      "SELECT users.*, roles.name AS role, roles.value FROM users LEFT JOIN roles ON users.role_id = roles.id
      WHERE users.email = :email AND users.password = :password"
    );
    $statement->execute([
      ':email' => $email,
      ':password' => $password
    ]);
    $row = $statement->fetch();
    return $row ?? false;
  }

  public function updatePhoto($id, $name) {        //Uploading each users photo;
    $statement = $this->db->prepare(
      "UPDATE users SET photo=:name, updated_at = NOW() WHERE id=:id"
    );
    $statement->execute([
      ':id' => $id,
      ':name' => $name
    ]);
    return $statement->rowCount();
  }

  public function suspend($id) {
    $statement = $this->db->prepare(
      "UPDATE users SET suspended=1, updated_at = NOW() WHERE id = :id"
    );
    $statement->execute([':id' => $id ]);
    return $statement->rowCount();
  }

  public function unsuspend($id) {
    $statement = $this->db->prepare(
      "UPDATE users SET suspended=0, updated_at = NOW() WHERE id = :id"
    );
    $statement->execute([':id' => $id ]);
    return $statement->rowCount();
  }

  public function changeRole($id, $role) {
    $statement = $this->db->prepare(
      "UPDATE users SET role_id = :role, updated_at = NOW()  WHERE id = :id"
    );
    $statement->execute([':id' => $id, ':role' => $role ]);
    return $statement->rowCount();
  }

  public function delete($id) {
    $statement = $this->db->prepare(
      "DELETE FROM users WHERE id = :id"
    );
    $statement->execute([':id' => $id ]);
    return $statement->rowCount();
  }

}
