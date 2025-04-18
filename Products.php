<?php 
// starting a session 
session_start();

// connecting to the DataBase with my credentials
    $connect = mysqli_connect("localhost", "akavaleuskiy","rQZfTqyQDF", "akavaleuskiy");

    // retrieving all the products from the DataBase
    $result = mysqli_query($connect, "SELECT * FROM tbl_products");

// Handle adding products to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $productId = $_POST['add_to_cart'];
    
    // Initialize the productIds array if it doesn't exist
    if (!isset($_SESSION['productIds'])) {
        $_SESSION['productIds'] = array();
    }
    
    // Add the product ID to the session if it's not already there
    if (!in_array($productId, $_SESSION['productIds'])) {
        $_SESSION['productIds'][] = $productId;
    }
    
    $_SESSION['cart'] = true;
    
    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Products</title>
	<link rel="stylesheet" href="CSS/header.css">
	<link rel="stylesheet" href="CSS/footer.css">
	<link rel="stylesheet" href="CSS/products.css">
	<link rel="stylesheet" href="CSS/styles.css">

<body>
	<header class="main-Header">
        <div class="main-Header-Logo">
            <img src="logo.svg" alt="UCLan logo">
            <div class="Students-nav">Student Shop</div>
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


		<div class="productsPage">
			<div class="productsList">
				<div class="searchList">
					<input class="searchInput" id="input" />
  <!--Search the specific products by their name-->
					<button class="searchButton" id="ButtonSearch">Search</button>
				</div>
				<span class="productsWord"></span>
  <!--Each a represents a product category which when pressed navigates the user to the pressed category-->
				<a class="list" data-category="UCLan Logo Tshirt" href="#t-shirts">T-shirts</a>
                <a class="list" data-category="UCLan Hoodie" href="#hoodies">Hoodies</a>
                <a class="list" data-category="UCLan Logo Jumper" href="#jumpers">Jumpers</a>
                <a class="list" data-category="all" href="#all">All</a>
			</div>

			<div class='container'>
			
			
<!-- A while loop which is fetching each row from the results variable, which is coming from the given DataBase -->

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <div class='item' data-category='<?php echo $row["product_type"]; ?>'>  
        <img src='<?php echo $row["product_image"]; ?>' alt='Product Image'> <!-- displaying the images of the products using the product_image from the Database-->

        <h2><?php echo $row["product_title"]; ?></h2>
        <p class='price'>€<?php echo $row["product_price"]; ?></p>
        <div class='description'><?php echo $row["product_desc"]; ?></div>
        <form method="POST" action="">
            <input type="hidden" name="add_to_cart" value="<?php echo $row["product_id"]; ?>">
<!--Here the row is converted to a json string which is easier to input afterwards-->
            <button type="submit" class='add-to-cart buttonBuy' data-product='<?php echo htmlspecialchars(json_encode($row)); ?>'>Add to Cart</button>
			<a class='read-more' href='item.php?id=<?php echo $row["product_id"]; ?>'>Read more</a>
        </form>
    </div>
<?php } ?>


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

<script src="JS/products.js"></script>