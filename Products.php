<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Products</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div>
      <div class="studentshop">Student Shop</div>
      <img class="uclanlogo" src="logo.svg" alt="Uclan Logo" />
    </div>

    <div class="home-header">
      <a href="Index.html">
        <span class="home">Home</span>
      </a>
      <a href="Products.html">
        <span class="products">Products</span>
      </a>
      <a href="Cart.html">
        <span class="cart">Cart</span>
      </a>
    </div>

    <div class="Products-tshirts-hoodies-jumpers">
      <div id="products">Products ></div>

      <a href="#" id="tshirtsLink">
        <div id="tshirts">T-Shirts</div>
      </a>

      <a href="#" id="hoodiesLink">
        <div id="hoodies">Hoodies</div>
      </a>

      <a href="#" id="jumpersLink">
        <div id="jumpers">Jumpers</div>
      </a>
    </div>

    <div id="productContainer" class="product-container"></div>

    <script src="Script.js"></script>

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

    <div class="home-header">
      <a href="Index.html" id="HomeLink">
        <span class="home">Home</span>
      </a>
      <a href="Products.html" id="productsLink">
        <span class="products">Products </span>
      </a>
      <a href="Cart.html">
        <span class="cart">Cart</span>
      </a>
      <div class="burger" onclick="toggleMenu()">&#9776;</div>
    </div>

    <div class="mobile-menu" id="mobileMenu">
      <a href="Index.html" class="mobile-link">Home</a>
      <a href="Products.html" class="mobile-link">Products</a>
      <a href="Cart.html" class="mobile-link">Cart</a>
    </div>
  </body>
</html>
