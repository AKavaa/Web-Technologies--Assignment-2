<?php 
// starting the session
session_start();

// conecting to the the Database with my credentials
    $connect = mysqli_connect("localhost", "akavaleuskiy","rQZfTqyQDF", "akavaleuskiy");

    // fetching the offers from the DataBase
    $table_offers = mysqli_query($connect, "SELECT * FROM tbl_offers");

 ?>



<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Home</title>
        <link rel="stylesheet"  href="CSS/header.css">
        <link rel="stylesheet"  href="CSS/footer.css">
        <link rel="stylesheet"  href="CSS/main.css">
        <link rel="stylesheet"  href="CSS/styles.css">
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


    <div class="all-paragraphs">
      <span class="first-title">Where opportunity creates success</span>
      <span class="first-paragraph"
        >Every student at the university of Central Lancashire is automatically
        a member of the Students Union. <br />
        We're here to make the better for students - inspiring you to succeed
        and achieve your goals.</span
      >
      <span class="second-paragraph"
        >Everything you need to know about UCLan Students Union. Your membership
        starts here.</span
      >

            <div class="offersContainer">
   
<!-- The while loop iterates though the rows, so it checks all the offers in the DataBase-->
            <?php 
            while ($row = mysqli_fetch_assoc($table_offers)) {

                echo "<div class='indexOffers'>";
            
                // Here are some styles for the offers to be when displayed
                echo "<div style='font-size: 2rem; font-weight: lighter'>" . $row["offer_title"] . "</div>";
				echo "<br>";
                
        // output of the offer description 
                echo $row["offer_dec"] . "<br>";
                
                echo "</div><br>";
            }
            
            ?>
            </div>

        
            <div class="bottom">
        <span class="together">Together</span>
        <video class="video1" width="400" height="240" controls>
          <source src="video.mp4" type="video/mp4" />
        </video>
            <div class="framePart">
                <h1>Join our global community</h1>
                <iframe src="https://youtube.com/embed/EI_lco-qdw8"> </iframe>
            </div>
        </div>

    <div class="Footer">
      <div class="column">
        <span class="links">Links</span>
        <a
          class="studentunion"
          href="https://www.uclan.ac.uk/student-life/students-union"
          >Students Union</a
        >
      </div>
      <div class="column">
        <span class="links">Contact</span>
        <p>Email: suinformation@uclan.ac.uk</p>
        <p>Phone: 01772 89 3000</p>
      </div>
      <div class="column">
        <span class="location">Location</span>
        <p>University of Central Lancashire Students' Union,</p>
        <p>Fylde Road, Preston. PR1 7BY</p>
        <p>Registered in England</p>
        <p>Company Number: 7623917</p>
        <p>Registered Charity Number: 1142616</p>
      </div>
    </div>


    </body>

    </html>

