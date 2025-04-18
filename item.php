<?php

// starting the session 
session_start();

// conecting to the the Database with my credentials
$connect = mysqli_connect("localhost", "akavaleuskiy", "rQZfTqyQDF", "akavaleuskiy");

// the line of code retreives the product ID form the URL using the GET method
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

//Fetching the product details
$query = "SELECT * FROM tbl_products WHERE product_id = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, 'i', $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

// Handle add to cart action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $_SESSION['cart'] = true;
}

?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Item Page</title>
        <link rel="stylesheet"  href="CSS/header.css">
        <link rel="stylesheet"  href="CSS/footer.css">
        <link rel="stylesheet"  href="CSS/main.css">
        <link rel="stylesheet"  href="CSS/styles.css">
        <link rel="stylesheet"  href="CSS/item.css">
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
                <?php if(isset($_SESSION["logged-in"]) && $_SESSION["logged-in"] == true) echo '<li><a href="logout.php">Logout</a></li>'; else echo '<li><a href="signup.php">Sign up</a></li>'; ?>
            </ul>
        </nav>
  
    </header>


<!--There is a use of htmlspecialchars for preventing any external attack-->>
    <div class="product-detail">
        <!-- Here the code is dynamically displaying the details of the products-->
        <?php if ($product): ?> <!-- checks if the product exists before displaying it-->
            <div class="product-container">
                <div class="product-image">
                    <img src="<?php echo htmlspecialchars($product['product_image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['product_title']); ?>">
                </div>
                <div class="product-info">
                    <h1><?php echo htmlspecialchars($product['product_title']); ?></h1>
                    <div class="product-price">€<?php echo number_format($product['product_price'], 2); ?></div>
                    <div class="product-description">
                        <?php echo nl2br(htmlspecialchars($product['product_desc'])); ?>
                    </div>
                    <form method="POST" class="add-to-cart-form">
                        <input type="hidden" name="add_to_cart" value="<?php echo $product['product_id']; ?>">
                        <button type="submit" class="add-to-cart-button">Add to Cart</button>
                    </form>
                    <a href="products.php" class="back-button">Back to Products</a>
                </div>
        </div>
            </div>
        <?php endif; ?>
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

