<?php
// Start the session to maintain user state
session_start();

// Database connection
$connect = mysqli_connect("localhost", "akavaleuskiy","rQZfTqyQDF", "akavaleuskiy");

// Initialize cart items array
$cartItems = [];

// Fetch cart items from database if they exist in session
if (isset($_SESSION['productIds']) && !empty($_SESSION['productIds'])) {
    $productIds = $_SESSION['productIds'];
    
    // Create SQL placeholders for prepared statement
    $placeholders = str_repeat('?,', count($productIds) - 1) . '?';
    $query = "SELECT * FROM tbl_products WHERE product_id IN ($placeholders)";
    
    // Prepare and execute the statement
    $stmt = mysqli_prepare($connect, $query);
    $types = str_repeat('i', count($productIds));
    mysqli_stmt_bind_param($stmt, $types, ...$productIds);
    mysqli_stmt_execute($stmt);
    
    // Fetch results
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
    }
    
    mysqli_stmt_close($stmt);
}



// Initialize or maintain cart state
$_SESSION['cart'] = isset($_SESSION['cart']) ? $_SESSION['cart'] : false;

// Handle POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle product updates
    if (isset($_POST['productIds'])) {
        $productIds = json_decode($_POST['productIds'], true);
        $_SESSION['productIds'] = $productIds;
    }
    
    // Handle user login
    if (isset($_POST['email_data']) && isset($_POST['pass'])) {
        handleLogin($connect);
    }
}

/**
 * Handle user login process
 * @param mysqli $connect Database connection
 */
function handleLogin($connect) {
        //  mysqli_real_escape_string it precents the email getting an SQL injection
    $email = mysqli_real_escape_string($connect, $_POST['email_data']);
    $password = $_POST['pass'];
    
        // checks if the email exists in the SQL DataBase
    $query = "SELECT * FROM tbl_users WHERE user_email = ?";
      
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
        // checks if the user exists
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
          // checks if the password which was entered matched the password stored in the DataBase
        if (password_verify($password, $user['user_pass'])) {
            // Set session variables
            $_SESSION['username'] = $user['user_full_name'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION["logged-in"] = true;
            $_SESSION["form-sent"] = true;
            
            // Redirecting to refresh page
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            echo '<script>alert("Incorrect password.");</script>';
            $_SESSION["form-sent"] = false;
        }
    } else {
        echo '<script>alert("No user found with this email address.");</script>';
    }
    
    mysqli_stmt_close($stmt);
}

// Handling cart clearing
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = false;
    $_SESSION['productIds'] = []; // Also clear the product IDs
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <link rel="stylesheet" href="CSS/cart.css">
</head>
<body>
    <header class="main-Header">
        <div class="main-Header-Logo">
            <img src="logo.svg" alt="UCLan Logo">
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

    <main>
        <div class="CartList">
            <h1>Shopping Cart</h1>
            <?php if (isset($_SESSION['username'])): ?>
                <div class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</div>
            <?php endif; ?>

            <!--if the cart is not empty it will retrieve the products from the Database-->
            <?php if (!empty($cartItems)): ?>
                <div class="cart-items">
                    <?php 
                    // initialiasing the price to be 0 and adds each products price together
                    $total = 0;
                    foreach ($cartItems as $item): 
                        $total += $item['product_price'];
                    ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_title']); ?>">
                            </div>
                            <div class="product-details">
                                <h2 class="product-title"><?php echo htmlspecialchars($item['product_title']); ?></h2>
                                <p class="product-description"><?php echo htmlspecialchars($item['product_desc']); ?></p>
                                <div class="product-price">€<?php echo number_format($item['product_price'], 2); ?></div>
                            </div>
                        </div>
                    <!--ending the foreach loop-->
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <p class="total-text">Total: €<?php echo number_format($total, 2); ?></p>
                </div>

                <div class="cart-actions">
                    <form method="POST" class="clear-cart-form">
                        <button type="submit" name="clear_cart" class="cart-button clear-cart">Clear Cart</button>
                    </form>

                    <?php if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']): ?>
                        <form method="POST" action="checkout.php" class="checkout-form">
                            <input type="hidden" name="productIds" value='<?php echo json_encode(array_column($cartItems, 'product_id')); ?>'>
                            <button type="submit" class="cart-button checkout">Proceed to Checkout</button>
                        </form>
                    <?php else: ?>
                        <div class="login-section">
                            <h2>Login to Checkout</h2>
                            <?php if (isset($error)): ?>
                                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>
                            <form method="POST" class="login-form">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email_data" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" id="password" name="pass" required>
                                </div>
                                <button type="submit" class="login-button">Login to Continue</button>
                            </form>
                            <p class="signup-text">Don't have an account? <a href="signup.php" class="signup-link">Sign up here</a></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <h2>Your cart is empty</h2>
                    <p>Browse our <a href="products.php">products</a> to add items to your cart.</p>
                </div>
            <?php endif; ?>
        </div>
  




    </body>

    </html>


	<script>
    document.addEventListener('DOMContentLoaded', function () {
            // it checks ifn the user is logged in and an alert pop up is displayed 
        <?php if(isset($_SESSION["form-sent"]) && $_SESSION["form-sent"] === true): ?>
            alert('Logged in successfully!');
            <?php unset($_SESSION["form-sent"]); ?>
        <?php endif; ?>
});

</script>
    <script src="JS/cart.js"></script>

