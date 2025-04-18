<?php

// starting a session
session_start();

// connecting to the DataBase with my credentials
$connect = mysqli_connect("localhost", "akavaleuskiy", "rQZfTqyQDF", "akavaleuskiy");

// If the user is already logged in, redirect them to the error page
if (isset($_SESSION["logged-in"]) && $_SESSION["logged-in"] == true) {
    exit();
}

// If the request method is POST, process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") { // ensures code runs when form is submited using POST
    $_SESSION["signup-form-sent"] = true; 
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $address = $_POST['address'];

//
    // Prepare a SQL query to check if the email already exists in the database
    $check_query = "SELECT * FROM tbl_users WHERE user_email = ?";
    $stmt = mysqli_prepare($connect, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $check_result = mysqli_stmt_get_result($stmt);
  
    // if email already exists it displays an alert pop up that such email already exists 
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script> alert('Such email already exists!') </script>";
		$_SESSION["signup-form-sent"] = false;
    } else {
        $query = "INSERT INTO tbl_users (user_full_name, user_email, user_pass, user_address) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password, $address);
        $result = mysqli_stmt_execute($stmt);
        // If the insertion was successful, redirect the user to the same page(in order to not send a form again during page reload)
        if ($result) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            $_SESSION["signup-form-sent"] = false;
        }
    }
}

?>




<!DOCTYPE html>
<html lang="en">

    <head>
        <title>SignUp Page</title>
        <link rel="stylesheet"  href="CSS/header.css">
        <link rel="stylesheet"  href="CSS/footer.css">
        <link rel="stylesheet"  href="CSS/main.css">
        <link rel="stylesheet"  href="CSS/styles.css">
        <link rel="stylesheet"  href="CSS/signup.css">
    </head>




    <header class="main-Header">
        <div class="main-Header-Logo">
            <img src="logo.svg" alt="UCLan logo">
            <div class="Students-nav">Students Shop</div>
        </div>

        <nav class="main-Header-nav">
            <ul class="LogoList">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">Cart</a></li>
                <!-- checks if the user is logged in, and ensures its actually true-->
                <?php if(isset($_SESSION["logged-in"]) && $_SESSION["logged-in"] == true) echo '<li><a href="logout.php">Logout</a></li>'; else echo '<li><a href="signup.php">Sign up</a></li>'; ?>
            </ul>
        </nav>
  
    </header>

    <form class="signUpPage" method="POST"  id="signupForm">
      <h1>Create Account</h1>
      <p class="textInfo">Welcome to the Student's Union shop! Please create an account to start shopping. All fields are required.</p>
      
      <div class="form-group">
        <label for="name">Full Name:</label>
        <input type="text" class="inputBar" id="name" name="full_name" required minlength="2" maxlength="50">
      </div>
      
      <div class="form-group">
        <label for="email">Email Address:</label>
        <input type="email" class="inputBar" id="email" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
      </div>

      <div class="form-group">
        <label for="address">Delivery Address:</label>
        <textarea class="inputBar" id="address" name="address" required minlength="10" rows="3"></textarea>
      </div>
      
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="inputBar" id="password" name="pass" required minlength="8">
        <p class="textInfo">Password must contain at least 8 characters with numbers, uppercase and lowercase letters</p>
      </div>

      <div class="passwordCriterias">
        <h2>Password Requirements:</h2>
        <div class="criterias">
          <p id="lowercase" class="requirement">A lowercase letter</p>
          <p id="uppercase" class="requirement">A capital letter</p>
          <p id="number" class="requirement">A number</p>
          <p id="length" class="requirement">Minimum 8 characters</p>
        </div>
      </div>
          <p id="number">✗ A number</p>
          <p id="length">✗ Minimum 8 characters</p>
        </div>
      </div>
      <p class="confirm-password">Confirm password:</p> <input type="password" class="inputBar" id="confirmPassword" name="confirm_pass" required>
      <p class="confirm-address">Address:</p> <input type="text" class="inputBar" id="address" name="address" required>
     <button class="buttonSubmit" id="buttonSubmit" type="submit">Confirm</button>
    </form>
  </main>
  <footer id="footer"></footer>
  
  <script>
    // checks if the signup was succesfull and after shows a alert message 
    document.addEventListener('DOMContentLoaded', function () {
      // checks if signup was succesfull 
        <?php if(isset($_SESSION["signup-form-sent"]) && $_SESSION["signup-form-sent"] === true): ?>
            alert('Signed up successfully!');
            //ensures that $_SESSION is removed and the alert pop up doesnt show up again
            <?php unset($_SESSION["signup-form-sent"]); ?>
        <?php endif; ?>
    });
</script>

<script src="JS/signup.js"></script>
