<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/88riot/system/init.php';
include 'includes/head.php';
//hashed the password to show gibberish letters to store in the database for security purpose
//$password = 'password';
//$hashed = password_hash($password, PASSWORD_DEFAULT);
//echo "$hashed";

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();
?>


<div id="login-form">
    <div>

    <?php
        if($_POST){
            //form validation
            if(empty($_POST['email']) || empty($_POST['password'])){
            $errors[] = 'You must provide email and password.';
            }

            //validate email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors[] = 'You must enter a valid email';
            }

            //password is less than 6 characters
            if(strlen($password)<6){
                $errors[] = 'Password must be at least 6 characters';
            }

            //check if email is in database
            $query = $db->query("SELECT * FROM users WHERE email = '$email'");
            $user = mysqli_fetch_assoc($query);
            $userCount = mysqli_num_rows($query);
            if($userCount==0){
                $errors[]='That email doesn\'t exist in the database';
            }
             //check if password is incorrect
            if(!password_verify($password, $user['password'])){
                $errors[] = 'Password incorrect. Try again';
            }



            //check for errors
            if(!empty($errors)){
             echo display_errors($errors);
            }else{
             //log user
            $user_id = $user['id'];
            login($user_id);
            }
        }

    ?>

    </div>
    <h2 class="text-center"><span class="glyphicon glyphicon-log-in">Admin Login</span></h2><hr>
    <form class="form-signin" style="width: 50%; padding-left:30%" action="login.php" method="post">

            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="text" name="email" id="inputEmail" class="form-control" placeholder="Email Address"  value="<?=$email; ?>">
              <hr>
            <label for="inputPassword" class="sr-only">Password: </label>
            <input type="password" name="password" id="password" class="form-control"  placeholder="Password" value="<?=$password; ?>">
              <hr>

        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" style="width: 30%" type="submit">Login</button>
        </div>
    </form>
    <p class="text-right"><a href="/88riot/index.php" alt="home">Visit site</a></p>
</div>
