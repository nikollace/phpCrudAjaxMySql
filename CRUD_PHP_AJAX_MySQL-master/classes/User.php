<?php

require_once 'classes/Database.php'; // Pozivanje fajla gde je Database

class User {

  public static function register($data) {
    try {
      $data = (object) $data;
      $data->password = md5(md5($data->password)); // Hashovanje sifre sa md5
      $query = Database::getInstance()->getConnection()->prepare("INSERT INTO user (email, username, password, secret) VALUES (?, ?, ?, ?)");
      $result = $query->execute([
        $data->email,
        $data->username,
        $data->password,
        $data->secret,
      ]);

      $data->id = Database::getInstance()->getConnection()->lastInsertId();

      if ($result) { // Ukoliko je query uspesan pravimo sesiju i vracamo true
        self::createSession($data);
        return true;
      }

      return false;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      exit;
    }
  }

  public static function takenEmail($email) {
    try {
      $query = Database::getInstance()->getConnection()->prepare("SELECT email FROM user WHERE email = :email");
      //klasican prepare statement, slicno kao u javi
      $query->execute(array(
        ':email' => $email
      ));

      $user = $query->fetch();

      if ($user) {
        return true;
      }

      return false;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      exit;
    }
  }

  public static function getSecret($userID) {
    try {
      $query = Database::getInstance()->getConnection()->prepare("SELECT secret FROM user WHERE id = :id");
      //klasican prepare statement, slicno kao u javi
      $query->execute(array(
        ':id' => $userID
      ));

      $user = $query->fetch();

      return $user;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      exit;
    }
  }

  public static function takenUsername($username) {
    try {
      $query = Database::getInstance()->getConnection()->prepare("SELECT username FROM user WHERE username = :username");
      //klasican prepare statement, slicno kao u javi
      $query->execute(array(
        ':username' => $username,
      ));

      $user = $query->fetch();

      if ($user) {
        return true;
      }

      return false;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      exit;
    }
  }

  public static function login($data) {
    try {
      $data = (object) $data;
      $data->password = md5(md5($data->password));
      $query = Database::getInstance()->getConnection()->prepare("SELECT id, email, username FROM user WHERE username = :username AND password = :password");
      //prepare statement
      $query->execute(array(
        ':username' => $data->username,
        ':password' => $data->password
      ));

      $user = $query->fetch();

      if ($user) {
        $user = (object) $user;
        self::createSession($user);

        return true;
      }

      return false;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      exit;
    }
  }

  public static function createSession($user) {
    $_SESSION['user'] = [
      'id' => $user->id,
      'email' => $user->email,
      'username' => $user->username,
      'secret' => $user->secret,
    ];
  }

  public static function logout() {
    // Gasimo i unistavamo sesiju nakon logout
    //   session_unset();
    //   session_destroy();
    unset($_SESSION['user']);
  }

  public static function isLoggedIn() {
    // Ako je sesija aktivna znaci da je korisnik ulogovan i dalje.
    if (isset($_SESSION['user'])) {
      return true;
    }

    return false;
  }
}