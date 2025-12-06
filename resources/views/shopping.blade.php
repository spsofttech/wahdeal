@extends('layouts.app')
@section('title', 'Home')
@section('styles')
<style>
    .tabs-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        background: #fff;
        overflow-x: auto;
        white-space: nowrap;
    }

    .tab {
        flex: 1;
        text-align: center;
        font-weight: 600;
        padding: 6px 12px;
        cursor: pointer;
        color: #333;
        flex-shrink: 0;
        text-decoration: none;
    }

    .tab.active {
        background: #FF6A00;
        color: #fff;
    }

    .tab:hover {
        background: #FF6A00;
        color: #fff;
    }

    /* Active tab (default) */
    .tab.active {
        background: #FF6A00;
        color: #fff;
    }

    /* Hover effect – but override active only during hover */
    .tabs-container:hover .tab.active {
        background: transparent;
        color: #333;
    }

    /* Hovered tab becomes highlighted */
    .tab:hover {
        background: #FF6A00 !important;
        color: #fff !important;
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
        padding: 14px;
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

    /* Add to Cart Button */
    .add-cart-btn {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: #ff7a00;
        color: #fff;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
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



    /* Mobile */
    @media (max-width: 576px) {
        .tab {
            font-size: 10px;
            padding: 6px 10px;
        }

        .tabs-container {
            width: 93% !important;
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
    }
</style>
@endsection

@section('content')


<div class="shopping-page" style="background-color: var(--light-bg);">

    <!-- section 1 -->
    <div class="container">
        <div class="row g-3">

            <!-- Card 1: Image -->
            <div class="col-lg-5 col-md-5 col-12">
                <div class="card h-100 shadow-sm p-0 border-0 overflow-hidden">
                    <img src="{{ asset('images/zara_store.png') }}"
                        class="img-fluid w-100 h-100 object-fit-cover"
                        alt="Zara Store" style="min-height: 220px;">
                </div>
            </div>

            <!-- Card 2: Content -->
            <div class="col-lg-7 col-md-7 col-12">
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
                            <i class="fas fa-heart text-danger fs-5"></i>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

                </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-6 col-lg-3">
                <div class="new-offer-card">

                    <div class="new-offer-img-box">
                        <span class="new-offer-tag">-50% OFF</span>

                        <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                        <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                        <button class="new-fav-btn">
                            <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                        </button>
                    </div>

                    <div class="new-offer-content d-flex justify-content-between">
                        <div>
                            <h6 class="new-offer-title">Timeless Pieces at Irresistible Prices</h6>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

                </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-6 col-lg-3">
                <div class="new-offer-card">

                    <div class="new-offer-img-box">
                        <span class="new-offer-tag">-50% OFF</span>

                        <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                        <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                        <button class="new-fav-btn">
                            <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                        </button>
                    </div>

                    <div class="new-offer-content d-flex justify-content-between">
                        <div>
                            <h6 class="new-offer-title">Timeless Pieces at Irresistible Prices</h6>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

                </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-6 col-lg-3">
                <div class="new-offer-card">

                    <div class="new-offer-img-box">
                        <span class="new-offer-tag">-50% OFF</span>

                        <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                        <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                        <button class="new-fav-btn">
                            <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                        </button>
                    </div>

                    <div class="new-offer-content d-flex justify-content-between">
                        <div>
                            <h6 class="new-offer-title">Timeless Pieces at Irresistible Prices</h6>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

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

                    <button class="add-cart-btn"><i class="fa-solid fa-plus"></i></button>

                </div>
            </div>

        </div>

    </section>

</div>





@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Dropdown toggle
    document.addEventListener("click", (e) => {
        const toggle = e.target.closest(".dropdown-toggle");
        const dropdown = toggle ? toggle.closest(".dropdown") : null;
        document.querySelectorAll('.dropdown[aria-expanded="true"]').forEach(el => {
            if (el !== dropdown) el.setAttribute("aria-expanded", "false");
        });
        if (dropdown) {
            dropdown.setAttribute("aria-expanded", dropdown.getAttribute("aria-expanded") !== "true");
        }
    });

    // Drawer Logic
    const hamburger = document.getElementById("hamburger");
    const drawer = document.getElementById("mobile-drawer");
    const overlay = document.getElementById("overlay");
    const closeDrawer = document.getElementById("closeDrawer");

    function openDrawer() {
        drawer.classList.add("open");
        overlay.classList.add("show");
    }

    function closeDrawerFn() {
        drawer.classList.remove("open");
        overlay.classList.remove("show");
    }

    hamburger.addEventListener("click", openDrawer);
    closeDrawer.addEventListener("click", closeDrawerFn);
    overlay.addEventListener("click", closeDrawerFn);
</script>
@endsection