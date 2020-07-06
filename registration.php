<?php
session_start();
    include("server.php");
    $db = connect();
    if(isset($_POST["register_user"])) {
        $errors = array();
         //when button is clicked register users
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

         // form validation
        if(empty($username)) {array_push($errors, "Username is required");}
        if(empty($email)) {array_push($errors, "Email is required");}
        if(empty($password_1)) {array_push($errors, "Password is required");}
        if($password_1 != $password_2){array_push($errors, "Password not same");}

        // check db for user with existing username
        $user_check_query = "SELECT * FROM user WHERE username = '$username' or email = '$email' LIMIT 1";
        $results = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($results);

        if($user){

            if($user['username'] === $username){array_push($errors, "Username already exists");}
            if($user['email'] === $email){array_push($errors, "Email already exists");}
        }
       
        
        // Register a user if there are no error
        if(count($errors) == 0) {
            // to encrypt password before storing in the database
            $password = md5($password_1);
            $query = "INSERT INTO user (username, email, password) VALUES('$username', '$email', '$password')" ;
            
            mysqli_query($db, $query) or die(mysqli_error($db));
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";

            header('location: index.php');
        } 
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/signup.css">
    <title>Signup</title>
</head>
<body>
    <div class="container">
        <div class="heading">
            <h2>IGHUB Form</h2>
        </div>
        <div class="form-data">
            <form  method="POST" id="form" name="form" >

            <?php include('error.php') ?>

            <div>                
            <label for="username">Enter Username</label><br>
            <input type="text" id="username" name="username" placeholder="Username" required><br>
            </div>

            <div>
            <label for="email">Email Address</label><br>
            <input type="email" name="email" id="email" placeholder="Email Address" required><br>
            </div>

            <div>
            <label for="password1">Enter Password</label><br>
            <input type="password" name="password_1" id="password1" placeholder="Enter password" required><br>
            </div>

            <div>
            <label for="password2">Confirm Password</label><br>
            <input type="password" name="password_2" id="password2" placeholder="Enter password" required><br>
            </div>

            <div>
            <button  type="submit" name="register_user" class="btn">Submit</button>
            </div>

            <p class="existing-user">Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div> 
</body>
</html>