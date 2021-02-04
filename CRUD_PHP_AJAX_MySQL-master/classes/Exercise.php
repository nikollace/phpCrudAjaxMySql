Nikola Đorđević, [04.02.21 22:30]
<?php

require_once 'classes/Database.php'; // Pozivanje fajla gde je Database

class Exercise {
  
  public static function add($data) {
    try {
      $data = (object) $data;
      $query = Database::getInstance()->getConnection()->prepare("INSERT INTO exercise (title, series, iterance, break_series, description, secret, coach_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $result = $query->execute([
        $data->exercise_title_add,
        $data->exercise_series_add,
        $data->exercise_iterance_add,
        $data->exercise_break_series_add,
        $data->exercise_description_add,
        $data->exercise_secret_add,
        $data->exercise_coach_id_add,
      ]);

      return $result;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";
      echo $e->getLine();
      // echo $e->getFile();

      exit;
    }
  }

  public static function getAll($coachId) {
    try {
      $query = Database::getInstance()->getConnection()->prepare("SELECT * FROM exercise WHERE coach_id = :id");
      $query->execute(array(
        ':id' => $coachId,
      ));
      $exercies = $query->fetchAll();

      return $exercies;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      return [];
    }
  }

  public static function takenTitle($title) {
    try {
      $query = Database::getInstance()->getConnection()->prepare("SELECT title FROM exercise WHERE title = :title");
      //klasican prepare statement, slicno kao u javi
      $query->execute(array(
        ':title' => $title,
      ));

      $exercise = $query->fetch();

      if ($exercise) {
        return true;
      }

      return false;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      exit;
    }
  }

  public static function sortNumberOfSeries() {
    try {
      $query = Database::getInstance()->getConnection()->prepare("SELECT * FROM exercise ORDER BY series DESC");
      $query->execute();
      $exercies = $query->fetchAll();

      return $exercies;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      return [];
    }
  }

  public static function sortByRating() {
    try {
      $query = Database::getInstance()->getConnection()->prepare("SELECT m.*, AVG(r.rating) AS rating FROM movie m
      JOIN rating r ON m.id = r.movie_id
      GROUP BY r.movie_id
      ORDER BY rating DESC");
      $query->execute();
      $movies = $query->fetchAll();

      return $movies;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      return [];
    }
  }

  public static function update($data, $exerciseID) {
    try {
      $data = (object) $data;
      $query = Database::getInstance()->getConnection()->prepare("UPDATE exercise SET title = :title, series = :series, iterance = :iterance, break_series = :break_series, description = :description WHERE id = :id LIMIT 1");

      $result = $query->execute(array(
        ':title' => $data->exercise_title_update,
        ':series' => $data->exercise_series_update,
        ':iterance' => $data->exercise_iterance_update,
        ':break_series' => $data->exercise_break_series_update,
        ':description' => $data->exercise_description_update,
        ':id' => $exerciseID,
      ));

      return $result;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      exit;
    }
  }

  public static function delete($exerciseID) {
    try {
      $query = Database::getInstance()->getConnection()->prepare("DELETE FROM exercise WHERE id = :id LIMIT 1");
      $result = $query->execute(array(':id' => $exerciseID));

      return $result;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      exit;
    }
  }
  
public static function sort($sortType, $coachId) {
    try {
      $query = Database::getInstance()->getConnection()->prepare("SELECT * FROM exercise WHERE coach_id = :id ORDER BY $sortType DESC");
      $query->execute(array(
        ':id' => $coachId,
      ));
      $exercies = $query->fetchAll();

      return $exercies;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      return [];
    }
  }

  public static function search($searchText, $coachId) {
    try {
      $query = Database::getInstance()->getConnection()->prepare("SELECT * FROM exercise WHERE title LIKE '%" . $searchText . "%' AND coach_id = :id");
      $query->execute(array(
          ':id' => $coachId,
        ));
      $exercies = $query->fetchAll();

      return $exercies;
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      return [];
    }
  }

  public static function getRating($movieID) {
    try {
      $query = Database::getInstance()->getConnection()->prepare("SELECT rating FROM rating WHERE movie_id = :movieID");
      $query->execute(array(
        ':movieID' => $movieID,
      ));
      $ratings = $query->fetchAll();

      $ratingR = 0.0;

      foreach ($ratings as $rating) {
        $ratingR += $rating['rating'];
      }

      return sizeof($ratings) == 0 ? 0.0 : round($ratingR / sizeof($ratings), 2);
    } catch (PDOException $e) {
      echo "<p class='alert mb-0 alert-danger'>PDO EXCEPTION: " . $e->getMessage() . "</p>";

      return 0.0;
    }
  }
}