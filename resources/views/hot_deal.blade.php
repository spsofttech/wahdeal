@extends('layouts.app')
@section('title', 'Home')
@section('styles')

@endsection

@section('content')


<!-- Category Section Starts Here -->
<div class="cate py-4" style="background-color: var(--nav-bg);">
    <div class="cate py-1" style="background-color: var(--nav-bg);">
        <div class="category mx-auto p-2 event">

            <div class="d-flex justify-content-center align-items-center text-white gap-2 flex-wrap" style="font-size: 15px; letter-spacing: 1px;">

                <a href="#" class="text-white text-decoration-none">HOME</a>

                <span>/</span>

                <a href="#" class="text-white text-decoration-none">DEALS & OFFERS</a>

            </div>

        </div>
    </div>

    <div class="category-container mx-auto p-2 event">

        <!-- Header with Search -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h2 class="mb-2 mb-md-0 text-light fw-400" style="font-size: 20px;">Popular Categories</h2>

            <div class="input-group rounded-pill bg-white shadow-sm" style="max-width: 300px; overflow: hidden;">
                <span class="input-group-text bg-transparent border-0 ps-3">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input
                    type="text"
                    class="form-control border-0 bg-transparent"
                    placeholder="Search for products..."
                    aria-label="Search">
            </div>
        </div>


        <!-- Category Carousel -->
        <div class="overflow-auto py-2">
            <div class="d-flex flex-nowrap gap-3">

                <!-- 1. View All -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/event.svg') }}" class="img-fluid mb-2" alt="View All" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="View All">View All</span>
                        <small class="text-light">(250)</small>
                    </div>
                </div>

                <!-- 2. Fashion Apparel -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/fashion.svg ') }}" class="img-fluid mb-2" alt="Fashion Apparel" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Fashion Apparel">Fashion Apparel</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 3. Restaurant -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/resto.svg') }}" class="img-fluid mb-2" alt="Restaurant" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Restaurant">Restaurant</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 4. Salon & SPA -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/salon.svg') }}" class="img-fluid mb-2" alt="Salon & SPA" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Salon & SPA">Salon & SPA</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 5. Education -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/edu.svg') }}" class="img-fluid mb-2" alt="Education" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Education">Education</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 6. Gym & Aerobics -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/gym.svg') }}" class="img-fluid mb-2" alt="Gym & Aerobics" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Gym & Aerobics">Gym & Aerobics</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 7. Electronics -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/elec.svg') }}" class="img-fluid mb-2" alt="Electronics" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Electronics">Electronics</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 8. Retailer -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/retail.svg') }}" class="img-fluid mb-2" alt="Retailer" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Retailer">Retailer</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 9. Home Services -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/home.svg') }}" class="img-fluid mb-2" alt="Home Services" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Home Services">Home Services</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 10. Health -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/health.svg') }}" class="img-fluid mb-2" alt="Health" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Health">Health</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 11. Hotel & Resort -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/hotel.svg') }}" class="img-fluid mb-2" alt="Hotel & Resort" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Hotel & Resort">Hotel & Resort</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 12. Automobile -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/auto.svg') }}" class="img-fluid mb-2" alt="Automobile" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Automobile">Automobile</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

                <!-- 13. Home & PG -->
                <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
                    <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('./svg/pg.svg') }}" class="img-fluid mb-2" alt="Home & PG" style="width: 50px; height: 50px;">
                        <span class="text-truncate d-block w-100" title="Home & PG">Home & PG</span>
                        <small class="text-light">(50)</small>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- section 1 -->
<div class="banner mt-3 container-fluid" id="slider">
    <div class="banner-scroll" id="slider">

        <div class="banner-item"><img src="{{ asset('images/hot2.png') }}"></div>
        <div class="banner-item"><img src="{{ asset('images/hot1.png') }}"></div>
        <div class="banner-item"><img src="{{ asset('images/hot2.png') }}"></div>
        <div class="banner-item"><img src="{{ asset('images/hot1.png') }}"></div>
        <div class="banner-item"><img src="{{ asset('images/hot3.png') }}"></div>
        <div class="banner-item"><img src="{{ asset('images/hot1.png') }}"></div>
    </div>
</div>

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
                <img src="{{ asset('images/offer4.png') }}" class="offer-img">
                <div class="img-rating">⭐ 4.5 • 20K</div>
                <img src="{{ asset('images/veg.png') }}" class="veg-img">
                <button class="fav-btn"><i class="fa-solid fa-heart text-danger"></i></button>
            </div>
            <div class="p-3 d-flex justify-content-between">
                <div>
                    <h6 class="fw-semibold mb-1">Flat ₹200 OFF on Buy Above ₹999</h6>
                    <div class="location"><i class="fa-solid fa-location-dot"></i> Vadodara – 390005</div>
                </div>
                <img src="{{ asset('images/subway.png') }}" class="brand-logo">
            </div>
        </div>

    </div>
</section>


<!-- Section 7 -->
<div class="banner mt-3 container-fluid" id="slider">
    <h3 class="w-100 text-center fw-bold" style="font-size: 24px;">
        Every Day deals For you
    </h3>
    <div class="banner-scroll" id="slider">

        <div class="banner-item"><img src="{{ asset('images/banner1.png') }}"></div>
        <div class="banner-item"><img src="{{ asset('images/banner1.png') }}"></div>
        <div class="banner-item"><img src="{{ asset('images/banner1.png') }}"></div>
        <div class="banner-item"><img src="{{ asset('images/banner1.png') }}"></div>
        <div class="banner-item"><img src="{{ asset('images/banner1.png') }}"></div>
        <div class="banner-item"><img src="{{ asset('images/banner1.png') }}"></div>
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


<!-- section 10 -->
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


<!-- section 11 -->
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


<!-- section 12 -->
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


<!-- section 13 -->
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


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
    const slider = document.getElementById("slider");
    let position = 0;

    function autoSlide() {
        const cardWidth = slider.children[0].offsetWidth + 12;

        slider.scrollTo({
            left: position,
            behavior: "smooth"
        });

        position += cardWidth;

        if (position >= slider.scrollWidth - slider.clientWidth) {
            position = 0;
        }
    }

    setInterval(autoSlide, 2000);

    window.onload = () => {
        const firstWidth = slider.children[0].offsetWidth + 12;
        slider.scrollTo({
            left: firstWidth / 2,
            behavior: "smooth"
        });
    };
</script>



@endsection