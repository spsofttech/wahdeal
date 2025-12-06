<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ras Ramzat 2025</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('web/main.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    h1{
      margin-top: 0;
      color: #000;
    }

h2, h3 {
  color: #555
}

    img {
      max-width: 100%;
      height: auto;
      display: block;
    }

    /* --- Main Layout Container --- */
    .event-container {
      max-width: 1200px;
      margin: 3% auto;
      display: flex;
      gap: 30px;
    }

    .event-main {
      flex: 2;
    }

    .event-sidebar {
      flex: 1;
    }

    /* --- Event Banner --- */
    .event-banner img {
      border-radius: 12px;
      width: 100%;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* --- Event Header --- */
    .event-header {
      margin-top: 20px;
    }

    .title-wrapper {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .title-wrapper h1 {
      font-size: 1.3em;
      margin: 0;
    }

    .share-btn {
      background-color: #ff6f61;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .share-btn:hover {
      background-color: #e65a50;
    }

    .event-meta {
      font-size: 1em;
      color: #555;
      margin: 5px 0;
    }

    /* --- Assistance Box --- */
    .assistance-box {
      background-color: #343a40;
      color: white;
      padding: 20px;
      border-radius: 8px;
      margin: 25px 0;
    }

    .assistance-box p {
      margin: 0;
    }

    .assistance-box .phone-number {
      font-weight: 700;
      font-size: 1.1em;
      margin-top: 5px;
    }

    /* --- Event Info Section --- */
    .event-info h2 {
      border-bottom: 2px solid #eee;
      padding-bottom: 10px;
      margin-bottom: 15px;
    }

    .event-info p {
      line-height: 1.6;
      color: black
    }

    /* --- Sidebar Widgets --- */
    .passes-container {
      display: flex;
      gap: 15px;
      overflow-x: auto;
      overflow-y: hidden;
      width: 100%;
      max-width: 500px;
      white-space: nowrap;
      scroll-behavior: smooth;
      padding-bottom: 10px;
    }

    .passes-container::-webkit-scrollbar {
      height: 8px;
    }

    .passes-container::-webkit-scrollbar-thumb {
      background: #ccc;
      border-radius: 10px;
    }

    .passes-container::-webkit-scrollbar-track {
      background: transparent;
    }

    /* Pass Card Styling */
    .pass-card {
      flex: 0 0 auto;
      min-width: 140px;
      max-width: 160px;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px 10px;
      text-align: center;
      background: white;
      box-sizing: border-box;
      word-wrap: break-word;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /* Active Card Highlight */
    .pass-card.active {
      border-color: #ff6f61;
      background-color: #fff8f7;
    }

    /* Card Text Styling */
    .pass-card h3,
    .pass-card p {
      margin: 0 0 8px 0;
      color: black;
      font-size: 0.95rem;
      line-height: 1.3;
      white-space: normal;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .pass-card .price {
      font-weight: 700;
      color: #ff6f61;
      font-size: 1.2em;
      margin-bottom: 10px;
    }

    /* Quantity Selector */
    .quantity-selector {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      color: black;
    }

    .quantity-selector button {
      border: 1px solid #ccc;
      background-color: #f5f5f5;
      width: 30px;
      height: 30px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1.2em;
      line-height: 1;
      transition: background-color 0.3s ease;
    }

    .quantity-selector button:hover {
      background-color: #e0e0e0;
    }

    /* --- Celebrities Widget --- */
    .celebrities-container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
    }

    .celebrity-card {
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .celebrity-card img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      display: block;
    }

    .celebrity-card p {
      margin-top: 5px;
      margin-bottom: 0;
      font-size: 0.8em;
      color: black;
    }


    /* --- Organizer & Venue Widgets --- */
    .organizer-container,
    .venue-container {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .organizer-container img {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      object-fit: cover;
    }

    .organizer-container p {
      color: black;
    }

    .venue-container img {
      width: 100%;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .venue-container {
      flex-direction: column;
      align-items: flex-start;
    }

    .venue-container p {
      font-size: 0.9em;
      line-height: 1.5;
      color: black
    }

    /* Attendee Info */
    /* Event Passes */
    .event-passes {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .pass-card1 {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      background: #f9f9f9;
    }

    .pass-info {
      display: flex;
      flex-direction: column;
    }

    .pass-info strong {
      font-size: 14px;
      font-weight: bold;
      color: #000;
    }

    .pass-info span {
      font-size: 12px;
      color: #555;
      margin-top: 4px;
    }

    .pass-actions {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .pass-price {
      color: #ff5500;
      font-weight: bold;
      font-size: 14px;
    }

    .quantity-selector {
      display: flex;
      align-items: center;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .quantity-selector button {
      background: none;
      border: none;
      padding: 6px 10px;
      font-size: 14px;
      cursor: pointer;
    }

    .quantity-selector span {
      padding: 0 8px;
      font-size: 14px;
    }

    /* Attendee Info */
    .attendee-info {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-top: 10px;
    }

    .attendee-info input {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      width: 100%;
      box-sizing: border-box;
    }

    /* Bill Details */
    .bill-details {
      margin-top: 15px;
    }

    .bill-item {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 10px 0;
      border-bottom: 1px solid #eee;
    }

    .bill-item strong {
      display: block;
      font-size: 14px;
      color: #000;
    }

    .bill-item span {
      font-size: 12px;
      color: #888;
    }

    .bill-item p {
      margin: 2px 0 0;
      font-size: 12px;
      color: #666;
    }

    .bill-price {
      font-size: 14px;
      color: #000;
      font-weight: bold;
    }

    .bill-total {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      font-weight: bold;
      color: #ff5500;
      font-size: 16px;
      border-top: 1px solid #eee;
    }

    /* Bottom Buttons */
    .bottom-buttons {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-top: 20px;
    }

    .bottom-buttons .add-ticket {
      flex: 1;
      padding: 10px;
      border: 1px solid #000;
      border-radius: 6px;
      background: #fff;
      font-size: 14px;
      cursor: pointer;
    }

    .bottom-buttons .checkout {
      flex: 1;
      padding: 10px;
      border: none;
      border-radius: 6px;
      background: #ff5500;
      color: #fff;
      font-size: 14px;
      cursor: pointer;
    }

    .event-title{
      font-size: 1rem;
      color: #000;
      margin-top: 5px;
    }

    /* --- Responsive Design (for tablets and mobile) --- */
    @media (max-width: 992px) {
      .celebrities-container {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    @media (max-width: 768px) {
      .event-container {
        flex-direction: column;
      }

      .title-wrapper {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }

      .title-wrapper h1 {
        font-size: 1.2em;
      }

      .passes-container {
        justify-content: flex-start;
      }

      .celebrities-container {
        grid-template-columns: repeat(2, 1fr);
      }

      .event-header, .event-info {
        padding: 15px
      }

      .assistance-box {
      margin: 15px;
    }
    }

    @media (max-width: 540px) {
      .events-grid {
        grid-template-columns: 1fr;
        gap: 16px;
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
  <!-- ------------------------------------------------------------------------------------------------- -->

  <div class="event-container">
    <main class="event-main">
      <header class="event-banner">
        <img src="{{ asset('images/evn.png') }}" alt="Navratri Dandiya Nights Banner">
      </header>

      <section class="event-header">
        <div class="title-wrapper">
          <h1>Ras Ramzat 2025</h1>
          <button class="share-btn">🔗 Share</button>
        </div>
        <p class="event-meta">📍 Ras Garba Ground, Vadodara - 390005</p>
        <p class="event-meta">📅 22 Sep - 01 Oct 2025, Saturday @ 10:00 PM</p>
      </section>

      <section class="assistance-box">
        <p>Need Assistance or do you have any query?</p>
        <p class="phone-number">📞 +91 12345 67890</p>
      </section>

      <section class="event-info">
        <h2>Event Information</h2>
        <p>
          The Navratri Mahotsav 2025 is a grand celebration of devotion, music, and dance where tradition meets
          festivity. For nine vibrant nights, the ground will echo with the rhythmic beats of the dhol and the soulful
          tunes of live singers, bringing people together to celebrate the divine energy of Goddess Durga.
        </p>
        <p>
          From traditional Garba and Raas to the high-energy Dandiya nights, this event offers a perfect blend of
          culture and entertainment. With colorful decorations, delicious food stalls, selfie corners, competitions, and
          exciting prizes, it's more than just an event—it's an unforgettable experience of joy, togetherness, and
          celebration.
        </p>
      </section>
    </main>
    <!-- ------------------------------------------------------------------------------------------------------- -->

    <aside class="event-sidebar">
      <section class="sidebar-widget">
        <h2>Event Passes</h2>
        <div class="passes-container">
          <div class="pass-card">
            <h3>Day 1</h3>
            <p>22 Sep 2025, Saturday @ 10:00 PM</p>
            <p class="price">₹ 250</p>
            <div class="quantity-selector">
              <button>-</button>
              <span>1</span>
              <button>+</button>
            </div>
          </div>

          <div class="pass-card active">
            <h3>Day 2</h3>
            <p>22 Sep 2025, Saturday @ 10:00 PM</p>
            <p class="price">₹ 350</p>
            <div class="quantity-selector">
              <button>-</button>
              <span>1</span>
              <button>+</button>
            </div>
          </div>

          <div class="pass-card">
            <h3>Day 3</h3>
            <p>22 Sep 2025, Saturday @ 10:00 PM</p>
            <p class="price">₹ 450</p>
            <div class="quantity-selector">
              <button>-</button>
              <span>1</span>
              <button>+</button>
            </div>
          </div>

          <div class="pass-card">
            <h3>Day 4</h3>
            <p>22 Sep 2025, Saturday @ 10:00 PM</p>
            <p class="price">₹ 550</p>
            <div class="quantity-selector">
              <button>-</button>
              <span>1</span>
              <button>+</button>
            </div>
          </div>
        </div>
      </section>

      <section class="sidebar-widget">
        <h2>Celebrities</h2>
        <div class="celebrities-container">
          <div class="celebrity-card">
            <img src="{{ asset('images/evn1.png') }}" alt="Kirtidan Gadhvi">
            <p>Kirtidan Gadhvi</p>
          </div>
          <div class="celebrity-card">
            <img src="{{ asset('images/evn2.png') }}" alt="Geeta Rabari">
            <p>Geeta Rabari</p>
          </div>
          <div class="celebrity-card">
            <img src="{{ asset('images/evn3.png') }}" alt="Aishwarya Majmudar">
            <p>Aishwarya Majmudar</p>
          </div>
          <div class="celebrity-card">
            <img src="{{ asset('images/evn4.png') }}" alt="Aditya Gadhvi">
            <p>Aditya Gadhvi</p>
          </div>
        </div>
      </section>

      <section class="sidebar-widget">
        <h2>Organizer</h2>
        <div class="organizer-container">
          <img src="{{ asset('images/evn5.png') }}" alt="OFLO Logo">
          <p>OFLO Event Management</p>
        </div>
      </section>

      <section class="sidebar-widget">
        <h2>Venue</h2>
        <div class="venue-container">
          <div
            style="width: 100%; max-width: 800px; margin: auto; border: 1px solid #ccc; border-radius: 8px; overflow: hidden;">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.951365063066!2d72.83106141540244!3d21.170240086240378!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04efca9f178c1%3A0xf987b152ab3b786e!2sSurat%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1695049386876!5m2!1sen!2sin"
              width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>

          <p>Plot No. 248, Near Crystal Lake Road, Opp. Green Valley Park, Sector 12-B, Golden City, Amroli - 3954107,
            India</p>
        </div>
      </section>
      <!-- ----------------------------------------------------------------------------------------------------- -->

      <!-- Event Passes Section -->
      <div id="extra-section" style="display: none;">
        <section class="sidebar-widget">
          <h2>Event Passes</h2>
          <div class="event-passes">
            <!-- Day 1 -->
            <div class="pass-card1">
              <div class="pass-info">
                <strong>Day 1</strong>
                <span>22 Sep 2025, Saturday @ 10:00 PM</span>
              </div>
              <div class="pass-actions">
                <span class="pass-price">₹ 250</span>
                <div class="quantity-selector">
                  <button>-</button>
                  <span>3</span>
                  <button>+</button>
                </div>
              </div>
            </div>

            <!-- Day 3 -->
            <div class="pass-card1">
              <div class="pass-info">
                <strong>Day 3</strong>
                <span>24 Sep 2025, Saturday @ 10:00 PM</span>
              </div>
              <div class="pass-actions">
                <span class="pass-price">₹ 250</span>
                <div class="quantity-selector">
                  <button>-</button>
                  <span>3</span>
                  <button>+</button>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- ---------------------------------------------------------------------------------------------------------- -->

        <!-- Attendee Info Section -->
        <section class="sidebar-widget">
          <h2>Attendee Info</h2>
          <div class="attendee-info">
            <input type="text" placeholder="First Name" />
            <input type="text" placeholder="Last Name" />
            <input type="email" placeholder="Email" />
            <input type="tel" placeholder="Mobile Number" />
          </div>
        </section>
        <!-- --------------------------------------------------------------------------------------------------------- -->

        <!-- Bill Details Section -->
        <section class="sidebar-widget">
          <h2>Bill Details</h2>
          <div class="bill-details">
            <div class="bill-item">
              <div>
                <strong>Day 1</strong> <span>3x</span>
                <p>22 Sep 2025, Saturday @ 10:00 PM</p>
              </div>
              <span class="bill-price">₹ 250</span>
            </div>

            <div class="bill-item">
              <div>
                <strong>Day 3</strong> <span>3x</span>
                <p>24 Sep 2025, Saturday @ 10:00 PM</p>
              </div>
              <span class="bill-price">₹ 250</span>
            </div>

            <div class="bill-total">
              <span>Total Price</span>
              <strong>₹ 1,500</strong>
            </div>
          </div>
        </section>

        <!-- Bottom Buttons -->
        <div class="bottom-buttons">
          <button class="add-ticket">Add More Ticket</button>
          <button class="checkout">Check Out</button>
        </div>
      </div>
    </aside>
  </div>
  <!-- ----------------------------------------------------------------------------------------------------- -->

  <!-- Events Section -->
  <section class="spotlight-section">
    <div style="display: flex; justify-content: center; align-items: center; height: 100px; width: 100%;">
      <img src="{{ asset('images/heading15.png') }}" alt="Events" style="width: auto; height: 40px;" />
    </div>
    <div class="events-grid">
      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img6.png')}}" alt="VHALAM NAVRATRI">
        </div>
        <div class="card-content">
          <h3 class="event-title">SACHA Navratri Festival With Jigardan Gadhavi</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>

      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img7.png')}}" alt="KINJAL DAVE">
        </div>
        <div class="card-content">
          <h3 class="event-title">SACHA Navratri Festival With Kinjal Dave</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>

      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img8.png')}}" alt="KINJAL DAVE">
        </div>
        <div class="card-content">
          <h3 class="event-title">SACHA Navratri Festival With Kinjal Dave</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>

      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img9.png')}}" alt="KINJAL DAVE">
        </div>
        <div class="card-content">
          <h3 class="event-title">SACHA Navratri Festival With Kinjal Dave</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>
    </div>
  </section>
  <!-- ------------------------------------------------------------------------------------------------- -->

  <!-- script Section -->
  <script>
    $(document).ready(function () {
      $(".quantity-selector button").click(function () {
        let $button = $(this);
        let $selector = $button.closest(".quantity-selector");
        let $quantity = $selector.find("span");
        let currentQty = parseInt($quantity.text());

        // Get base price from the price text (₹ 250 → 250)
        let $priceEl = $selector.closest(".pass-card").find(".price");
        let basePrice = parseInt($priceEl.text().replace(/[^\d]/g, ''));

        // If this is the first click, we need to store the original price
        if (!$priceEl.data("base-price")) {
          $priceEl.data("base-price", basePrice);
        }
        basePrice = $priceEl.data("base-price");

        // Increase or decrease quantity
        if ($button.text() === "+") {
          currentQty++;
        } else if ($button.text() === "-" && currentQty > 0) {
          currentQty--;
        }

        // Update quantity
        $quantity.text(currentQty);

        // Calculate total price for that card
        let updatedPrice = basePrice * currentQty;
        $priceEl.text("₹ " + updatedPrice);
      });
    });
  </script>

  <script>
    $(document).ready(function () {
      $(".pass-card").click(function () {
        $(this).toggleClass("active").siblings().removeClass("active");
        if ($(this).hasClass("active")) {
          $("#extra-section").slideDown();
        } else {
          $("#extra-section").slideUp();
        }
      });
    });
  </script>

</body>

</html>