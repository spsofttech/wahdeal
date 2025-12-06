@extends('layouts.app')
@section('title', 'Home')
@section('styles')
<style>
  .tabs-container {
    display: flex !important;
    flex-wrap: nowrap !important;
    padding: 0 !important;
    gap: 0 !important;
    background-color: white !important;
  }

  .tabs-container .nav-item {
    flex: 1 !important;
    font-size: 13px !important;
  }

  .tabs-container .nav-link {
    width: 100%;
    border-radius: 0 !important;
    margin: 0 !important;
  }


  .tab {
    flex: 1;
    text-align: center;
    font-weight: 600;
    padding: 6px 12px;
    cursor: pointer;
    color: #333 !important;
    flex-shrink: 0;
    text-decoration: none;
  }

  .tab.active {
    background: #FF6A00 !important;
    color: #fff !important;
  }

  .tab:hover {
    background: #FF6A00 !important;
    color: #fff !important;
  }

  /* Hover effect – but override active only during hover */
  .tabs-container:hover .tab.active {
    background: transparent;
    color: #ffffffff !important;
  }

  .new-offer-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
  }

  /* Image Box */
  .new-offer-img-box {
    position: relative;
  }

  .new-offer-image {
    width: 100%;
    height: 250px;
    object-fit: fill;
  }

  /* Discount Tag */
  .new-offer-tag {
    position: absolute;
    top: 10px;
    right: 10px;
    left: auto;
    background: #ff6a00;
    color: #fff;
    padding: 4px 10px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 13px;
  }


  /* Rating */
  .new-offer-rating {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: rgba(0, 0, 0, 0.65);
    color: #fff;
    padding: 4px 10px;
    border-radius: 30px;
    font-size: 12px;
  }

  /* Favorite Button – Bottom Right */
  .new-fav-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: #fff;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  }

  /* Content */
  .new-offer-content {
    padding: 10px;
  }

  .new-offer-title {
    font-size: 15px;
    font-weight: 600;
  }

  .new-offer-location {
    font-size: 13px;
    color: #777;
  }

  .new-brand-img {
    width: 45px;
    height: 45px;
    object-fit: contain;
  }

  .fa-heart {
    font-size: 18px;
  }

  /* section 4 */
  /* Price */
  .new-offer-price {
    font-size: 14px;
    font-weight: 600;
  }

  .old-price {
    text-decoration: line-through;
    color: #999;
    margin-right: 6px;
  }

  .new-price {
    color: #ff6a00;
    font-weight: 700;
  }

  .add-cart-full {
    width: 100%;
    background: #ffffff;
    color: #000;
    border: 1.5px solid gray;
    padding: 4px 0;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    text-align: center;
  }

  .add-cart-full:hover {
    background: #f2f2f2;
  }



  /* Rounded Corners fix */
  .new-offer-image {
    border-radius: 14px 14px 0 0;
  }

  .new-offer-card {
    border-radius: 14px;
    background: #fff;
    position: relative;
    overflow: hidden;
  }


  .gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    cursor: pointer;
  }

  .gallery-item img {
    width: 232px;
    height: 189px;
    object-fit: cover;
    border-radius: 12px;
  }

  /* Play Icon */
  .play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 28px;
    color: white;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.6);
  }

  /* Hover zoom effect */
  .gallery-item:hover img {
    transform: scale(1.05);
    transition: 0.25s ease-in-out;
  }


  /* About section */
  .service-list li {
    margin-bottom: 6px;
    font-size: 15px;
  }

  .timing-row {
    padding: 6px 0;
    align-items: center;
  }

  .dotted-line {
    border-bottom: 1px dotted #8f8f8f;
  }

  .text-orange {
    color: #ff6600;
  }

  .map-container iframe {
    border-radius: 12px;
    width: 100%;
  }

  .btn {
    border-radius: 30px;
    padding: 8px 16px;
  }


  /* Reviews */
  .main-box {
    background: #fff;
    border-radius: 6px;
    padding: 25px;
    max-width: 900px;
  }

  .star {
    font-size: 24px;
    color: #ccc;
    cursor: pointer;
  }

  .star.selected {
    color: #ffc107;
  }

  .review-card {
    border-bottom: 1px solid #eee;
    padding: 22px 0;
  }

  .review-card:last-child {
    border-bottom: none;
  }

  .profile-img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
  }

  textarea::placeholder {
    color: #aaa;
  }

  /* Booking */
  .form-section {
    padding: 12px 18px !important;
  }

  .form-section .form-label {
    margin-bottom: 4px !important;
    font-size: 14px;
  }

  .form-section .form-control,
  .form-section .form-select {
    padding: 6px 10px !important;
    font-size: 14px;
  }

  .form-section .row {
    --bs-gutter-y: 8px !important;
    --bs-gutter-x: 8px !important;
  }

  .form-section .btn {
    padding: 6px 18px !important;
    font-size: 14px;
  }

  .btn-orange {
    background: #ff7a00 !important;
    color: #fff !important;
    padding: 5px 20px !important;
    font-size: 14px;
  }


  /* Menu */
  .menu-wrapper {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 15px;
  }

  .menu-card {
    border-radius: 12px;
    width: 232px;
    height: 232px;
    margin: auto !important;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .menu-card img {
    width: 232px;
    height: 232px;
    object-fit: cover;
  }

  /* Optional Spacing Improvement */
  .menu-gallery {
    border-radius: 8px !important;
    background-color: white !important;
  }




  /* RESPONSIVE FIXES */

  @media (max-width: 1559px) {

    .tab {
      font-size: 10px;
      padding: 6px 10px;
    }

    .tab.active {
      background: #FF6A00 !important;
      color: #fff !important;
    }

    .tab:hover {
      background: #FF6A00 !important;
      color: #fff !important;
    }

    .tabs-container:hover .tab.active {
      background: transparent;
      color: #ffffffff !important;
    }

    .tabs-container {
      display: flex;
      flex-wrap: nowrap !important;
      overflow-x: auto;
      overflow-y: hidden;
      white-space: nowrap;
      gap: 10px;
    }

    .tabs-container::-webkit-scrollbar {
      height: 0;
    }

    .tabs-container .nav-item {
      flex-shrink: 0 !important;
    }
  }

  @media (max-width: 768px) {
    .gallery-grid {
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 18px;
    }

    .menu-card {
      width: 100%;
      height: auto;
    }

    .menu-card img {
      width: 100%;
      height: auto;
    }

    .tab {
      font-size: 10px;
      padding: 6px 10px;
    }

    .tab.active {
      background: #FF6A00 !important;
      color: #fff !important;
    }

    .tab:hover {
      background: #FF6A00 !important;
      color: #fff !important;
    }

    .tabs-container:hover .tab.active {
      background: transparent;
      color: #ffffffff !important;
    }

    .tabs-container {
      display: flex;
      flex-wrap: nowrap !important;
      overflow-x: auto;
      overflow-y: hidden;
      white-space: nowrap;
      gap: 10px;
      width: 90% !important;
    }

    .tabs-container::-webkit-scrollbar {
      height: 0;
    }

    .tabs-container .nav-item {
      flex-shrink: 0 !important;
    }

    .btn-orange {
      width: 100% !important;
    }
  }

  @media (max-width: 480px) {
    .gallery-grid {
      grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
      gap: 14px;
      padding: 10px;
    }

    .gallery-item img {
      width: 232px;
      height: 150px;
      object-fit: cover;
      border-radius: 12px;
    }

    .menu-card {
      width: 100%;
      height: auto;
    }

    .menu-card img {
      width: 100%;
      height: auto;
    }

    .tab {
      font-size: 10px;
      padding: 6px 10px;
    }

    .tab.active {
      background: #FF6A00 !important;
      color: #fff !important;
    }

    .tab:hover {
      background: #FF6A00 !important;
      color: #fff !important;
    }

    .tabs-container:hover .tab.active {
      background: transparent;
      color: #ffffffff !important;
    }

    .tabs-container {
      display: flex;
      flex-wrap: nowrap !important;
      overflow-x: auto;
      overflow-y: hidden;
      white-space: nowrap;
      gap: 10px;
      width: 93% !important;
    }

    .tabs-container::-webkit-scrollbar {
      height: 0;
    }

    .tabs-container .nav-item {
      flex-shrink: 0 !important;
    }

    .btn-orange {
      width: 100% !important;
    }
  }

  @media (max-width: 375px) {
    .gallery-item img {
      width: 232px;
      height: 120px;
      object-fit: cover;
      border-radius: 12px;
    }

    .btn-orange {
      width: 100% !important;
    }

    .menu-wrapper {
      grid-template-columns: repeat(3, 1fr);
    }

    .menu-card {
      width: 100%;
      height: auto;
    }

    .menu-card img {
      width: 100%;
      height: auto;
    }
  }

  /* Mobile */
  @media (max-width: 576px) {
    .tab {
      font-size: 10px;
      padding: 6px 10px;
    }

    .tab.active {
      background: #FF6A00 !important;
      color: #fff !important;
    }

    .tab:hover {
      background: #FF6A00 !important;
      color: #fff !important;
    }

    .tabs-container:hover .tab.active {
      background: transparent;
      color: #ffffffff !important;
    }

    .tabs-container {
      display: flex;
      flex-wrap: nowrap !important;
      overflow-x: auto;
      overflow-y: hidden;
      white-space: nowrap;
      gap: 10px;
      width: 93% !important;
    }

    .tabs-container::-webkit-scrollbar {
      height: 0;
    }

    .tabs-container .nav-item {
      flex-shrink: 0 !important;
    }

    .new-offer-image {
      height: 170px;
      object-fit: fill;
      background: #f8f8f8;
    }

    .new-offer-card {
      width: 100% !important;
      border-radius: 10px;
      margin: auto;
    }

    .new-offer-title {
      font-size: 14px;
    }

    .new-brand-img {
      width: 38px;
      height: 38px;
    }

    .new-offer-content {
      padding: 10px;
    }

    .btn-orange {
      width: 100% !important;
    }

    .menu-wrapper {
      grid-template-columns: repeat(3, 1fr);
    }

    .menu-card {
      width: 100%;
      height: auto;
    }

    .menu-card img {
      width: 100%;
      height: auto;
    }
  }
</style>
@endsection

@section('content')
<div class="cate py-3" style="background-color: var(--nav-bg);">
  <div class="category-container mx-auto p-2" style="max-width: 85%;">

    <div class="d-flex justify-content-center align-items-center text-white gap-2 flex-wrap" style="font-size: 15px; letter-spacing: 1px;">

      <a href="#" class="text-white text-decoration-none">HOME</a>

      <span>/</span>

      <a href="#" class="text-white text-decoration-none">DEALS & OFFERS</a>

    </div>

  </div>
</div>
<div class="about-brand-page" style="background-color: #f5f5f5;">

  <div class="container my-3">
    <div class="row g-3">

      <!-- Card 1: Image -->
      <div class="col-lg-5 col-md-5 col-12 p-0 pe-md-2 pe-lg-2">
        <div class="card h-100 shadow-sm p-0 border-0 overflow-hidden">
          <img src="{{ asset('images/zara_store.png') }}"
            class="img-fluid w-100 h-100 object-fit-cover"
            alt="Zara Store" style="min-height: 220px;">
        </div>
      </div>

      <!-- Card 2: Content -->
      <div class="col-lg-7 col-md-7 col-12 p-0 ps-md-2 ps-lg-2">
        <div class="card1 h-100 shadow-sm border-sm rounded p-4 d-flex flex-column justify-content-between">

          <!-- TOP SECTION -->
          <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">

            <!-- Left: Logo + Title -->
            <div class="d-flex align-items-start gap-2 flex-grow-1">
              <img src="{{ asset('images/zara_logo.png') }}"
                width="45" height="45"
                class="object-fit-contain" />

              <div class="mt-1">
                <h6 class="mb-1 fw-bold">
                  ZARA
                  <span class="ms-2 text-muted small"><i class="fas fa-eye"></i> 20K</span>
                </h6>

                <div class="text-muted small d-flex align-items-center gap-1">
                  <i class="fas fa-map-marker-alt"></i>
                  <span>Amroli 394107</span>
                  <i class="fas fa-chevron-down ms-1"></i>
                </div>
              </div>
            </div>

            <!-- Right: Heart + Review -->
            <div class="d-flex flex-column align-items-end">
              <div class="d-flex justify-content-center align-items-center gap-3">
                <a href="#"><i class="bi bi-share text-dark"></i></a>
                <a href="#"><i class="fas fa-heart text-danger fs-5"></i></a>
              </div>

              <div class="d-flex align-items-center gap-1 mt-1">
                <span class="fw-semibold small">Review</span>
                <span class="badge bg-dark text-light d-flex align-items-center gap-1 px-2 py-1">
                  <i class="fas fa-star text-warning"></i> 4.5
                </span>
              </div>
            </div>

          </div>

          <!-- Offer Buttons -->
          <div class="offer-buttons mt-3 d-flex flex-nowrap overflow-auto gap-2">
            <a href="#" class="btn btn-outline-secondary btn-sm">70% OFF</a>
            <a href="#" class="btn btn-outline-secondary btn-sm">40% OFF</a>
            <a href="#" class="btn btn-outline-secondary btn-sm">30% OFF</a>
            <a href="#" class="btn btn-outline-secondary btn-sm">20% OFF</a>
            <a href="#" class="btn btn-outline-secondary btn-sm">10% OFF</a>
          </div>

        </div>
      </div>

    </div>
  </div>


  <!-- tabs section -->
  <ul class="nav nav-pill mb-3 container tabs-container mt-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link tab active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Deals & Offers</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link tab" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Shopping</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link tab" id="pills-gallery-tab" data-bs-toggle="pill" data-bs-target="#pills-booking" type="button" role="tab" aria-controls="pills-booking" aria-selected="false">Booking</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link tab" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-appointment" type="button" role="tab" aria-controls="pills-appointment" aria-selected="false">Appointment</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link tab" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-catalog" type="button" role="tab" aria-controls="pills-catalog" aria-selected="false">Catalog</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link tab" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-menu" type="button" role="tab" aria-controls="pills-menu" aria-selected="false">Menu</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link tab" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-gallery" type="button" role="tab" aria-controls="pills-gallery" aria-selected="false">Gallery</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link tab" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-about" type="button" role="tab" aria-controls="pills-about" aria-selected="false">About</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link tab" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews" aria-selected="false">Reviews</button>
    </li>
  </ul>

  <!-- tab wise content -->
  <div class="tab-content" id="pills-tabContent">
    <!-- Deals -->
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
      <div id="deals-section">
        <!-- section 3 -->
        <section class="offer-sec container py-1">
          <div class="row g-4">

            <!-- Card START -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>
            <!-- Card END -->

            <!-- CARD 2 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers2.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/puma.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers3.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/brnds6.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers4.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/uspolo.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

          </div>

          <div class="row g-4 mt-1">

            <!-- Card START -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>
            <!-- Card END -->

            <!-- CARD 2 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers2.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/puma.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers3.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/brnds6.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers4.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/uspolo.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

          </div>
        </section>

        <!-- section 4 -->
        <section class="py-4">
          <div class="container">

            <h4 class="fw-semibold mb-3">Similar Coupons</h4>

            <div class="row g-4">

              <!-- Card START -->
              <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
                <div class="new-offer-card">
                  <div class="new-offer-img-box">

                    <span class="new-offer-tag">-50% OFF</span>
                    <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                    <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                    <button class="new-fav-btn">
                      <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                    </button>
                  </div>

                  <div class="new-offer-content d-flex justify-content-between">
                    <div>
                      <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                      <div class="new-offer-location">
                        <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                      </div>
                    </div>
                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                  </div>

                </div>
              </div>
              <!-- Card END -->

              <!-- CARD 2 -->
              <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
                <div class="new-offer-card">
                  <div class="new-offer-img-box">

                    <span class="new-offer-tag">-50% OFF</span>
                    <img src="{{ asset('images/offers2.png') }}" class="new-offer-image">

                    <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                    <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                  </div>

                  <div class="new-offer-content d-flex justify-content-between">
                    <div>
                      <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                      <div class="new-offer-location">
                        <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                      </div>
                    </div>
                    <img src="{{ asset('images/puma.png') }}" class="new-brand-img">
                  </div>

                </div>
              </div>

              <!-- CARD 3 -->
              <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
                <div class="new-offer-card">
                  <div class="new-offer-img-box">

                    <span class="new-offer-tag">-50% OFF</span>
                    <img src="{{ asset('images/offers3.png') }}" class="new-offer-image">

                    <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                    <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                  </div>

                  <div class="new-offer-content d-flex justify-content-between">
                    <div>
                      <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                      <div class="new-offer-location">
                        <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                      </div>
                    </div>
                    <img src="{{ asset('images/brnds6.png') }}" class="new-brand-img">
                  </div>

                </div>
              </div>

              <!-- CARD 4 -->
              <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
                <div class="new-offer-card">
                  <div class="new-offer-img-box">

                    <span class="new-offer-tag">-50% OFF</span>
                    <img src="{{ asset('images/offers4.png') }}" class="new-offer-image">

                    <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                    <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                  </div>

                  <div class="new-offer-content d-flex justify-content-between">
                    <div>
                      <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                      <div class="new-offer-location">
                        <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                      </div>
                    </div>
                    <img src="{{ asset('images/uspolo.png') }}" class="new-brand-img">
                  </div>

                </div>
              </div>

            </div>
          </div>
        </section>

        <!-- section 5 -->
        <section class="offer-sec container py-3">
          <h4 class="fw-semibold mb-3">Similar Products</h4>

          <div class="row g-4">

            <!-- CARD 1 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <!-- Full Width Add to Cart -->
                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <!-- Full Width Add to Cart -->
                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <!-- Full Width Add to Cart -->
                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-40% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <!-- Full Width Add to Cart -->
                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

          </div>
        </section>

      </div>
    </div>

    <!-- Shopping -->
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
      <div class="shopping-page" style="background-color: var(--light-bg);">

        <!-- section 3 -->
        <section class="offer-sec container py-1">

          <div class="row g-4">

            <!-- CARD 1 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>

                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>

                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>

                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>

                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-40% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>

                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>

                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

          </div>

          <div class="row g-4 mt-1">

            <!-- CARD 1 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>

                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>

                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>

                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>

                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-40% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>

                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>

                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

          </div>
        </section>

        <!-- section 4 -->
        <section class="py-4">
          <div class="container">

            <h4 class="fw-semibold mb-3">Similar Coupons</h4>

            <div class="row g-4">

              <!-- Card START -->
              <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
                <div class="new-offer-card">
                  <div class="new-offer-img-box">

                    <span class="new-offer-tag">-50% OFF</span>
                    <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                    <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                    <button class="new-fav-btn">
                      <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                    </button>
                  </div>

                  <div class="new-offer-content d-flex justify-content-between">
                    <div>
                      <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                      <div class="new-offer-location">
                        <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                      </div>
                    </div>
                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                  </div>

                </div>
              </div>
              <!-- Card END -->

              <!-- CARD 2 -->
              <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
                <div class="new-offer-card">
                  <div class="new-offer-img-box">

                    <span class="new-offer-tag">-50% OFF</span>
                    <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                    <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                    <button class="new-fav-btn">
                      <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                    </button>
                  </div>

                  <div class="new-offer-content d-flex justify-content-between">
                    <div>
                      <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                      <div class="new-offer-location">
                        <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                      </div>
                    </div>
                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                  </div>

                </div>
              </div>

              <!-- CARD 3 -->
              <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
                <div class="new-offer-card">
                  <div class="new-offer-img-box">

                    <span class="new-offer-tag">-50% OFF</span>
                    <img src="{{ asset('images/offers3.png') }}" class="new-offer-image">

                    <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                    <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                  </div>

                  <div class="new-offer-content d-flex justify-content-between">
                    <div>
                      <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                      <div class="new-offer-location">
                        <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                      </div>
                    </div>
                    <img src="{{ asset('images/brnds6.png') }}" class="new-brand-img">
                  </div>

                </div>
              </div>

              <!-- CARD 4 -->
              <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
                <div class="new-offer-card">
                  <div class="new-offer-img-box">

                    <span class="new-offer-tag">-50% OFF</span>
                    <img src="{{ asset('images/offers4.png') }}" class="new-offer-image">

                    <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                    <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                  </div>

                  <div class="new-offer-content d-flex justify-content-between">
                    <div>
                      <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                      <div class="new-offer-location">
                        <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                      </div>
                    </div>
                    <img src="{{ asset('images/uspolo.png') }}" class="new-brand-img">
                  </div>

                </div>
              </div>

            </div>
          </div>
        </section>

        <!-- section 5 -->
        <section class="offer-sec container py-3">
          <h4 class="fw-semibold mb-3">Similar Products</h4>

          <div class="row g-4">

            <!-- CARD 1 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <!-- Full Width Add to Cart -->
                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <!-- Full Width Add to Cart -->
                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-30% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <!-- Full Width Add to Cart -->
                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-lg-3">
              <div class="new-offer-card">

                <div class="new-offer-img-box">
                  <span class="new-offer-tag">-40% OFF</span>

                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                    </div>

                    <div class="new-offer-price mt-1">
                      <span class="old-price">₹3999</span>
                      <span class="new-price">₹1999</span>
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

                <!-- Full Width Add to Cart -->
                <div class="p-2">
                  <button class="add-cart-full">Add to Cart</button>
                </div>

              </div>
            </div>

          </div>
        </section>

      </div>
    </div>

    <!-- Gallery -->
    <div class="tab-pane fade mt-4" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
      <!-- section 1 -->
      <div class="container bg-white p-2" style="border-radius: 5px;">
        <div class="row g-3">

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item">
              <img src="{{ asset('images/gallery1.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item video">
              <img src="{{ asset('images/gallery2.png') }}" class="img-fluid">
              <span class="play-btn"><i class="bi bi-play-circle"></i></span>
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item">
              <img src="{{ asset('images/gallery3.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item">
              <img src="{{ asset('images/gallery4.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item">
              <img src="{{ asset('images/gallery5.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item video">
              <img src="{{ asset('images/gallery6.png') }}" class="img-fluid">
              <span class="play-btn"><i class="bi bi-play-circle"></i></span>
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item">
              <img src="{{ asset('images/gallery7.png') }}" class="img-fluid">
              <span class="play-btn"><i class="bi bi-play-circle"></i></span>
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item video">
              <img src="{{ asset('images/gallery8.png') }}" class="img-fluid">
            </div>
          </div>

        </div>
      </div>

      <!-- section 2 -->
      <section class="py-4">
        <div class="container">

          <h4 class="fw-semibold mb-3">Similar Coupons</h4>

          <div class="row g-4">

            <!-- Card START -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>
            <!-- Card END -->

            <!-- CARD 2 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers2.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/puma.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers3.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/brnds6.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers4.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/uspolo.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- section 3 -->
      <section class="offer-sec container py-3">
        <h4 class="fw-semibold mb-3">Similar Products</h4>

        <div class="row g-4">

          <!-- CARD 1 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 2 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 3 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 4 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-40% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

        </div>
      </section>
    </div>

    <!-- About -->
    <div class="tab-pane fade" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab">
      <!-- section 1 -->
      <div class="container bg-white p-3" style="border-radius: 5px;">

        <!-- ABOUT US -->
        <section class="mb-4" style="padding-bottom:12px; border-bottom:1px solid #e6e6e6;">
          <h5 class="fw-semibold mb-2">About Us</h5>
          <p class="text-muted">
            Zara is a Spanish fast-fashion retailer and a subsidiary of the multinational company Inditex.
            Founded in 1975, its success is built on a model that quickly turns fashion trends into affordable
            clothing by shortening the time from design to store. The brand’s strategy relies on a responsive
            supply chain, customer feedback, and strategic store placement rather than traditional advertising.
          </p>
        </section>

        <!-- OUR SERVICES -->
        <section class="mb-4" style="padding-bottom:12px; border-bottom:1px solid #e6e6e6;">
          <h5 class="fw-semibold mb-3">Our Services</h5>

          <ul class="service-list">
            <li>Men’s / Women’s / Kids Clothing</li>
            <li>Ethnic & Western Wear</li>
            <li>Innerwear & Hosiery</li>
            <li>Fashion Accessories</li>
          </ul>
        </section>

        <!-- TIMING -->
        <section class="mb-4" style="padding-bottom:12px; border-bottom:1px solid #e6e6e6;">
          <h5 class="fw-semibold mb-3">Timing</h5>

          <div class="timing-table">

            <div class="timing-row d-flex align-items-center mb-2" style="gap:8px;">
              <span class="fw-semibold text-orange">Monday</span>
              <div style="flex-grow:1; border-bottom:1px dotted #aaa;"></div>
              <span class="text-orange fw-semibold">08:00 AM – 09:00 PM</span>
            </div>

            <div class="timing-row d-flex align-items-center mb-2" style="gap:8px;">
              <span class="text-muted">Tuesday</span>
              <div style="flex-grow:1; border-bottom:1px dotted #aaa;"></div>
              <span class="text-muted">08:00 AM – 09:00 PM</span>
            </div>

            <div class="timing-row d-flex align-items-center mb-2" style="gap:8px;">
              <span class="text-muted">Wednesday</span>
              <div style="flex-grow:1; border-bottom:1px dotted #aaa;"></div>
              <span class="text-muted">08:00 AM – 09:00 PM</span>
            </div>

            <div class="timing-row d-flex align-items-center mb-2" style="gap:8px;">
              <span class="text-muted">Thursday</span>
              <div style="flex-grow:1; border-bottom:1px dotted #aaa;"></div>
              <span class="text-muted">08:00 AM – 09:00 PM</span>
            </div>

            <div class="timing-row d-flex align-items-center mb-2" style="gap:8px;">
              <span class="text-muted">Friday</span>
              <div style="flex-grow:1; border-bottom:1px dotted #aaa;"></div>
              <span class="text-muted">08:00 AM – 09:00 PM</span>
            </div>

            <div class="timing-row d-flex align-items-center mb-2" style="gap:8px;">
              <span class="text-muted">Saturday</span>
              <div style="flex-grow:1; border-bottom:1px dotted #aaa;"></div>
              <span class="text-muted">08:00 AM – 09:00 PM</span>
            </div>

            <div class="timing-row d-flex align-items-center mb-2" style="gap:8px;">
              <span class="text-muted">Sunday</span>
              <div style="flex-grow:1; border-bottom:1px dotted #aaa;"></div>
              <span class="text-muted">08:00 AM – 09:00 PM</span>
            </div>

          </div>
        </section>

        <!-- LOCATION -->
        <section class="mb-0" style="padding-bottom:12px;">
          <h5 class="fw-semibold mb-2">Location</h5>

          <p class="text-muted small mb-3">
            Plot No. 248, Near Crystal Lake Road, Opp. Green Valley Park, Sector 12-B,
            Golden City, Amroli – 3954107, India
          </p>

          <div class="map-container mb-3">
            <iframe
              src="https://www.google.com/maps/embed?..."
              width="100%" height="320" style="border:0;" allowfullscreen="">
            </iframe>
          </div>

          <!-- BUTTONS -->
          <div class="d-flex flex-nowrap gap-2">

            <button
              class="btn btn-outline-success d-flex align-items-center gap-1"
              style="transition:0.2s; white-space:nowrap; padding:4px 10px; font-size:13px;"
              onmouseover="this.style.backgroundColor='#d9f5e5'; this.style.color='#28a745'; this.style.borderColor='#28a745';"
              onmouseout="this.style.backgroundColor=''; this.style.color=''; this.style.borderColor='';">
              <i class="fa-solid fa-location-dot" style="font-size:14px;"></i> Directions
            </button>

            <a
              href="tel:+911234567890"
              class="btn btn-outline-success d-flex align-items-center gap-1"
              style="transition:0.2s; white-space:nowrap; padding:4px 10px; font-size:13px;"
              onmouseover="this.style.backgroundColor='#d9f5e5'; this.style.color='#28a745'; this.style.borderColor='#28a745';"
              onmouseout="this.style.backgroundColor=''; this.style.color=''; this.style.borderColor='';">
              <img src="{{ asset('images/call.png') }}" alt="Phone" style="width:15px; height:15px;">
              +91 12345 67890
            </a>

            <button
              class="btn btn-outline-success d-flex align-items-center gap-1"
              style="transition:0.2s; white-space:nowrap; padding:4px 10px; font-size:13px;"
              onmouseover="this.style.backgroundColor='#d9f5e5'; this.style.color='#28a745'; this.style.borderColor='#28a745';"
              onmouseout="this.style.backgroundColor=''; this.style.color=''; this.style.borderColor='';">
              <i class="bi bi-share" style="font-size:14px;"></i> Share
            </button>

          </div>

        </section>

      </div>


      <!-- section 2 -->
      <section class="py-4">
        <div class="container">

          <h4 class="fw-semibold mb-3">Similar Coupons</h4>

          <div class="row g-4">

            <!-- Card START -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>
            <!-- Card END -->

            <!-- CARD 2 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers2.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/puma.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers3.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/brnds6.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers4.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/uspolo.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- section 3 -->
      <section class="offer-sec container py-3">
        <h4 class="fw-semibold mb-3">Similar Products</h4>

        <div class="row g-4">

          <!-- CARD 1 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 2 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 3 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 4 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-40% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

        </div>
      </section>
    </div>

    <!-- Reviews -->
    <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
      <!-- section 1 -->
      <div class="main-box container p-4">

        <!-- SCORE + STARS + POST BUTTON IN ONE ROW -->
        <div class="d-flex justify-content-between align-items-center mb-3">

          <!-- LEFT SIDE : Score + Stars -->
          <div class="align-items-center gap-2">
            <h6 class="fw-semibold mt-2">Score:</h6>

            <div id="ratingStars" class="d-flex gap-2">
              <i class="fa-solid fa-star star selected"></i>
              <i class="fa-regular fa-star star"></i>
              <i class="fa-regular fa-star star"></i>
              <i class="fa-regular fa-star star"></i>
              <i class="fa-regular fa-star star"></i>
            </div>
          </div>

          <!-- RIGHT SIDE : Post Button -->
          <button class="btn text-white px-4" style="background-color: #FF6A00;">Post</button>
        </div>

        <!-- Review Box -->
        <div class="mb-3">
          <!-- <label class="form-label fw-semibold">Review:</label> -->
          <textarea class="form-control" rows="3" placeholder="review:"></textarea>
        </div>


        <!-- More Review Section -->
        <h6 class="fw-semibold mt-4">More Review</h6>

        <!-- Review Item 1 -->
        <div class="review-card mb-3">
          <div class="d-flex align-items-start">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="profile-img me-3">

            <div class="flex-grow-1">

              <!-- Name + Stars -->
              <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-1">Saanvi Verma</h6>

                <div>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                </div>
              </div>

              <p class="mb-2 small text-muted">
                I recently purchased clothes from here, and I’m honestly impressed with the entire experience.
                The fabric quality exceeded my expectations — soft, breathable & comfortable.
              </p>

              <div class="d-flex justify-content-end" style="cursor:pointer;">
                <i class="fa-solid fa-trash text-dark me-3"></i>
                <i class="fa-solid fa-pen-to-square text-dark"></i>
              </div>

            </div>
          </div>
        </div>


        <!-- Review Item 2 -->
        <div class="review-card mb-3">
          <div class="d-flex align-items-start">
            <img src="https://randomuser.me/api/portraits/women/55.jpg" class="profile-img me-3">

            <div class="flex-grow-1">

              <!-- Name + Stars -->
              <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-1">Janhavi Shetty</h6>

                <div>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                </div>
              </div>

              <p class="mb-2 small text-muted">
                What I loved most was the fit. The sizing matched exactly as described and nothing felt cheap.
              </p>

            </div>
          </div>
        </div>


        <!-- Review Item 3 -->
        <div class="review-card mb-3">
          <div class="d-flex align-items-start">
            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="profile-img me-3">

            <div class="flex-grow-1">

              <!-- Name + Stars -->
              <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-1">Diya Malhotra</h6>

                <div>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                </div>
              </div>

              <p class="mb-2 small text-muted">
                Delivery was smooth & faster than expected. Customer support team was very responsive.
              </p>

            </div>
          </div>
        </div>


        <!-- Review Item 4 -->
        <div class="review-card mb-3">
          <div class="d-flex align-items-start">
            <img src="https://randomuser.me/api/portraits/women/21.jpg" class="profile-img me-3">

            <div class="flex-grow-1">

              <!-- Name + Stars -->
              <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-1">Riya Deshmukh</h6>

                <div>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                </div>
              </div>

              <p class="mb-2 small text-muted">
                Everything arrived neatly packed and the support team was polite & very helpful.
              </p>

            </div>
          </div>
        </div>

      </div>

      <!-- section 2 -->
      <section class="py-4">
        <div class="container">

          <h4 class="fw-semibold mb-3">Similar Coupons</h4>

          <div class="row g-4">

            <!-- Card START -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>
            <!-- Card END -->

            <!-- CARD 2 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers2.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/puma.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers3.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/brnds6.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/offers4.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/uspolo.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- section 3 -->
      <section class="offer-sec container py-3">
        <h4 class="fw-semibold mb-3">Similar Products</h4>

        <div class="row g-4">

          <!-- CARD 1 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 2 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 3 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 4 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-40% OFF</span>

                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>
                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>
                <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
              </div>

              <!-- Full Width Add to Cart -->
              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

        </div>
      </section>
    </div>

    <!-- Booking -->
    <div class="tab-pane fade" id="pills-booking" role="tabpanel" aria-labelledby="pills-booking-tab">
      <!-- section 1 -->
      <div class="container py-1">
        <div class="form-section bg-white rounded">
          <h5 class="mb-2">User Details</h5>

          <form>
            <div class="row g-2">

              <div class="col-lg-3 col-md-6">
                <!-- <label class="form-label">First Name *</label> -->
                <input type="text" class="form-control" placeholder="First Name">
              </div>

              <div class="col-lg-3 col-md-6">
                <!-- <label class="form-label">Phone Number *</label> -->
                <input type="text" class="form-control" placeholder="Phone Number">
              </div>

              <div class="col-lg-3 col-md-6">
                <!-- <label class="form-label">Email ID *</label> -->
                <input type="email" class="form-control" placeholder="Email">
              </div>

              <div class="col-lg-3 col-md-6">
                <!-- <label class="form-label">Number of Guests *</label> -->
                <input type="number" class="form-control" placeholder="Guests">
              </div>

              <div class="col-lg-3 col-md-6">
                <!-- <label class="form-label">Occasion *</label> -->
                <select class="form-select">
                  <option disabled selected>Select Occasion</option>
                  <option>Birthday</option>
                  <option>Anniversary</option>
                  <option>Other</option>
                </select>
              </div>

              <div class="col-lg-3 col-md-6">
                <!-- <label class="form-label">Seating Preference *</label> -->
                <select class="form-select">
                  <option disabled selected>Select Preference</option>
                  <option>Indoor</option>
                  <option>Outdoor</option>
                </select>
              </div>

              <div class="col-lg-3 col-md-6">
                <!-- <label class="form-label">Special Requests *</label> -->
                <input type="text" class="form-control" placeholder="Requests">
              </div>

              <div class="col-lg-3 col-md-6">
                <!-- <label class="form-label">Select Date *</label> -->
                <input type="date" class="form-control">
              </div>

              <div class="col-lg-3 col-md-6">
                <!-- <label class="form-label">Select Time *</label> -->
                <input type="time" class="form-control">
              </div>

              <div class="col-12 mt-2">
                <button class="btn btn-orange border">Book Now</button>
              </div>

            </div>
          </form>
        </div>
      </div>

      <!-- section 2 -->
      <section class="py-4">
        <div class="container">

          <h4 class="fw-semibold mb-3">Similar Coupons</h4>

          <div class="row g-4">

            <!-- Card START -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/dom1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>
            <!-- Card END -->

            <!-- CARD 2 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/dom2.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/dom3.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/dom4.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- section 3 -->
      <section class="offer-sec container py-3">

        <h4 class="fw-semibold mb-3">Similar Products</h4>

        <div class="row g-4">

          <!-- CARD 1 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/dom5.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 2 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/dom6.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 3 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/dom7.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 4 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-40% OFF</span>

                <img src="{{ asset('images/dom8.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

        </div>

      </section>
    </div>

    <!-- Menu -->
    <div class="tab-pane fade" id="pills-menu" role="tabpanel" aria-labelledby="pills-menu-tab">
      <!-- section 1 -->
      <div class="menu-gallery container py-4">
        <div class="row g-3">

          <!-- Image Box -->
          <div class="col-4 col-sm-4 col-md-4 col-lg-3">
            <div class="menu-card">
              <img src="{{ asset('images/menu1.png') }}" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-4 col-lg-3">
            <div class="menu-card">
              <img src="{{ asset('images/menu2.png') }}" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-4 col-lg-3">
            <div class="menu-card">
              <img src="{{ asset('images/menu3.png') }}" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-4 col-lg-3">
            <div class="menu-card">
              <img src="{{ asset('images/menu4.png') }}" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-4 col-lg-3">
            <div class="menu-card">
              <img src="{{ asset('images/menu5.png') }}" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-4 col-lg-3">
            <div class="menu-card">
              <img src="{{ asset('images/menu6.png') }}" class="img-fluid" alt="">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-4 col-lg-3">
            <div class="menu-card">
              <img src="{{ asset('images/menu7.png') }}" class="img-fluid" alt="">
            </div>
          </div>

        </div>
      </div>


      <!-- section 2 -->
      <section class="py-4">
        <div class="container">

          <h4 class="fw-semibold mb-3">Similar Coupons</h4>

          <div class="row g-4">

            <!-- Card START -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/dom1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>
            <!-- Card END -->

            <!-- CARD 2 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/dom2.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/dom3.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/dom4.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- section 3 -->
      <section class="offer-sec container py-3">

        <h4 class="fw-semibold mb-3">Similar Products</h4>

        <div class="row g-4">

          <!-- CARD 1 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/dom5.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 2 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/dom6.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 3 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/dom7.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 4 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-40% OFF</span>

                <img src="{{ asset('images/dom8.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/dom.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

        </div>

      </section>
    </div>

    <!-- Appointment -->
    <div class="tab-pane fade" id="pills-appointment" role="tabpanel" aria-labelledby="pills-appointment-tab">
      <!-- section 1 -->
      <div class="container py-1">
        <div class="form-section bg-white rounded">
          <h5 class="mb-2 fw-semibold">User Details</h5>

          <form>
            <div class="row g-2">

              <!-- First Name -->
              <div class="col-lg-3 col-md-6">
                <input type="text" class="form-control custom-input" placeholder="First Name*">
              </div>

              <!-- Phone Number -->
              <div class="col-lg-3 col-md-6">
                <input type="text" class="form-control custom-input" placeholder="Phone Number*">
              </div>

              <!-- Email -->
              <div class="col-lg-3 col-md-6">
                <input type="email" class="form-control custom-input" placeholder="Email ID*">
              </div>

              <!-- Gender -->
              <div class="col-lg-3 col-md-6">
                <select class="form-select custom-input">
                  <option selected disabled>Gender*</option>
                  <option>Male</option>
                  <option>Female</option>
                  <option>Other</option>
                </select>
              </div>

              <!-- Hair/Skin Type -->
              <div class="col-lg-3 col-md-6">
                <select class="form-select custom-input">
                  <option selected disabled>Hair/skin type</option>
                  <option>Normal</option>
                  <option>Dry</option>
                  <option>Oily</option>
                </select>
              </div>

              <!-- Select Date -->
              <div class="col-lg-3 col-md-6 position-relative">
                <input type="date" class="form-control custom-input">
              </div>

              <!-- Select Time -->
              <div class="col-lg-3 col-md-6 position-relative">
                <input type="time" class="form-control custom-input">
              </div>

              <!-- Allergy Info -->
              <div class="col-12">
                <textarea class="form-control custom-input" rows="2" placeholder="Any allergy info"></textarea>
              </div>

              <!-- Upload File -->
              <div class="col-12">
                <label class="fw-semibold me-2">Upload File</label>
                <label class="btn border" style="background-color: #7777772d;">
                  <i class="bi bi-file-earmark-medical-fill"></i> Choose File
                  <input type="file" hidden>
                </label>

              </div>

              <!-- Submit Button -->
              <div class="col-12 mt-2">
                <button class="btn btn-orange border px-4">Appointment Now</button>
              </div>

            </div>
          </form>

        </div>
      </div>

      <!-- section 2 -->
      <section class="py-4">
        <div class="container">

          <h4 class="fw-semibold mb-3">Similar Coupons</h4>

          <div class="row g-4">

            <!-- Card START -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/app1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/app.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>
            <!-- Card END -->

            <!-- CARD 2 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/app2.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/app.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/app3.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/app.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/app4.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/app.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- section 3 -->
      <section class="offer-sec container py-3">

        <h4 class="fw-semibold mb-3">Similar Products</h4>

        <div class="row g-4">

          <!-- CARD 1 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/app5.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/app.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">

                <!-- Mobile Text -->
                <button class="add-cart-full text-dark d-block d-md-none w-100">
                  Add to Cart
                </button>

                <!-- Desktop Text -->
                <button class="add-cart-full text-muted d-none d-md-block w-100">
                  2 Qty Added | <span class="text-orange">Add More</span>
                </button>

              </div>


            </div>
          </div>

          <!-- CARD 2 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/app6.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/app.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 3 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/app7.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/app.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 4 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-40% OFF</span>

                <img src="{{ asset('images/app8.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/app.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

        </div>

      </section>
    </div>

    <!-- Catalog -->
    <div class="tab-pane fade mt-4" id="pills-catalog" role="tabpanel" aria-labelledby="pills-catalog-tab">
      <!-- section 1 -->
      <div class="container bg-white p-2" style="border-radius: 5px;">
        <div class="row g-3">

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item">
              <img src="{{ asset('images/cat1.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item video">
              <img src="{{ asset('images/cat2.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item">
              <img src="{{ asset('images/cat3.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item">
              <img src="{{ asset('images/cat4.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item">
              <img src="{{ asset('images/cat5.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item video">
              <img src="{{ asset('images/cat6.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item video">
              <img src="{{ asset('images/cat6.png') }}" class="img-fluid">
            </div>
          </div>

          <div class="col-4 col-sm-4 col-md-3 col-lg-2">
            <div class="gallery-item video">
              <img src="{{ asset('images/cat4.png') }}" class="img-fluid">
            </div>
          </div>

        </div>
      </div>

      <!-- section 2 -->
      <section class="py-4">
        <div class="container">

          <h4 class="fw-semibold mb-3">Similar Coupons</h4>

          <div class="row g-4">

            <!-- Card START -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/app1.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn">
                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                  </button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/app.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>
            <!-- Card END -->

            <!-- CARD 2 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/app2.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/app.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/app3.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/app.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
              <div class="new-offer-card">
                <div class="new-offer-img-box">

                  <span class="new-offer-tag">-50% OFF</span>
                  <img src="{{ asset('images/app4.png') }}" class="new-offer-image">

                  <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                  <button class="new-fav-btn"><span class="text-danger"><i class="fa-solid fa-heart"></i></span></button>
                </div>

                <div class="new-offer-content d-flex justify-content-between">
                  <div>
                    <h6 class="new-offer-title">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="new-offer-location">
                      <i class="fa-solid fa-location-dot"></i> Vadodara – 390005
                    </div>
                  </div>
                  <img src="{{ asset('images/app.png') }}" class="new-brand-img">
                </div>

              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- section 3 -->
      <section class="offer-sec container py-3">

        <h4 class="fw-semibold mb-3">Similar Products</h4>

        <div class="row g-4">

          <!-- CARD 1 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/app5.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/app.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">

                <!-- Mobile Text -->
                <button class="add-cart-full text-dark d-block d-md-none w-100">
                  Add to Cart
                </button>

                <!-- Desktop Text -->
                <button class="add-cart-full text-muted d-none d-md-block w-100">
                  2 Qty Added | <span class="text-orange">Add More</span>
                </button>

              </div>


            </div>
          </div>

          <!-- CARD 2 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/app6.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/app.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 3 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-30% OFF</span>

                <img src="{{ asset('images/app7.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Effortless Style, Exclusive Offers</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/app.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

          <!-- CARD 4 -->
          <div class="col-6 col-lg-3">
            <div class="new-offer-card">

              <div class="new-offer-img-box">
                <span class="new-offer-tag">-40% OFF</span>

                <img src="{{ asset('images/app8.png') }}" class="new-offer-image">

                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                <button class="new-fav-btn">
                  <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                </button>
              </div>

              <div class="new-offer-content d-flex justify-content-between">
                <div>
                  <h6 class="new-offer-title">Season Sale - Up to 40% OFF</h6>

                  <div class="new-offer-location">
                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                  </div>

                  <div class="new-offer-price mt-1">
                    <span class="old-price">₹3999</span>
                    <span class="new-price">₹1999</span>
                  </div>
                </div>

                <img src="{{ asset('images/app.png') }}" class="new-brand-img">
              </div>

              <div class="p-2">
                <button class="add-cart-full">Add to Cart</button>
              </div>

            </div>
          </div>

        </div>

      </section>

    </div>
  </div>
</div>




@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function openTab(tabName) {

    // Remove active class from all tabs
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));

    // Add active class to selected tab
    event.target.classList.add('active');

    // Hide all sections
    document.querySelectorAll('[id$="-section"]').forEach(sec => sec.style.display = 'none');

    // Show selected section
    document.getElementById(tabName + '-section').style.display = 'block';
  }
</script>

<script>
  $(document).ready(function() {
    $('.tabs-container .nav-link').on('click', function() {
      let tabText = $(this).text().trim();
      alert(tabText);
    });
  });
</script>




@endsection