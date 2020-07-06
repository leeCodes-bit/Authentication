<?php
session_start();
    include("server.php");
    $db = connect();
    if(isset($_POST["login_user"])) {
        $errors = array();
         //when button is clicked register users
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

         // form validation
        if(empty($username)) {array_push($errors, "Username is required");}
        if(empty($password)) {array_push($errors, "Password is required");}

        // check db for user with existing username
        // $user_check_query = "SELECT * FROM user WHERE username = '$username' or email = '$email' LIMIT 1";
        // $results = mysqli_query($db, $user_check_query);
        // $user = mysqli_fetch_assoc($results);

        // if($user){

        //     if($user['username'] === $username){array_push($errors, "Username already exists");}
        //     if($user['email'] === $email){array_push($errors, "Email already exists");}
        // }
       
        
        // attempt login if there are no errors
        if(count($errors) == 0) {
            // to encrypt password before storing in the database
            $h_password = md5($password);
            // $query = "INSERT INTO user (username, email, password) VALUES('$username', '$email', '$password')" ;
            $query = "SELECT * FROM user WHERE username = '$username' AND password = '$h_password' LIMIT 1";            
            $res = mysqli_query($db, $query) or die(mysqli_error($db));
            $count = mysqli_num_rows($res);
            if($count > 0) {
                // user found 
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
    
                header('location: index.php');
            } else {
                // no user found
                array_push($errors, "Incorrect Username or Password");
            }           
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
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="nav">
        <header>
            <h1 class="logo"> <a href="index.php"> IGHUB</a></h1>
            <nav>
                <a href="#" class="hide-desktop"><i class="fa fa-2x fa-bars menu" id="menu" aria-hidden="true"></i></a>
    
                <ul class="show-desktop hide-mobile" id="nav">
                    <li id="exit" class="exit-btn hide-desktop"><i class="fa  fa-times" aria-hidden="true"></i></li>              
                    <li><a href="index.html"></a></li>
                    <li><a href="listing.html"></a></li>
                    <!-- <li><a href="#">Logout</a></li> -->
                    <!-- <li><a href="#">Login</a></li> -->
                </ul>
            </nav>
        </header>
    </div>
    <div class="container">      
           <form method="POST">
               <h3>Login to your account below</h3> 

               <?php include('error.php') ?>
               

               <div>
                   <input type="username" name="username" placeholder="username" required>
               </div>

               <div>
                <input type="password" name="password" placeholder="Password" required><br>
               </div>
               
               <div>
               <button type="submit" class="btn" name="login_user">Login</button>
               </div>
               
               <p>Not a user? <a href="registration.php"> Register here</a></p>
           </form>
    </div>
<script src="./js/main.js"></script>
</body>
</html>