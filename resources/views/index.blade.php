@extends('layouts.app')
@section('title', 'Home')
@section('styles')
<style>
  /* basic horizontal scroll layout */
  .banner-scroll {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 8px 4px;
    -webkit-overflow-scrolling: touch;
  }

  /* each item should not wrap */
  .banner-item {
    flex: 0 0 auto;
    width: 260px;
    height: 220px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
  }

  /* ensure image fills the card */
  .banner-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .more-events {
    color: #FF6A00 !important;
    text-decoration: none;
  }

  .filter-btn.active {
    background: #FF6A00;
    color: white;
  }
</style>
@endsection

@section('content')

<!-- Category Section Starts Here -->
<div class="cate py-4" style="background-color: var(--nav-bg);">
  <div class="category-container mx-auto p-2 event">

    <!-- Header with Search -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
      <h2 class="mb-2 mb-md-0 text-light fw-400" style="font-size: 20px;">Popular Categories</h2>

      <div class="input-group rounded-pill bg-white shadow-sm" style="max-width: 300px; overflow: hidden;">
        <span class="input-group-text bg-transparent border-0 ps-3">
          <i class="fas fa-search text-muted"></i>
        </span>
        <input type="text" class="form-control border-0 bg-transparent" placeholder="Search for products..."
          aria-label="Search">
      </div>
    </div>

    <!-- Category Carousel -->
    <div class="overflow-auto py-2">
      <div class="d-flex flex-nowrap gap-3">

        <!-- 1. View All -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/event.svg') }}" class="img-fluid mb-2" alt="View All"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="View All">View All</span>
            <small class="text-light">(250)</small>
          </div>
        </div>

        <!-- 2. Fashion Apparel -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/fashion.svg ') }}" class="img-fluid mb-2" alt="Fashion Apparel"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Fashion Apparel">Fashion Apparel</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 3. Restaurant -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/resto.svg') }}" class="img-fluid mb-2" alt="Restaurant"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Restaurant">Restaurant</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 4. Salon & SPA -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/salon.svg') }}" class="img-fluid mb-2" alt="Salon & SPA"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Salon & SPA">Salon & SPA</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 5. Education -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/edu.svg') }}" class="img-fluid mb-2" alt="Education"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Education">Education</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 6. Gym & Aerobics -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/gym.svg') }}" class="img-fluid mb-2" alt="Gym & Aerobics"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Gym & Aerobics">Gym & Aerobics</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 7. Electronics -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/elec.svg') }}" class="img-fluid mb-2" alt="Electronics"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Electronics">Electronics</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 8. Retailer -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/retail.svg') }}" class="img-fluid mb-2" alt="Retailer"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Retailer">Retailer</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 9. Home Services -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/home.svg') }}" class="img-fluid mb-2" alt="Home Services"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Home Services">Home Services</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 10. Health -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/health.svg') }}" class="img-fluid mb-2" alt="Health"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Health">Health</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 11. Hotel & Resort -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/hotel.svg') }}" class="img-fluid mb-2" alt="Hotel & Resort"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Hotel & Resort">Hotel & Resort</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 12. Automobile -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/auto.svg') }}" class="img-fluid mb-2" alt="Automobile"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Automobile">Automobile</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

        <!-- 13. Home & PG -->
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('./svg/pg.svg') }}" class="img-fluid mb-2" alt="Home & PG"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="Home & PG">Home & PG</span>
            <small class="text-light">(50)</small>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<!-- Top Beauty Product Brands Section Starts Here -->

