<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- This is the home page of the website-->
    <title>Home</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div>
      <div class="studentshop">Student Shop</div>
      <img class="uclanlogo" src="logo.svg" alt="Uclan Logo" />
    </div>

    <!-- Here is the header which is the same in every page of the website-->

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
      <div class="bottom">
        <span class="together">Together</span>
        <video class="video1" width="400" height="240" controls>
          <source src="video.mp4" type="video/mp4" />
        </video>
      </div>
      <span class="second-title"> Join our global community</span>
      <div class="video2">
        <!-- Here im adding the second video with Iframe and the link which is provided-->
        <iframe
          width="400"
          height="240"
          src="https://www.youtube.com/embed/EI_lco-qdw8?si=nU2Z4_myX3WGaaDh"
          title="YouTube video player"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          referrerpolicy="strict-origin-when-cross-origin"
          allowfullscreen
        ></iframe>
      </div>
    </div>

    <div id="cartItems" class="cart-items"></div>

    <!--Here is the footer and the link about the student union was coppied from the uclan website, this footer is the same in every page -->

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

    <!--Here is the code for the burger menu which is the same in every page of the website-->
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
    <script src="Script.js"></script>
  </body>
</html>
