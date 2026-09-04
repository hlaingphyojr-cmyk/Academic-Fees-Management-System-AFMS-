<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link rel="stylesheet" href="assets/font-awesome/css/all.min.css">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="style.css" />
    <title>Academic Fees Management System</title>
  </head>
  <body class="container">
    <!--Navbar-->
    <nav class="navbar">
      <div class="navbar__flex">
        <!-- Logo -->
        <!-- <img src="./logo.png" alt="" width="100px" /> -->
        AFMS
        <!-- HyperLinks -->
        <div class="hyper_links">
          <a href="#home" class="hyper-link active">Home</a
          ><a href="about.php" class="hyper-link">About Us</a
          ><a href="login.php" class="hyper-link">Admin Login</a
          ><a href="login1.php" class="hyper-link">Student Login</a>
        </div>
      </div>
    </nav>
    <hr />
    <!-- Hero Section -->
    <section class="hero">
      <div class="hero_centered">
        <!-- left section -->
        <div class="hero_left">
          <h2 class="hero_title">Academic Fees Management System</h2>
          <p class="hero_description">
          An academic fees management system is a software tool designed to streamline 
          the process of managing fees related to academic institutions. It typically 
          includes features such as student fee payment tracking, invoicing, fee structure 
          management, financial reporting, and integration with other academic systems like 
          student information systems. This system aims to automate and simplify fee-related 
          tasks for both administrators and students, enhancing efficiency and accuracy in fee 
          management processes.
          </p>
          <a id="btn" href="about.php"></a>
          <a href="about.php">
          <button class="custom-btn btn-3" id="btn">
          <span>About Us</span>
          </button>
          </a>
        </div>
        <!-- right section -->
        <div>
          <img
            src="./hero.jpg"
            alt="Hero Section Photo"
            width="400px"
            height="400px"
          />
        </div>
      </div>
    </section>
    <!-- Features Section -->
    <section class="features">
      <h2>Features</h2>
      <!-- 1st row -->
      <div class="feature_card_row">
        <div class="feature_card">
          <h3 class="feature_title">Fee Structure Management</h3>
          <p>
           Set up and manage various fee structures, 
          including academic fees, examination fees, hostel fees, etc., according 
          to the institution's policies.
          </p>
        </div>
        <div class="feature_card">
        <h3 class="feature_title">Fee Receipt Generation</h3>
          <p>
           Automatically generate  receipts to 
          students upon successful fee payment, including details such as  amount paid, 
          date of payment and remarks.
          </p>
        </div>
      </div>
      <!-- 2nd row -->
      <div class="feature_card_row">
        <div class="feature_card">
        <h3 class="feature_title">Payment Tracking</h3>
          <p>
           Track fee payments in real-time,
          providing administrators with visibility into payment statuses and histories.
                                                                  

          </p>
        </div>
        <div class="feature_card">
          <h3 class="feature_title">User-friendly Interface</h3>
          <p>
           Offers a user-friendly interface for easy navigation,
           fee payment, and management for students and administrators.
          </p>
        </div>
      </div>
    </section>
    <!-- Contact Us -->
    <section class="contact_us_container">
      <div class="contact_us">
        <h2>Contact Us</h2>
        <p class="contact_us_description">
        Thank you for visiting [AFMS]! We value your feedback, questions, and any other inquiries 
        you may have. Our dedicated team is here to assist you and ensure you have the best experience 
        with our services. Feel free to reach out to us using the contact details provided below:
        </p>
        <br><br>
        <p>Our support team is available [Monday to Friday, 9:00 AM to 4:00 PM (MMT)].
             We strive to respond to all inquiries within 24 hours.
        </p>
        <!-- <button class="custom-btn btn-3 contact-btn">
          <span>Contact</span>
        </button> -->
      </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
      <div class="footer-flex">
        <!--  -->
        <div class="footer-element">
          <img src="./email.png" width="30px" height="30px" />
          <p>Email: <br>admin@ucsm.edu.mm</p>
        </div>
        <div class="footer-element">
          <img src="./phone-call.png" width="30px" height="30px" />
          <p>Phone: <br>+959987654321</p>
        </div>
        <div class="footer-element">
          <img src="./uni.png" width="30px" height="30px" />
          <p>Address:<br>
            University Of Computer Studies,Mandalay
          </p>
        </p>
        </div>
      </div>
      <p>&copy;2024 Academic Fees Management System</p>
    </footer>
  </body>
</html>