<section class="cate1" style="background-color: var(--nav-bg); position: relative; overflow: hidden;">
  <div class="container-fluid event">

    <!-- Header -->
    <div class="d-flex justify-content-center align-items-center mb-3 flex-wrap">
      <img src="{{ asset('images/disc.png') }}" alt="Popular Categories" class="img-fluid mb-2 mb-md-0 w-md-40 w-lg-25">
    </div>


    <!-- Scrollable Card Row -->
    <div class="overflow-auto mb-2">
      <div class="d-flex flex-nowrap gap-3 pb-2">

        <!-- Card 1 -->
        <div class="card1 border-0 position-relative text-white flex-shrink-0"
          style="width: 150px; border-radius: 0; overflow: hidden;">
          <img src="{{ asset('images/brand5.png') }}" alt="LUX"
            style="width: 100%; height: 100%; object-fit: cover; display: block;">
          <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between align-items-center px-2 py-1"
            style="font-size: 0.85rem;">
            <span class="text-dark"><i class="fa-regular fa-eye me-1"></i>20K</span>
            <i class="fa-solid fa-heart text-danger"></i>
          </div>
          <div class="position-absolute bottom-0 start-0 w-100 text-center fw-semibold py-2"
            style="background-color: #ff6600;">
            UP TO 55% OFF
          </div>
        </div>

        <!-- Card 2 -->
        <div class="card1 border-0 position-relative text-white flex-shrink-0"
          style="width: 150px; height: 180px; border-radius: 0; overflow: hidden;">
          <img src="{{ asset('images/brand7.png') }}" alt="DOVE"
            style="width: 100%; height: 100%; object-fit: cover; display: block;">
          <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between align-items-center px-2 py-1"
            style="font-size: 0.85rem;">
            <span class="text-dark"><i class="fa-regular fa-eye me-1"></i>22K</span>
            <i class="fa-solid fa-heart text-danger"></i>
          </div>
          <div class="position-absolute bottom-0 start-0 w-100 text-center fw-semibold py-2"
            style="background-color: #ff6600;">
            UP TO 50% OFF
          </div>
        </div>

        <!-- Card 3 -->
        <div class="card1 border-0 position-relative text-white flex-shrink-0"
          style="width: 150px; height: 180px; border-radius: 0; overflow: hidden;">
          <img src="{{ asset('images/brand6.png') }}" alt="NIVEA"
            style="width: 100%; height: 100%; object-fit: cover; display: block;">
          <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between align-items-center px-2 py-1"
            style="font-size: 0.85rem;">
            <span class="text-dark"><i class="fa-regular fa-eye me-1"></i>15K</span>
            <i class="fa-solid fa-heart text-danger"></i>
          </div>
          <div class="position-absolute bottom-0 start-0 w-100 text-center fw-semibold py-2"
            style="background-color: #ff6600;">
            UP TO 40% OFF
          </div>
        </div>

        <!-- Card 4 -->
        <div class="card1 border-0 position-relative text-white flex-shrink-0"
          style="width: 150px; height: 180px; border-radius: 0; overflow: hidden;">
          <img src="{{ asset('images/brand8.png') }}" alt="POND'S"
            style="width: 100%; height: 100%; object-fit: cover; display: block;">
          <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between align-items-center px-2 py-1"
            style="font-size: 0.85rem;">
            <span class="text-dark"><i class="fa-regular fa-eye me-1"></i>19K</span>
            <i class="fa-solid fa-heart text-danger"></i>
          </div>
          <div class="position-absolute bottom-0 start-0 w-100 text-center fw-semibold py-2"
            style="background-color: #ff6600;">
            UP TO 60% OFF
          </div>
        </div>

        <!-- Card 5 -->
        <div class="card1 bg-light border-0 position-relative text-white flex-shrink-0"
          style="width: 150px; height: 180px; border-radius: 0; overflow: hidden;">
          <img src="{{ asset('images/brand8.png') }}" alt="LUX"
            style="width: 100%; height: 100%; object-fit: cover; display: block;">
          <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between align-items-center px-2 py-1"
            style="font-size: 0.85rem;">
            <span class="text-dark"><i class="fa-regular fa-eye me-1"></i>20K</span>
            <i class="fa-solid fa-heart text-danger"></i>
          </div>
          <div class="position-absolute bottom-0 start-0 w-100 text-center fw-semibold py-2"
            style="background-color: #ff6600;">
            UP TO 55% OFF
          </div>
        </div>

        <!-- Card 6 -->
        <div class="card1 bg-light border-0 position-relative text-white flex-shrink-0"
          style="width: 150px; height: 180px; border-radius: 0; overflow: hidden;">
          <img src="{{ asset('images/brand8.png') }}" alt="LUX"
            style="width: 100%; height: 100%; object-fit: cover; display: block;">
          <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between align-items-center px-2 py-1"
            style="font-size: 0.85rem;">
            <span class="text-dark"><i class="fa-regular fa-eye me-1"></i>20K</span>
            <i class="fa-solid fa-heart text-danger"></i>
          </div>
          <div class="position-absolute bottom-0 start-0 w-100 text-center fw-semibold py-2"
            style="background-color: #ff6600;">
            UP TO 55% OFF
          </div>
        </div>

        <!-- Card 7 -->
        <div class="card1 bg-light border-0 position-relative text-white flex-shrink-0"
          style="width: 150px; height: 180px; border-radius: 0; overflow: hidden;">
          <img src="{{ asset('images/brand8.png') }}" alt="LUX"
            style="width: 100%; height: 100%; object-fit: cover; display: block;">
          <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between align-items-center px-2 py-1"
            style="font-size: 0.85rem;">
            <span class="text-dark"><i class="fa-regular fa-eye me-1"></i>20K</span>
            <i class="fa-solid fa-heart text-danger"></i>
          </div>
          <div class="position-absolute bottom-0 start-0 w-100 text-center fw-semibold py-2"
            style="background-color: #ff6600;">
            UP TO 55% OFF
          </div>
        </div>

        <!-- Card 8 -->
        <div class="card1 bg-light border-0 position-relative text-white flex-shrink-0"
          style="width: 150px; height: 180px; border-radius: 0; overflow: hidden;">
          <img src="{{ asset('images/brand8.png') }}" alt="LUX"
            style="width: 100%; height: 100%; object-fit: cover; display: block;">
          <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between align-items-center px-2 py-1"
            style="font-size: 0.85rem;">
            <span class="text-dark"><i class="fa-regular fa-eye me-1"></i>20K</span>
            <i class="fa-solid fa-heart text-danger"></i>
          </div>
          <div class="position-absolute bottom-0 start-0 w-100 text-center fw-semibold py-2"
            style="background-color: #ff6600;">
            UP TO 55% OFF
          </div>
        </div>

      </div>
    </div>

  </div>
</section>

