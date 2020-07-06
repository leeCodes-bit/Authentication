<?php

    function connect() {
        // connect to db
        $db = mysqli_connect('localhost', 'root', '', 'ighub-assignment') or die ('could not connect to db');
        return $db;
    }

?>


<?php





// check db for user with existing username
// $user_check_query = "SELECT * FROM * user WHERE username = '$username' or email = '$email' LIMIT 1";
// $results = mysqli_query($db, $user_check_query);
// $user = mysqli_fetch_assoc($results);

// if($user){

//     if($user['username'] === $username){array_push($errors, "Username already exists");}
//     if($user['email'] === $email){array_push($errors, "Email already exists");}
// }


?>