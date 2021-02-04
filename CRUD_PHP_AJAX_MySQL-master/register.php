<?php

require_once 'functions.php';
require_once 'classes/User.php';

if(User::isLoggedIn()){
  header("Location: index.php");

  exit;
}

if(isset($_POST['register'])){ 
  $email = clean($_POST['email']);
  $password = clean($_POST['password']);
  $password2 = clean($_POST['password2']);
  $username = clean($_POST['username']);
  $secret = clean($_POST['secret']);

  $errors = array();

  if(empty($email)){
    $errors['email'] = '<p class="mb-0"><label class="text-danger font-weight-bold text-uppercase mb-0">Please Enter Email.</label></p>';
  }else{
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
          $errors['email'] = '<p class="mb-0"><label class="text-danger font-weight-bold text-uppercase mb-0">Invalid Email Format.</label></p>';
      }
  }

  if(empty($password)){
    $errors['password'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter Passowrd.</label></p>';
  }else{
    if($password != $password2){
      $errors['password_confirm'] = '<p><label class="text-danger font-weight-bold text-uppercase">Passwords Do Not Match.</label></p>';
    }
  }

  if(empty($password2)){
    $errors['password2'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Confirm Password.</label></p>';
  }

  if(empty($username)){
    $errors['username'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter Email.</label></p>';
  }

  if(empty($secret)){
    $errors['secret'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter Secret.</label></p>';
  }

  if(count($errors) == 0){
    $data = array(
      "email" => $email,
      "password" => $password,
      "username" => $username,
      "secret" => $secret,
    );

    if(User::takenEmail($email)){
      $errors['taken_email'] = '<div class="alert alert-dismissible alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      E-mail already in use.
    </div>';
    }else if(User::takenUsername($username)){
      $errors['taken_username'] = '<div class="alert alert-dismissible alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      Username already in use.
    </div>';
    }else if(User::register($data)){
      $_SESSION['register_success_message'] = "Successfully Registered";
      header("Location: index.php");

      exit;
    }

  } // COUNT errors CLOSE
} // POST REQ CLOSE
?>

<?php include 'header.php'; ?>

<!-- -------- PRIJAVE ---------- -->
  <section id="prijave">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8 col-8">
          <h1 class="mt-5">REGISTER</h1>

          <?php echo $errors['taken_email'] ?? ""; ?>
          <?php echo $errors['taken_username'] ?? ""; ?>

          <form method="POST" class="mb-5">
            <fieldset>

              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter e-mail" value="<?php echo $email ?? ""; ?>">       
                <?php echo $errors['email'] ?? ""; ?>      
                <small id='emailHelp' class='form-text text-left text-black mt-0'>We'll never share your email with anyone else.</small>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" value="<?php echo $password ?? ""; ?>">             
                <?php echo $errors['password'] ?? ""; ?>
                <?php echo $errors['password_confirm'] ?? ""; ?>
              </div>

              <div class="form-group">
                <label for="password2">Confirm Password</label>
                <input type="password" name="password2" class="form-control" id="password2" placeholder="Confirm password" value="">             
                <?php echo $errors['password2'] ?? ""; ?>
              </div>

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" value="<?php echo $username ?? ""; ?>">             
                <?php echo $errors['username'] ?? ""; ?>
              </div>

              <div class="form-group">
                <label for="username">Enter secret exercise</label>
                <input type="password" name="secret" class="form-control" id="secret" placeholder="Enter secret exercise" value="<?php echo $secret ?? ""; ?>">             
                <?php echo $errors['secret'] ?? ""; ?>
              </div>

              <button id="register-btn" type="submit" name="register" class="btn btn-primary d-block w-100">REGISTER</button>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- -------- PRIJAVE ---------- -->