<!-- section 3 -->
<div class="container-fluid py-4 event">

  <div class="row align-items-center">

    <!-- Left Title -->
    <div class="col-12 col-md-3 mb-3 mb-md-0">
      <div class="section-title">FOOD</div>
    </div>

    <!-- Right Filters -->
    <div class="col-12 col-md-9">
      <div class="d-flex flex-wrap gap-2 gap-md-3 
                justify-content-center justify-content-md-end">

        <button class="filter-btn">ALL</button>
        <button class="filter-btn active">RESTAURANT</button>
        <button class="filter-btn">CAFE</button>
        <button class="filter-btn">FAST FOOD</button>

      </div>
    </div>
  </div>

</div>

<!-- section 4 -->
<div class="container-fluid py-4 event">

  <div class="brand-scroll d-flex gap-3">

    <!-- CARD 1 -->
    <div class="brand-card">
      <div class="brand-top">
        <span><i class="fa-regular fa-eye"></i> 20K</span>
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/veg-non.png') }}" width="20">
          <span class="brand-heart text-danger"><i class="fa-solid fa-heart"></i></span>
        </div>
      </div>

      <div class="brand-img">
        <img src="{{ asset('images/lapinoz.png') }}">
      </div>

      <div class="brand-name">Lapino’z</div>
      <div class="offer-strip">UP TO 60% OFF</div>
    </div>

    <!-- CARD 2 -->
    <div class="brand-card">
      <div class="brand-top">
        <span><i class="fa-regular fa-eye"></i> 20K</span>
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/veg-non.png') }}" width="20">
          <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
        </div>
      </div>

      <div class="brand-img">
        <img src="{{ asset('images/subway.png') }}">
      </div>

      <div class="brand-name">Subway</div>
      <div class="offer-strip">UP TO 60% OFF</div>
    </div>

    <!-- CARD 3 -->
    <div class="brand-card">
      <div class="brand-top">
        <span><i class="fa-regular fa-eye"></i> 20K</span>
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/veg-non.png') }}" width="20">
          <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
        </div>
      </div>

      <div class="brand-img">
        <img src="{{ asset('images/brnd.png') }}">
      </div>

      <div class="brand-name">Burger King</div>
      <div class="offer-strip">UP TO 60% OFF</div>
    </div>

    <!-- CARD 4 -->
    <div class="brand-card">
      <div class="brand-top">
        <span><i class="fa-regular fa-eye"></i> 20K</span>
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/veg-non.png') }}" width="20">
          <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
        </div>
      </div>

      <div class="brand-img">
        <img src="{{ asset('images/mcd.png') }}">
      </div>

      <div class="brand-name">McDonald’s</div>
      <div class="offer-strip">UP TO 60% OFF</div>
    </div>

    <!-- CARD 5 -->
    <div class="brand-card">
      <div class="brand-top">
        <span><i class="fa-regular fa-eye"></i> 20K</span>
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/veg-non.png') }}" width="20">
          <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
        </div>
      </div>

      <div class="brand-img">
        <img src="{{ asset('images/brnd3.png') }}">
      </div>

      <div class="brand-name">KFC</div>
      <div class="offer-strip">UP TO 60% OFF</div>
    </div>

    <!-- CARD 6 -->
    <div class="brand-card">
      <div class="brand-top">
        <span><i class="fa-regular fa-eye"></i> 20K</span>
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/veg-non.png') }}" width="20">
          <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
        </div>
      </div>

      <div class="brand-img">
        <img src="{{ asset('images/marti-noze.png') }}">
      </div>

      <div class="brand-name">Martino’z</div>
      <div class="offer-strip">UP TO 60% OFF</div>
    </div>

  </div>

</div>

