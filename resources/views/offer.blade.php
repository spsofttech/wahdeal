<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Offer</title>

  <!-- Font Awesome 6.4.0 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('web/main.css') }}">

  <style>
    .category-bar {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin: 2rem 0;
    }

    .category-bar button {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 6px;
      background: #fff;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
    }
  </style>
</head>

<body>
  <!-- banner Section -->
  <section class="breadcrumb-section">
    <div class="breadcrumb-container">
      <span class="breadcrumb-home">HOME /</span>
      <span class="breadcrumb-home">Categories /</span>
      <span>Restaurant</span>
    </div>
  </section>
  <!-- ----------------------------------------------------------------------------------------- -->

  <!-- Category Buttons -->
  <div class="category-bar">
    <button><img src="./svg/resto1.svg" alt=""> Restaurant</button>
    <button><img src="./svg/cafe.svg" alt=""> Cafe</button>
    <button><img src="./svg/food.svg" alt=""> Fast Food</button>
    <button><img src="./svg/pizza.svg" alt="">Pizza</button>
  </div>

  <!-- Offers Grid -->
  <div class="offers-grid">

    <!-- Offer Card Example -->
    <div class="offer-card">
      <div class="card-image-container">
        <img src="{{ asset('images/food.png') }}" alt="La Pino'z Pizza Offer">
        <div class="heart-box">
          <i class="far fa-heart"></i>
        </div>
        <div class="discount-badge">-50% OFF</div>
      </div>
      <div class="offer-content">
        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
        <div class="rating">
          <span class="star">★</span>4.5
        </div>
      </div>
    </div>

    <div class="offer-card">
      <div class="card-image-container">
        <img src="{{ asset('images/food1.png') }}" alt="La Pino'z Pizza Offer">
        <div class="heart-box">
          <i class="far fa-heart"></i>
        </div>
        <div class="discount-badge">-50% OFF</div>
      </div>
      <div class="offer-content">
        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
        <div class="rating">
          <span class="star">★</span>4.5
        </div>
      </div>
    </div>

    <div class="offer-card">
      <div class="card-image-container">
        <img src="{{ asset('images/food2.png') }}" alt="La Pino'z Pizza Offer">
        <div class="heart-box">
          <i class="far fa-heart"></i>
        </div>
        <div class="discount-badge">-50% OFF</div>
      </div>
      <div class="offer-content">
        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
        <div class="rating">
          <span class="star">★</span>4.5
        </div>
      </div>
    </div>

    <div class="offer-card">
      <div class="card-image-container">
        <img src="{{ asset('images/food3.png') }}" alt="La Pino'z Pizza Offer">
        <div class="heart-box">
          <i class="far fa-heart"></i>
        </div>
        <div class="discount-badge">-50% OFF</div>
      </div>
      <div class="offer-content">
        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
        <div class="rating">
          <span class="star">★</span>4.5
        </div>
      </div>
    </div>

    <div class="offer-card">
      <div class="card-image-container">
        <img src="{{ asset('images/food2.png') }}" alt="La Pino'z Pizza Offer">
        <div class="heart-box">
          <i class="far fa-heart"></i>
        </div>
        <div class="discount-badge">-50% OFF</div>
      </div>
      <div class="offer-content">
        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
        <div class="rating">
          <span class="star">★</span>4.5
        </div>
      </div>
    </div>

    <div class="offer-card">
      <div class="card-image-container">
        <img src="{{ asset('images/food3.png') }}" alt="La Pino'z Pizza Offer">
        <div class="heart-box">
          <i class="far fa-heart"></i>
        </div>
        <div class="discount-badge">-50% OFF</div>
      </div>
      <div class="offer-content">
        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
        <div class="rating">
          <span class="star">★</span>4.5
        </div>
      </div>
    </div>

    <div class="offer-card">
      <div class="card-image-container">
        <img src="{{ asset('images/food1.png') }}" alt="La Pino'z Pizza Offer">
        <div class="heart-box">
          <i class="far fa-heart"></i>
        </div>
        <div class="discount-badge">-50% OFF</div>
      </div>
      <div class="offer-content">
        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
        <div class="rating">
          <span class="star">★</span>4.5
        </div>
      </div>
    </div>

    <div class="offer-card">
      <div class="card-image-container">
        <img src="{{ asset('images/food.png') }}" alt="La Pino'z Pizza Offer">
        <div class="heart-box">
          <i class="far fa-heart"></i>
        </div>
        <div class="discount-badge">-50% OFF</div>
      </div>
      <div class="offer-content">
        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
        <div class="rating">
          <span class="star">★</span>4.5
        </div>
      </div>
    </div>

    <div class="offer-card">
      <div class="card-image-container">
        <img src="{{ asset('images/food1.png') }}" alt="La Pino'z Pizza Offer">
        <div class="heart-box">
          <i class="far fa-heart"></i>
        </div>
        <div class="discount-badge">-50% OFF</div>
      </div>
      <div class="offer-content">
        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
        <div class="rating">
          <span class="star">★</span>4.5
        </div>
      </div>
    </div>

    <div class="offer-card">
      <div class="card-image-container">
        <img src="{{ asset('images/food.png') }}" alt="La Pino'z Pizza Offer">
        <div class="heart-box">
          <i class="far fa-heart"></i>
        </div>
        <div class="discount-badge">-50% OFF</div>
      </div>
      <div class="offer-content">
        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
        <div class="rating">
          <span class="star">★</span>4.5
        </div>
      </div>
    </div>
    <!-- Repeat cards as needed... -->
  </div>


  <!-- script Section -->
  <script>
    document.querySelectorAll('.heart-box').forEach(box => {
      box.addEventListener('click', function () {
        this.classList.toggle('active');
      });
    });
  </script>
</body>

</html>