<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events Page</title>

  <link rel="stylesheet" href="{{ asset('web/main.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    /* Main Container */
    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 24px;
      padding: 24px;
      max-width: 70%;
      margin: auto;
    }

    .main-content {
      flex: 2;
      min-width: 400px;
      border-radius: 12px;
      overflow: hidden;
    }

    .sidebar {
      flex: 1;
      min-width: 300px;
    }

    /* --- STYLES FOR MAIN CONTENT --- */

    .main-content .header-image {
      width: 100%;
      height: auto;
      display: block;
    }

    .content-padding {
      padding: 10px;
    }

    .shop-info {
      display: flex;
      align-items: center;
      gap: 16px;
      border-bottom: 1px solid #eee;
      padding-bottom: 24px;
      margin-bottom: 24px;
    }

    .shop-info .logo {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
      border: 1px solid #eee;
    }

    .shop-info h1 {
      margin: 0;
      font-size: 1.8rem;
    }

    .shop-info p {
      margin: 4px 0 0;
      color: #777;
    }

    .shop-details h1 {
      color: black;
      font-size: 15px
    }

    .rating1 {
      margin-left: auto;
      color: #ffc107;
    }

    .section {
      margin-bottom: 24px;
    }

    .section h2 {
      font-size: 1.5rem;
      margin-top: 0;
      margin-bottom: 16px;
      color: #333;
      /* Darker heading */
    }

    .section p {
      line-height: 1.6;
      color: #555;
    }

    .location-map iframe {
      width: 100%;
      height: 300px;
      border-radius: 8px;
      border: 1px solid #ddd;
    }

    hr {
      border: 0;
      border-top: 1px solid #eee;
      margin: 10px 0;
    }

    /* dropdawon css */
    .dropdown {
      position: relative;
      display: inline-block;
      font-family: sans-serif;
    }

    .dropdown-btn {
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      border: none;
      background: transparent;
      outline: none;
      box-shadow: none;
      margin-left: -5px;
      color: #777;
      margin-top: 3px;
      cursor: pointer;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #ffffff;
      min-width: 200px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
      z-index: 1;
      margin-top: 5px;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .dropdown-content.show {
      display: block;
    }

    /* --- NEW STYLES FROM IMAGE --- */

    /* How to apply code */
    .apply-code-section ol {
      padding-left: 20px;
      color: #555;
    }

    .apply-code-section li {
      margin-bottom: 8px;
      line-height: 1.5;
    }

    .redeem-btn {
      background-color: #ff6b00;
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-top: 16px;
    }

    .redeem-btn:hover {
      background-color: #e65c00;
    }

    /* Rating & Review */
    .review-section .rating-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .rating-header h2 {
      margin: 0;
    }

    .rating-header i {
      font-size: 1.2rem;
      cursor: pointer;
    }

    .review-form .score-input .fa-star {
      font-size: 1.8rem;
      color: #ccc;
      margin-right: 5px;
      cursor: pointer;
    }

    .review-form .score-input .fa-star.active {
      color: #ffc107;
    }

    .review-form textarea {
      width: 80%;
      height: 50px;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 12px;
      font-family: inherit;
      resize: vertical;
    }

    .review-form {
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .review-form .post-btn {
      background-color: #34495e;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      align-self: flex-end;
      margin-top: -6%;
      align-items: center
    }

    .review-form .post-btn:hover {
      background-color: #2c3e50;
    }

    .more-reviews-title {
      font-weight: bold;
      color: #333;
      border-top: 1px solid #eee;
      padding-top: 24px;
    }

    .review-card {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .review-card img {
      width: 48px;
      height: 48px;
      border-radius: 50%;
    }

    .review-content .user-name {
      font-weight: bold;
      margin: 0;
    }

    .review-content .stars {
      color: #ffc107;
      margin: 5px 0;
    }

    .review-content .review-text {
      color: #555;
      font-size: 0.95rem;
      line-height: 1.6;
      margin: 0;
    }

    /* --- STYLES FOR SIDEBAR --- */
    .sidebar {
      width: 200px;
      padding: 15px;
      border-radius: 8px;
    }

    .sidebar h3 {
      font-size: 0.9rem;
      text-align: center;
      background-color: #fff1e6;
      border: 1px dashed #ff994d;
      border-radius: 6px;
      padding: 8px;
      color: #ff6d00;
      margin: 0 0 16px 0;
    }

    .coupon-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      margin-bottom: 16px;
      overflow: hidden;
      border: 1px solid #eee;
    }

    .coupon-image-wrapper {
      position: relative;
    }

    .coupon-card img {
      width: 100%;
      display: block;
    }

    .discount-badge {
      position: absolute;
      right: -5px;
      background-color: #d32f2f;
      color: white;
      padding: 4px 12px;
      font-size: 0.8rem;
      font-weight: bold;
      clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%, 5% 50%);
    }

    .wishlist-icon {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: rgba(255, 255, 255, 0.8);
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #555;
      font-size: 1rem;
    }

    .coupon-details {
      padding: 12px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .coupon-details p {
      margin: 0;
      font-size: 0.9rem;
      font-weight: 500;
      color: black
    }

    .coupon-rating {
      background-color: #263238;
      color: white;
      padding: 4px 8px;
      border-radius: 6px;
      font-size: 0.8rem;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .top-offer-text {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      padding: 10px 0;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 100%);
      color: white;
      text-align: center;
      font-size: 1.1rem;
      font-weight: bold;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .price-text {
      font-size: 3em;
      color: white;
      line-height: 0.8;
      margin-top: 5px;
    }
/* ------------------------------------------- */
 /* Main container for the coupon section */
        .coupon-container {
            text-align: center;
            padding: 0 30px;
        }

        /* Title styling */
        .coupon-title {
            color: #F57C00; 
            font-size: 17px;
            font-weight: 600;
            margin: 0 0 30px 0;
            text-align: start
        }

        /* User profile section */
        .user-profile {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%; 
            margin-right: 15px;
            object-fit: cover;
        }

        .user-name {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        /* QR Code wrapper */
        .qr-code-wrapper {
            margin-bottom: 25px;
        }

        .qr-code {
            max-width: 200px;
            height: auto;
            margin: auto;
        }
        
        /* Coupon code box */
        .coupon-code-box {
            background-color: #2C3E50; 
            border-radius: 8px;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            min-width: 180px;
            margin-bottom: 40px;
        }

        .coupon-code {
            color: #ECF0F1;
            font-family: 'SF Mono', 'Courier New', Courier, monospace;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .copy-button {
  background: none;
  cursor: pointer;
  padding: 5px 10px;
  margin-left: 15px;
  display: flex;
  align-items: center;
  border-radius: 6px;       
}

        .copy-button svg {
            fill: #ECF0F1;
        }

        /* Button container */
        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px; 
        }
        
        /* General button styles */
        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid transparent;
            transition: background-color 0.2s, color 0.2s;
        }
        
        /* Secondary button ("Back to home") */
        .btn-secondary {
            background-color: #fff;
            color: #555;
            border-color: #ccc;
        }

        .btn-secondary:hover {
            background-color: #f8f8f8;
        }

        /* Primary button ("Continue Shopping") */
        .btn-primary {
            background-color: #F57C00;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #E67E22; 
        }

    @media (max-width: 425px) {
      .container {
        flex-direction: column;
        padding: 16px;
      }
    }
  </style>
</head>

<body>
  <section class="breadcrumb-section">
    <div class="breadcrumb-container">
      <span class="breadcrumb-home">HOME /</span>
      <span class="breadcrumb-current">ABOUT BRAND</span>
    </div>
  </section>
  <!-- -------------------------------------------------------------------------------------- -->
  <div class="container">
    <main class="main-content">
      <img src="{{ asset('images/cake.png') }}" alt="Chocolate drip cake" class="header-image">

      <div class="content-padding">
        <section class="shop-info">
          <img src="{{ asset('images/hous.png') }}" alt="Cake House Logo" class="logo">
          <div class="shop-details">
            <h1>Cake House</h1>
            <div class="dropdown">
              <button class="dropdown-btn">
                <i class="fa-solid fa-location-dot"></i>
                <span>Amroli, 394107</span>
                <i class="fa-solid fa-caret-down"></i>
              </button>

              <div class="dropdown-content">
                <a href="#">Katargam, 395004</a>
                <a href="#">Adajan, 395009</a>
                <a href="#">Vesu, 395007</a>
                <a href="#">Piplod, 395007</a>
              </div>
            </div>
          </div>
          <div class="rating1">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
          </div>
        </section>


        <section class="section">
          <h2>About Us</h2>
          <p>At The Cake House, we believe every celebration deserves something sweet and unforgettable. From classic
            flavors to modern creations, our cakes are baked with love, premium ingredients, and a touch of creativity.
          </p>
        </section>

        <hr>

        <section class="section">
          <h2>Location</h2>
          <p>Plot No, 24b, Near Crystal Lake Road, Opp. Green Valley Park, Sector 12-B, Golden City, Amroli - 3954107,
            INDIA</p>
          <div class="location-map">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.84543952857!2d72.8054920746946!3d21.17024068137764!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e594ad8a6a1%3A0x7a441c0c4e76fd2f!2sSurat%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1726491350769!5m2!1sen!2sin"
              allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </section>

        <div style="display: flex; justify-content: center; align-items: center;">
          <button style=" 
    color: rgba(255, 107, 0, 1); 
    border: 1px solid rgba(255, 107, 0, 1);
    padding: 10px 25px; 
    font-size: 16px; 
    font-weight: 500; 
    border-radius: 8px; 
    cursor: pointer;
    background: none">
            View More Details
          </button>
        </div>

        <hr>

        <section class="section apply-code-section">
          <h2>How to apply code</h2>
          <ol>
            <li>Click On Apply Now Button, It Will Generate Code</li>
            <li>Show This Generate Code At Store Location Or Click To Use Deal Button And Ask Business Code To Store,
              And Click On OK Button</li>
            <li>Enjoy Your Discount</li>
          </ol>
          <button class="redeem-btn show-coupon-btn">
            <i class="fa-solid fa-tags"></i>
            Redeem Now
          </button>
        </section>
        <hr>

        <section class="section review-section">
          <div class="rating-header">
            <h2>Rating & Review</h2>
            <i class="fa-solid fa-chevron-down" style="color: #555"></i>
          </div>
          <div class="review-form">
            <label>Score:</label>
            <div class="score-input">
              <i class="fa-solid fa-star active"></i>
              <i class="fa-regular fa-star"></i>
              <i class="fa-regular fa-star"></i>
              <i class="fa-regular fa-star"></i>
              <i class="fa-regular fa-star"></i>
            </div>
            <label for="reviewText" style="display:block; margin-top:16px;">Review:</label>
            <textarea id="reviewText" placeholder="Write your review here..."></textarea>
            <button class="post-btn">Post</button>
          </div>
          <div class="more-reviews">
            <p class="more-reviews-title">More Review</p>

            <div class="review-card">
              <img src="https://i.pravatar.cc/48?u=kristin" alt="Kristin Watson">
              <div class="review-content">
                <div style="display: flex; justify-content: space-between">
                  <p class="user-name">Kristin Watson</p>
                  <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                  </div>
                </div>
                <p class="review-text">I Recently Purchased Clothes From Here And I'm Really Impressed With The Quality.
                  The Fabric Feels Soft And Comfortable, The Stitching Is Neat, And The Fit Is Exactly As Described. </p>
              </div><
            </div>

            <div class="review-card">
              <img src="https://i.pravatar.cc/48?u=kristin2" alt="Kristin Watson">
              <div class="review-content">
                <div style="display: flex; justify-content: space-between">
                <p class="user-name">Kristin Watson</p>
                <div class="stars">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                </div>
  </div>
                <p class="review-text">I Recently Purchased Clothes From Here And I'm Really Impressed With The Quality.
                  The Fabric Feels Soft And Comfortable, The Stitching Is Neat, And The Fit Is Exactly As Described.</p>
              </div>
            </div>

          </div>
        </section>

        

<!-- QR CODE SCANER SECTION -->
<div class="coupon-container" style="display:none;">
        <h1 class="coupon-title">Flat 50% Discount Coupon</h1>

        <div class="user-profile">
            <img src="{{ asset('images/prof.png') }}" alt="User Avatar" class="user-avatar">
            <span class="user-name">Lloyd Hayenes</span>
        </div>

        <div class="qr-code-wrapper">
            <img src="{{ asset('images/qr.png') }}" alt="QR Code" class="qr-code">
        </div>

        <div class="coupon-code-box">
            <span class="coupon-code">GYU9R7F3</span>
            <button class="copy-button" title="Copy code">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zM-1 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                    <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                    <path d="M4.5 0A1.5 1.5 0 0 0 3 1.5v1A1.5 1.5 0 0 0 4.5 4h7A1.5 1.5 0 0 0 13 2.5v-1A1.5 1.5 0 0 0 11.5 0h-7zM4 1.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1z"/>
                </svg>
            </button>
        </div>

        <div class="button-group">
            <button class="btn btn-secondary">Back to home</button>
            <button class="btn btn-primary">Continue Shopping</button>
        </div>
    </div>
   <!-- --------------------------------------------------------------------------------------- -->
      </div>
    </main>
<!-- ---------------------------------------------------------------------------------------------- -->

 <!-- Right Side Sections -->
    <aside class="sidebar">
      <div class='brand1' style="display: flex; justify-content: center; align-items: center; margin-bottom: 3%">
        <img src="{{ asset('images/heading13.png') }}" alt="Summer fashion" style="width: auto; height: 40px;" />
      </div>

      <div class="coupon-card">
        <div class="coupon-image-wrapper">
          <img src="{{ asset('images/food.png') }}" alt="Pizza offer">
          <div class="top-offer-text">
          </div>
          <div class="discount-badge">-50% OFF</div>
          <div class="wishlist-icon"><i class="fa-regular fa-heart"></i></div>
        </div>
        <div class="coupon-details">
          <p>Flat ₹200 OFF on Buy Above ₹999</p>
          <div class="coupon-rating">4.5 <i class="fa-solid fa-star fa-xs"></i></div>
        </div>
      </div>

      <div class="coupon-card">
        <div class="coupon-image-wrapper">
          <img src="{{ asset('images/food1.png') }}" alt="Pizza offer with code">
          <div class="discount-badge">-50% OFF</div>
          <div class="wishlist-icon"><i class="fa-regular fa-heart"></i></div>
        </div>
        <div class="coupon-details">
          <p>Flat ₹200 OFF on Buy Above ₹999</p>
          <div class="coupon-rating">4.0 <i class="fa-solid fa-star fa-xs"></i></div>
        </div>
      </div>

      <div class="coupon-card">
        <div class="coupon-image-wrapper">
          <img src="{{ asset('images/food2.png') }}" alt="Crazy offers">
          <div class="discount-badge">-50% OFF</div>
          <div class="wishlist-icon"><i class="fa-regular fa-heart"></i></div>
        </div>
        <div class="coupon-details">
          <p>Flat ₹200 OFF on Buy Above ₹999</p>
          <div class="coupon-rating">4.0 <i class="fa-solid fa-star fa-xs"></i></div>
        </div>
      </div>

      <div class="coupon-card">
        <div class="coupon-image-wrapper">
          <img src="{{ asset('images/food3.png') }}" alt="Pizza offer">
          <div class="discount-badge">-50% OFF</div>
          <div class="wishlist-icon"><i class="fa-regular fa-heart"></i></div>
        </div>
        <div class="coupon-details">
          <p>Flat ₹200 OFF on Buy Above ₹999</p>
          <div class="coupon-rating">4.0 <i class="fa-solid fa-star fa-xs"></i></div>
        </div>
      </div>

      <div class="coupon-card">
        <div class="coupon-image-wrapper">
          <img src="{{ asset('images/food.png') }}" alt="Pizza offer">
          <div class="discount-badge">-50% OFF</div>
          <div class="wishlist-icon"><i class="fa-regular fa-heart"></i></div>
        </div>
        <div class="coupon-details">
          <p>Flat ₹200 OFF on Buy Above ₹999</p>
          <div class="coupon-rating">4.0 <i class="fa-solid fa-star fa-xs"></i></div>
        </div>
      </div>

      <div class="coupon-card">
        <div class="coupon-image-wrapper">
          <img src="{{ asset('images/food2.png') }}" alt="Pizza offer">
          <div class="discount-badge">-50% OFF</div>
          <div class="wishlist-icon"><i class="fa-regular fa-heart"></i></div>
        </div>
        <div class="coupon-details">
          <p>Flat ₹200 OFF on Buy Above ₹999</p>
          <div class="coupon-rating">4.0 <i class="fa-solid fa-star fa-xs"></i></div>
        </div>
      </div>
    </aside>
  </div>
  <!-- --------------------------------------------------------------------------------------- -->

  <!-- SCRIPT SECTIONS -->
<script>
    $(function () {
      // Dropdown toggle
      $('.dropdown-btn').click(function (e) {
        e.stopPropagation();
        $('.dropdown-content').toggleClass('show');
      });
    });
</script>

<script>
 $(document).ready(function(){

    $('.show-coupon-btn').on('click', function() {
      $('section, hr, button')
        .not('.shop-info, .shop-info *, .button-group, .button-group *, .copy-button, .copy-button *')
        .hide();

      $('.coupon-container').fadeIn(400);
      $('html, body').animate({ scrollTop: 0 }, 'fast');
    });

    $('.back-btn').on('click', function() {
      $('.coupon-container').hide();
      $('section, hr, button').show();
    });

  });
</script>

</body>

</html>