<!-- section 5 -->
<section class="container-fluid my-5 event">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold" style="font-size: 24px;">Best Offer</h3>
    <a href="#" class="view-all">VIEW ALL ></a>
  </div>

  <!-- HORIZONTAL SCROLL WRAPPER -->
  <div class="offer-scroll">

    <!-- CARD 1 -->
    <div class="offer-card">
      <div class="offer-img-wrapper">

        <span class="offer-badge">-50% OFF</span>
        <img src="{{ asset('images/offer1.png') }}" class="offer-img">

        <!-- ⭐ Rating inside image -->
        <div class="img-rating">⭐ 4.5 • 20K</div>

        <!-- Veg Image (added above heart) -->
        <img src="{{ asset('images/veg.png') }}" class="veg-img">

        <!-- Heart -->
        <button class="fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
      </div>

      <div class="p-3 d-flex justify-content-between">
        <div>
          <h6 class="fw-semibold mb-1">Flat ₹200 OFF on Buy Above ₹999</h6>

          <div class="location">
            <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
          </div>
        </div>

        <!-- RIGHT : Small brand logo -->
        <img src="{{ asset('images/lapinoz.png') }}" class="brand-logo">
      </div>

    </div>

    <!-- CARD 2 -->
    <div class="offer-card">
      <div class="offer-img-wrapper">
        <span class="offer-badge">-50% OFF</span>
        <img src="{{ asset('images/offer2.png') }}" class="offer-img">
        <div class="img-rating">⭐ 4.5 • 20K</div>
        <img src="{{ asset('images/veg.png') }}" class="veg-img">
        <button class="fav-btn"><i class="fa-solid fa-heart text-danger"></i></button>
      </div>
      <div class="p-3 d-flex justify-content-between">
        <div>
          <h6 class="fw-semibold mb-1">Flat ₹200 OFF on Buy Above ₹999</h6>
          <div class="location"><i class="fa-solid fa-location-dot"></i> Vadodara – 390005</div>
        </div>
        <img src="{{ asset('images/mcd.png') }}" class="brand-logo">
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="offer-card">
      <div class="offer-img-wrapper">
        <span class="offer-badge">-50% OFF</span>
        <img src="{{ asset('images/offer3.png') }}" class="offer-img">
        <div class="img-rating">⭐ 4.5 • 20K</div>
        <img src="{{ asset('images/veg.png') }}" class="veg-img">
        <button class="fav-btn"><i class="fa-solid fa-heart text-danger"></i></button>
      </div>
      <div class="p-3 d-flex justify-content-between">
        <div>
          <h6 class="fw-semibold mb-1">Flat ₹200 OFF on Buy Above ₹999</h6>
          <div class="location"><i class="fa-solid fa-location-dot"></i> Vadodara – 390005</div>
        </div>
        <img src="{{ asset('images/brnd.png') }}" class="brand-logo">
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="offer-card">
      <div class="offer-img-wrapper">
        <span class="offer-badge">-50% OFF</span>
        <img src="{{ asset('images/offer3.png') }}" class="offer-img">
        <div class="img-rating">⭐ 4.5 • 20K</div>
        <img src="{{ asset('images/veg.png') }}" class="veg-img">
        <button class="fav-btn"><i class="fa-solid fa-heart text-danger"></i></button>
      </div>
      <div class="p-3 d-flex justify-content-between">
        <div>
          <h6 class="fw-semibold mb-1">Flat ₹200 OFF on Buy Above ₹999</h6>
          <div class="location"><i class="fa-solid fa-location-dot"></i> Vadodara – 390005</div>
        </div>
        <img src="{{ asset('images/brnd.png') }}" class="brand-logo">
      </div>
    </div>

  </div>
</section>

<!-- section 6 -->
<div class="container-fluid py-2 event">
  <h3 class="mb-4 fw-bold" style="font-size: 24px;">Book Your Table</h3>

  <div class="row g-2">

    <!-- CARD 1 -->
    <div class="col-lg-3 col-md-6 col-sm-12">
      <div class="restaurant-card">

        <!-- CARD TOP CONTENT -->
        <div class="card-content p-3 d-flex gap-1 justify-content-between">

          <!-- LEFT (Logo + Text) -->
          <div class="d-flex gap-2">
            <img src="{{ asset('images/resto1.png') }}">

            <div>
              <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>
              <p class="text-warning fw-semibold mb-1" style="color:#FF6A00 !important;">UP TO 60% OFF</p>

              <div class="d-flex align-items-center gap-2">
                <span style="font-size:14px;" class="text-muted fw-semibold"><i
                    class="bi bi-eye-fill fs-6 text-muted"></i> 20K</span>
              </div>
            </div>
          </div>

          <!-- RIGHT (Heart + Veg icon) -->
          <div class="d-flex flex-column align-items-end gap-2">
            <button class="border-0 bg-white"><span class="text-danger"><i
                  class="fa-solid fa-heart"></i></span></button>

            <!-- Veg Image (added above heart) -->
            <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto mx-auto">
          </div>

        </div>

        <!-- BOOK NOW BUTTON -->
        <div class="book-btn">BOOK NOW ➜</div>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="col-lg-3 col-md-6 col-sm-12">
      <div class="restaurant-card">

        <!-- CARD TOP CONTENT -->
        <div class="card-content p-3 d-flex gap-1 justify-content-between">

          <!-- LEFT (Logo + Text) -->
          <div class="d-flex gap-2">
            <img src="{{ asset('images/resto2.png') }}">

            <div>
              <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>
              <p class="text-warning fw-semibold mb-1" style="color:#FF6A00 !important;">UP TO 60% OFF</p>

              <div class="d-flex align-items-center gap-2">
                <span style="font-size:14px;" class="text-muted fw-semibold"><i
                    class="bi bi-eye-fill fs-6 text-muted"></i> 20K</span>
              </div>
            </div>
          </div>

          <!-- RIGHT (Heart + Veg icon) -->
          <div class="d-flex flex-column align-items-end gap-2">
            <button class="border-0 bg-white"><span class="text-danger"><i
                  class="fa-solid fa-heart"></i></span></button>

            <!-- Veg Image (added above heart) -->
            <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto mx-auto">
          </div>

        </div>

        <!-- BOOK NOW BUTTON -->
        <div class="book-btn">BOOK NOW ➜</div>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="col-lg-3 col-md-6 col-sm-12">
      <div class="restaurant-card">

        <!-- CARD TOP CONTENT -->
        <div class="card-content p-3 d-flex gap-1 justify-content-between">

          <!-- LEFT (Logo + Text) -->
          <div class="d-flex gap-2">
            <img src="{{ asset('images/resto3.png') }}">

            <div>
              <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>
              <p class="text-warning fw-semibold mb-1" style="color:#FF6A00 !important;">UP TO 60% OFF</p>

              <div class="d-flex align-items-center gap-2">
                <span style="font-size:14px;" class="text-muted fw-semibold"><i
                    class="bi bi-eye-fill fs-6 text-muted"></i> 20K</span>
              </div>
            </div>
          </div>

          <!-- RIGHT (Heart + Veg icon) -->
          <div class="d-flex flex-column align-items-end gap-2">
            <button class="border-0 bg-white"><span class="text-danger"><i
                  class="fa-solid fa-heart"></i></span></button>

            <!-- Veg Image (added above heart) -->
            <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto mx-auto">
          </div>

        </div>

        <!-- BOOK NOW BUTTON -->
        <div class="book-btn">BOOK NOW ➜</div>
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="col-lg-3 col-md-6 col-sm-12">
      <div class="restaurant-card">

        <!-- CARD TOP CONTENT -->
        <div class="card-content p-3 d-flex gap-1 justify-content-between">

          <!-- LEFT (Logo + Text) -->
          <div class="d-flex gap-2">
            <img src="{{ asset('images/resto4.png') }}">

            <div>
              <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>
              <p class="text-warning fw-semibold mb-1" style="color:#FF6A00 !important;">UP TO 60% OFF</p>

              <div class="d-flex align-items-center gap-2">
                <span style="font-size:14px;" class="text-muted fw-semibold"><i
                    class="bi bi-eye-fill fs-6 text-muted"></i> 20K</span>
              </div>
            </div>
          </div>

          <!-- RIGHT (Heart + Veg icon) -->
          <div class="d-flex flex-column align-items-end gap-2">
            <button class="border-0 bg-white"><span class="text-danger"><i
                  class="fa-solid fa-heart"></i></span></button>

            <!-- Veg Image (added above heart) -->
            <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto mx-auto">
          </div>

        </div>

        <!-- BOOK NOW BUTTON -->
        <div class="book-btn">BOOK NOW ➜</div>
      </div>
    </div>

  </div>
