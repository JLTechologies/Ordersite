<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('', '', '', 'orders');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $firstname = mysqli_real_escape_string($db, $_POST['first_name']);
  $lastname = mysqli_real_escape_string($db, $_POST['last_name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $phone = mysqli_real_escape_string($db, $_POST['phone']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $groupid = '3';

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($firstname)) { array_push($errors, "First name is required"); }
  if (empty($lastname)) { array_push($erros, "Last name is required"); }
  if (empty($email)) { array_push($errors, "Phone number is required"); }
  if (empty($phone)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE first_name='$firstname' OR last_name='$lastname' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['email'] === $email) {
      array_push($errors, "Email is already used by another account.");
    }

    if ($user['first_name'] === $firstname && ['last_name'] === $lastname) {
      array_push($errors, "Person already exists.");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (first_name, last_name, email, password, phone, groupid) 
  			  VALUES('$firstname', '$lastname', '$email', '$password', '$phone', '$groupid')";
  	mysqli_query($db, $query);
  	$_SESSION['success'] = "You are now registered";
  	header('location: index.php');
  }
}

//

// LOGIN USER
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = password_hash($password);
        $query = "SELECT * FROM users WHERE email='$email' OR phone='$phone' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['email'] = $email || $phone;
          $_SESSION['success'] = "You are now logged in";
          header('location: index.php');
        }else {
            array_push($errors, "Wrong email or phone/password combination");
        }
    }
  }
  
  ?>