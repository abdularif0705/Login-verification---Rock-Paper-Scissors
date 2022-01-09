<?php // Do not put any HTML above this line

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php"); // php's way of redirecting to another page
    return;
}

$salt = 'XyZzy12*_';
//  The stored_hash is the MD5 of the salt concatenated with the plaintext of php123 - which is
//  the password. This hash is computed using the following PHP:
// $md5 = hash('md5', 'XyZzy12*_php123'); which equals the $stored_hash below
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['who']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1 ) {
        $failure = "User name and password are required";
    } else {
        // we reverse md5 hash of $salt+the user inputted password sent by $_POST
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) { // if they entered the correct password then...
            // Redirect the browser to game.php and append their username to url
            header("Location: game.php?name=".urlencode($_POST['who']));
            return;
        } else {
            $failure = "Incorrect password";
        }
    }
}

// Fall through into the View
?>
<!--<!DOCTYPE html>-->
<!--<html>-->
<head>
<?php require_once "bootstrap.php"; ?>
<title>Abdulrehman Arif's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n"); // htmlentities prevent html injection attacks
}
?>
<form method="POST">
<label for="name">User Name</label>
<input type="text" name="who" id="name"><br/>
<label for="id_2000">Password</label>
<input type="text" name="pass" id="id_2000"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the four character sound of the programming language of this page
 (all lower case) followed by 123. -->
</p>
</div>
</body>