</div>

<!-- Section 7 -->
<div class="banner mt-3 container-fluid">
  <h3 class="w-100 text-center fw-bold" style="font-size: 24px;">
    Every Day deals For you
  </h3>

  <!-- scrollable container has the id -->
  <div class="banner-scroll" id="slider">
    <div class="banner-item"><img src="{{ asset('images/banner1.png') }}" alt=""></div>
    <div class="banner-item"><img src="{{ asset('images/banner1.png') }}" alt=""></div>
    <div class="banner-item"><img src="{{ asset('images/banner1.png') }}" alt=""></div>
    <div class="banner-item"><img src="{{ asset('images/banner1.png') }}" alt=""></div>
    <div class="banner-item"><img src="{{ asset('images/banner1.png') }}" alt=""></div>
    <div class="banner-item"><img src="{{ asset('images/banner1.png') }}" alt=""></div>
  </div>
</div>


<!-- section 8 -->
<div class="container-fluid py-3" style="background-color: var(--nav-bg);">

  <h3 class="text-center text-light fw-semibold mb-3 container" style="font-size: 24px;">
    Best Offer In This Week
  </h3>

  <!-- HORIZONTAL SCROLL WRAPPER -->
  <div class="best-offer-scroll container">

    <div class="offer-card">
      <img src="{{ asset('images/domi.png') }}" class="offer-img" alt="">
    </div>

    <div class="offer-card">
      <img src="{{ asset('images/mcd1.png') }}" class="offer-img" alt="">
    </div>

    <div class="offer-card">
      <img src="{{ asset('images/sub.png') }}" class="offer-img" alt="">
    </div>

    <div class="offer-card">
      <img src="{{ asset('images/taco.png') }}" class="offer-img" alt="">
    </div>

  </div>
</div>

<!-- section 9 -->
<div class="event-bg py-2 container-fluid">
  <div class="container-fluid py-4 event">

    <!-- Heading Row -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="event-title">EVENT</h4>
      <a href="#" class="more-events">MORE EVENTS <i class="bi bi-chevron-double-right"></i></a>
    </div>

    <div class="row g-4">

      <!-- ===== CARD TEMPLATE (Copy this for all cards) ===== -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="event-card shadow-sm rounded-4">
          <img src="{{ asset('images/img8.png') }}" class="img-fluid rounded-top" alt="event">

          <div class="content-box">
            <p class="date-line mb-1">
              Sat, 22 Nov, 2025 • 08:00 pm to 11:00 pm
            </p>

            <h6 class="fw-semibold mb-1">Stand Up Comedy</h6>

            <p class="location-text mb-2">
              Surat Dumas
            </p>

            <a href="#" class="buy-link">
              <i class="bi bi-ticket-detailed"></i> Buy Passes
            </a>
          </div>
        </div>
      </div>


      <div class="col-12 col-sm-6 col-lg-3">
        <div class="event-card shadow-sm rounded-4">
          <img src="{{ asset('images/img8.png') }}" class="img-fluid rounded-top" alt="event">

          <div class="content-box">
            <p class="date-line mb-1">
              Sat, 22 Nov, 2025 • 08:00 pm to 11:00 pm
            </p>

            <h6 class="fw-semibold mb-1">Stand Up Comedy</h6>

            <p class="location-text mb-2">
              Surat Dumas
            </p>

            <a href="#" class="buy-link">
              <i class="bi bi-ticket-detailed"></i> Buy Passes
            </a>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3">
        <div class="event-card shadow-sm rounded-4">
          <img src="{{ asset('images/img8.png') }}" class="img-fluid rounded-top" alt="event">

          <div class="content-box">
            <p class="date-line mb-1">
              Sat, 22 Nov, 2025 • 08:00 pm to 11:00 pm
            </p>

            <h6 class="fw-semibold mb-1">Stand Up Comedy</h6>

            <p class="location-text mb-2">
              Surat Dumas
            </p>

            <a href="#" class="buy-link">
              <i class="bi bi-ticket-detailed"></i> Buy Passes
            </a>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3">
        <div class="event-card shadow-sm rounded-4">
          <img src="{{ asset('images/img8.png') }}" class="img-fluid rounded-top" alt="event">

          <div class="content-box">
            <p class="date-line mb-1">
              Sat, 22 Nov, 2025 • 08:00 pm to 11:00 pm
            </p>

            <h6 class="fw-semibold mb-1">Stand Up Comedy</h6>

            <p class="location-text mb-2">
              Surat Dumas
            </p>

            <a href="#" class="buy-link">
              <i class="bi bi-ticket-detailed"></i> Buy Passes
            </a>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3">
        <div class="event-card shadow-sm rounded-4">
          <img src="{{ asset('images/img8.png') }}" class="img-fluid rounded-top" alt="event">

          <div class="content-box">
            <p class="date-line mb-1">
              Sat, 22 Nov, 2025 • 08:00 pm to 11:00 pm
            </p>

            <h6 class="fw-semibold mb-1">Stand Up Comedy</h6>

            <p class="location-text mb-2">
              Surat Dumas
            </p>

            <a href="#" class="buy-link">
              <i class="bi bi-ticket-detailed"></i> Buy Passes
            </a>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3">
        <div class="event-card shadow-sm rounded-4">
          <img src="{{ asset('images/img8.png') }}" class="img-fluid rounded-top" alt="event">

          <div class="content-box">
            <p class="date-line mb-1">
              Sat, 22 Nov, 2025 • 08:00 pm to 11:00 pm
            </p>

            <h6 class="fw-semibold mb-1">Stand Up Comedy</h6>

            <p class="location-text mb-2">
              Surat Dumas
            </p>

            <a href="#" class="buy-link">
              <i class="bi bi-ticket-detailed"></i> Buy Passes
            </a>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3">
        <div class="event-card shadow-sm rounded-4">
          <img src="{{ asset('images/img8.png') }}" class="img-fluid rounded-top" alt="event">

          <div class="content-box">
            <p class="date-line mb-1">
              Sat, 22 Nov, 2025 • 08:00 pm to 11:00 pm
            </p>

            <h6 class="fw-semibold mb-1">Stand Up Comedy</h6>

            <p class="location-text mb-2">
              Surat Dumas
            </p>

            <a href="#" class="buy-link">
              <i class="bi bi-ticket-detailed"></i> Buy Passes
            </a>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3">
        <div class="event-card shadow-sm rounded-4">
          <img src="{{ asset('images/img8.png') }}" class="img-fluid rounded-top" alt="event">

          <div class="content-box">
            <p class="date-line mb-1">
              Sat, 22 Nov, 2025 • 08:00 pm to 11:00 pm
            </p>

            <h6 class="fw-semibold mb-1">Stand Up Comedy</h6>

            <p class="location-text mb-2">
              Surat Dumas
            </p>

            <a href="#" class="buy-link">
              <i class="bi bi-ticket-detailed"></i> Buy Passes
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- section 10 -->
<div class="container-fluid py-3" style="background-color: var(--light-bg);">

  <div class="row align-items-center mx-auto event">

    <!-- Left Title -->
    <div class="col-12 col-md-3 mb-3 mb-md-0">
      <div class="section-title">FASHION APPAREL</div>
    </div>

    <!-- Right Filters -->
    <div class="col-12 col-md-9">
      <div class="d-flex flex-wrap gap-2 gap-md-3 justify-content-center justify-content-md-end">
        <button class="filter-btn">ALL</button>
        <button class="filter-btn active">MAN</button>
        <button class="filter-btn">WOMAN</button>
        <button class="filter-btn">CHILDREN</button>
      </div>
    </div>
  </div>

  <!-- section 9 -->

  <div class="container-fluid py-4 event">

    <div class="brand-scroll d-flex gap-3">

      <!-- CARD 1 -->
      <div class="brand-card">
        <div class="brand-top">
          <span><i class="fa-regular fa-eye"></i> 20K</span>
          <div class="d-flex align-items-center gap-2">
            <span class="brand-heart text-danger"><i class="fa-solid fa-heart"></i></span>
          </div>
        </div>

        <div class="brand-img">
          <img src="{{ asset('images/brnds3.png') }}" class="brand-img-lg">
        </div>

        <div class="brand-name">Adidas</div>
        <div class="offer-strip">UP TO 60% OFF</div>
      </div>

      <!-- CARD 2 -->
      <div class="brand-card">
        <div class="brand-top">
          <span><i class="fa-regular fa-eye"></i> 20K</span>
          <div class="d-flex align-items-center gap-2">
            <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
          </div>
        </div>

        <div class="brand-img">
          <img src="{{ asset('images/brnds2.png') }}" class="brand-img-lg">
        </div>

        <div class="brand-name">Calvin Klein</div>
        <div class="offer-strip">UP TO 60% OFF</div>
      </div>

      <!-- CARD 3 -->
      <div class="brand-card">
        <div class="brand-top">
          <span><i class="fa-regular fa-eye"></i> 20K</span>
          <div class="d-flex align-items-center gap-2">
            <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
          </div>
        </div>

        <div class="brand-img">
          <img src="{{ asset('images/brnds6.png') }}" class="brand-img-lg">
        </div>

        <div class="brand-name">Nike</div>
        <div class="offer-strip">UP TO 60% OFF</div>
      </div>

      <!-- CARD 4 -->
      <div class="brand-card">
        <div class="brand-top">
          <span><i class="fa-regular fa-eye"></i> 20K</span>
          <div class="d-flex align-items-center gap-2">
            <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
          </div>
        </div>

        <div class="brand-img">
          <img src="{{ asset('images/brnds5.png') }}" class="brand-img-lg">
        </div>

        <div class="brand-name">ZARA</div>
        <div class="offer-strip">UP TO 60% OFF</div>
      </div>

      <!-- CARD 5 -->
      <div class="brand-card">
        <div class="brand-top">
          <span><i class="fa-regular fa-eye"></i> 20K</span>
          <div class="d-flex align-items-center gap-2">
            <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
          </div>
        </div>

        <div class="brand-img">
          <img src="{{ asset('images/brnds4.png') }}" class="brand-img-lg">
        </div>

        <div class="brand-name">H&M</div>
        <div class="offer-strip">UP TO 60% OFF</div>
      </div>

      <!-- CARD 6 -->
      <div class="brand-card">
        <div class="brand-top">
          <span><i class="fa-regular fa-eye"></i> 20K</span>
          <div class="d-flex align-items-center gap-2">
            <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
          </div>
        </div>

        <div class="brand-img">
          <img src="{{ asset('images/brnds8.png') }}" class="brand-img-lg">
        </div>

        <div class="brand-name">POLO</div>
        <div class="offer-strip">UP TO 60% OFF</div>
      </div>

    </div>

  </div>
</div>

<!-- section 12 -->
<div class="container-fluid py-2" style="background-color: var(--light-bg);">
  <section class="container-fluid event">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="fw-bold" style="font-size: 24px;">Best Offer</h3>
      <a href="#" class="view-all">VIEW ALL ></a>
    </div>

    <!-- HORIZONTAL SCROLL WRAPPER -->
    <div class="offer-scroll d-flex justify-content-between">

      <!-- CARD 1 -->
      <div class="offer-card">
        <div class="offer-img-wrapper">

          <span class="offer-badge">-50% OFF</span>
          <img src="{{ asset('images/offers1.png') }}" class="offer-img">

          <div class="img-rating">⭐ 4.5 • 20K</div>

          <button class="fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
        </div>

        <div class="p-3 d-flex justify-content-between">
          <div>
            <h6 class="fw-semibold mb-1">Flat ₹200 OFF on Buy Above ₹999</h6>

            <div class="location">
              <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
            </div>
          </div>

          <!-- Brand Logo -->
          <img src="{{ asset('images/brnds3.png') }}" class="brand-logo brand-logo-lg">
        </div>

      </div>

      <!-- CARD 2 -->
      <div class="offer-card">
        <div class="offer-img-wrapper">

          <span class="offer-badge">-50% OFF</span>
          <img src="{{ asset('images/offers2.png') }}" class="offer-img">

          <div class="img-rating">⭐ 4.5 • 20K</div>

          <button class="fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
        </div>

        <div class="p-3 d-flex justify-content-between">
          <div>
            <h6 class="fw-semibold mb-1">Flat ₹200 OFF on Buy Above ₹999</h6>

            <div class="location">
              <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
            </div>
          </div>

          <img src="{{ asset('images/puma.png') }}" class="brand-logo brand-logo-lg">
        </div>

      </div>

      <!-- CARD 3 -->
      <div class="offer-card">
        <div class="offer-img-wrapper">

          <span class="offer-badge">-50% OFF</span>
          <img src="{{ asset('images/offers3.png') }}" class="offer-img">

          <div class="img-rating">⭐ 4.5 • 20K</div>

          <button class="fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
        </div>

        <div class="p-3 d-flex justify-content-between">
          <div>
            <h6 class="fw-semibold mb-1">Flat ₹200 OFF on Buy Above ₹999</h6>

            <div class="location">
              <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
            </div>
          </div>

          <img src="{{ asset('images/brnds6.png') }}" class="brand-logo brand-logo-lg">
        </div>

      </div>

      <!-- CARD 4 -->
      <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
        <div class="offer-card">
          <div class="offer-img-wrapper">

            <span class="offer-badge">-50% OFF</span>
            <img src="{{ asset('images/offers4.png') }}" class="offer-img">

            <div class="img-rating">⭐ 4.5 • 20K</div>

            <button class="fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
          </div>

          <div class="p-3 d-flex justify-content-between">
            <div>
              <h6 class="fw-semibold mb-1">Flat ₹200 OFF on Buy Above ₹999</h6>

              <div class="location">
                <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
              </div>
            </div>

            <img src="{{ asset('images/uspolo.png') }}" class="brand-logo brand-logo-lg">
          </div>

        </div>
      </div>
    </div>
  </section>
</div>

<!-- section 13 -->
<div class="container-fluid py-3">

  <h3 class="text-center text-dark fw-semibold mb-3 container" style="font-size: 24px;">
    Every Day deals For you
  </h3>

  <!-- HORIZONTAL SCROLL WRAPPER -->
  <div class="best-offer-scroll container d-flex justify-content-between">

    <div class="offer-card">
      <img src="{{ asset('images/deals1.png') }}" class="offer-img" alt="">
    </div>

    <div class="offer-card">
      <img src="{{ asset('images/deals2.png') }}" class="offer-img" alt="">
    </div>

    <div class="offer-card">
      <img src="{{ asset('images/deals3.png') }}" class="offer-img" alt="">
    </div>

    <div class="offer-card">
      <img src="{{ asset('images/deals4.png') }}" class="offer-img" alt="">
    </div>

  </div>
</div>

<!-- section 14 -->
<div class="container-fluid py-3" style="background-color: var(--nav-bg);">

  <h3 class="text-center text-light fw-semibold mb-3 container" style="font-size: 24px;">
    Best Offer In This Week
  </h3>

  <!-- HORIZONTAL SCROLL WRAPPER -->
  <div class="best-offer-scroll container d-flex justify-content-between">

    <div class="offer-card">
      <img src="{{ asset('images/fram1.png') }}" class="offer-img" alt="">
    </div>

    <div class="offer-card">
      <img src="{{ asset('images/fram2.png') }}" class="offer-img" alt="">
    </div>

    <div class="offer-card">
      <img src="{{ asset('images/fram3.png') }}" class="offer-img" alt="">
    </div>

    <div class="offer-card">
      <img src="{{ asset('images/fram4.png') }}" class="offer-img" alt="">
    </div>

  </div>
</div>

<!-- ⭐ Center Button -->
<div class="text-center mt-3">
  <button class="show-more-btn bg-white">Show More Offers <i class="bi bi-chevron-double-down fw-semibold"></i></button>
</div>


<!-- section 15 -->
<section class="download-bg py-5 mt-3">
  <div class="container event">
    <div class="row align-items-center">

      <!-- LEFT SIDE TEXT -->
      <div class="col-lg-6 col-md-12 mb-5 text-lg-start text-center">
        <h2 class="fw-bold text-dark download-heading">
          DOWNLOAD APP GET EXCITING <br> AMAZING DISCOUNTS
        </h2>

        <p class="mt-3 text-muted download-text">
          Join thousands of happy users already unlocking amazing discounts
          and shopping smarter every day.
        </p>

        <p class="fw-semibold p mt-4 text-dark">Available On</p>

        <div class="d-flex gap-3 justify-content-lg-start justify-content-md-center flex-wrap">
          <a href="#" class="store-btn">
            <img src="{{ asset('images/component1.png') }}" alt="Google Play Store">
          </a>

          <a href="#" class="store-btn">
            <img src="{{ asset('images/component2.png') }}" alt="Apple App Store">
          </a>
        </div>
      </div>

    </div>
  </div>
</section>


@endsection



@section('scripts')



<!-- Top Beauty Product Brands Section -->
<script>
  document.querySelectorAll('.heart-box').forEach(box => {
    box.addEventListener('click', function() {
      this.classList.toggle('active');
    });
  });

  $('.fa-heart').on('click', function() {
    $(this).toggleClass('fa-regular fa-solid').css('color',
      $(this).hasClass('fa-solid') ? 'red' : ''
    );
  });
</script>

<!-- AUTO SCROLL -->
<script>
  const slider = document.getElementById('slider');
  let position = 0;
  let intervalId = null;

  // safe helper to compute card width (includes gap)
  function getCardWidth() {
    const card = slider.querySelector('.banner-item');
    if (!card) return 0;
    // gap is 12px per CSS above
    return card.offsetWidth + 12;
  }

  function autoSlide() {
    const cardWidth = getCardWidth();
    if (!cardWidth) return;
    // if last scroll area reached, reset to start
    if (position >= slider.scrollWidth - slider.clientWidth) {
      position = 0;
    }

    slider.scrollTo({
      left: position,
      behavior: 'smooth'
    });

    position += cardWidth;
  }

  window.addEventListener('load', () => {
    // start slightly offset so first card is centered-ish
    const firstWidth = getCardWidth();
    position = Math.round(firstWidth / 2);
    slider.scrollTo({
      left: position,
      behavior: 'smooth'
    });

    // start auto-scrolling
    intervalId = setInterval(autoSlide, 2000);
  });

  // optional: pause on hover
  slider.addEventListener('mouseenter', () => clearInterval(intervalId));
  slider.addEventListener('mouseleave', () => {
    intervalId = setInterval(autoSlide, 2000);
  });
</script>

<script>
  const buttons = document.querySelectorAll('.filter-btn');

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {

      // Remove active class from all buttons
      buttons.forEach(b => b.classList.remove('active'));

      // Add active class to the clicked button
      btn.classList.add('active');

      // (Optional) Use btn.innerText to filter data here
    });
  });
</script>




@endsection