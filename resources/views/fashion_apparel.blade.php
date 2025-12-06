<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion apparel</title>

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('web/main.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        .cate {
            margin: 0;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: start;
            margin-bottom: 20px;

        }

        .header p {
            margin: 0;
            font-size: 1.2em;
            font-weight: bold;
            color: #555;
        }

        .main-content {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        /* Filters Sidebar */
        .filters {
            flex: 0 0 280px;
            background-color: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            align-self: flex-start;
            /* position: sticky;  */
            top: 20px;
            height: fit-content;
        }

        .filter-section h4 {
            margin-top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.1em;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .filter-section h4 i {
            color: #ff7004;
        }

        .filter-group {
            margin-bottom: 15px;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding: 8px 0;
            /* border-bottom: 1px solid #eee; */
        }

        .filter-header h5 {
            margin: 0;
            font-size: 1em;
            color: #555;
        }

        .filter-options {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            padding-top: 0;
            padding-bottom: 0;
        }

        .filter-options.active {
            max-height: 500px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .filter-options label {
            display: block;
            margin-bottom: 8px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-options label i {
            color: #888;
            font-size: 0.9em;
        }

        .filter-options input[type="checkbox"] {
            margin-right: 8px;
            accent-color: #ff7004;
        }

        /* Price Slider */
        .price-range {
            position: relative;
            height: 40px;
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .price-range input[type="range"] {
            position: absolute;
            width: 100%;
            -webkit-appearance: none;
            height: 5px;
            background: #ddd;
            border-radius: 5px;
            outline: none;
            opacity: 0.7;
            transition: opacity .2s;
            pointer-events: none;
        }

        .price-range input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #ff7004;
            border-radius: 50%;
            cursor: pointer;
            pointer-events: all;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .price-range input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #ff7004;
            border-radius: 50%;
            cursor: pointer;
            pointer-events: all;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        /* Custom track for the filled portion */
        .price-range .slider-track {
            position: absolute;
            height: 5px;
            background: #ff7004;
            border-radius: 5px;
            z-index: 1;
        }


        .price-labels {
            position: absolute;
            width: 100%;
            display: flex;
            justify-content: space-between;
            top: 0px;
            /* Adjusted position */
            font-size: 0.9em;
            color: #777;
        }

        /* Color Swatches */
        .color-palette {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 10px;
        }

        .color-swatch {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid transparent;
            /* Default transparent border */
            cursor: pointer;
            transition: border-color 0.2s, transform 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .color-swatch:hover {
            transform: scale(1.1);
        }

        .color-swatch.selected {
            border-color: #ff3300ff;
            transform: scale(1.1);
        }

        /* Specific colors */
        .color-swatch.green {
            background-color: #4CAF50;
        }

        .color-swatch.red {
            background-color: #F44336;
        }

        .color-swatch.yellow {
            background-color: #FFEB3B;
        }

        .color-swatch.orange {
            background-color: #FF9800;
        }

        .color-swatch.blue {
            background-color: #2196F3;
        }

        .color-swatch.purple {
            background-color: #9C27B0;
        }

        .color-swatch.pink {
            background-color: #E91E63;
        }

        .color-swatch.white {
            background-color: #FFFFFF;
            border: 1px solid #ccc;
        }

        .color-swatch.black {
            background-color: #000000;
        }


        /* Size Buttons */
        .size-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding-top: 10px;
        }

        .size-btn {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            cursor: pointer;
            transition: background-color 0.2s, border-color 0.2s, color 0.2s;
            font-size: 0.9em;
            min-width: 60px;
            text-align: center;
        }

        .size-btn:hover {
            background-color: #eee;
            border-color: #ff7004;
        }

        .size-btn.selected {
            background-color: #ff7004;
            color: #fff;
            border-color: #ff7004;
        }

        .apply-filter-btn {
            width: 100%;
            padding: 10px;
            background-color: #ff7004;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.2s;
        }

        .apply-filter-btn:hover {
            background-color: #e65c00;
        }


        /* Product Grid */
        .product-grid {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }



        /* Custom scrollbar for Webkit browsers */
        .product-grid::-webkit-scrollbar {
            width: 8px;
        }

        .filter-header i {
            color: #5c5b5bff;
        }

        .price-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 15px;
            /* adjust spacing as needed */
        }

        .prices {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .old-price {
            text-decoration: line-through;
            color: #888;
            font-size: 14px;
            margin-right: 6px;
        }

        .new-price {
            font-size: 15px;
            font-weight: 600;
            color: #222;
        }

        .price-top {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .offer-percent {
            color: #00b050;
            font-size: 14px;
            font-weight: 600;
            margin-top: 4px;
        }

        .add-btn {
            background: #ff6600;
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
        }

        .offer-card {
            max-height: 330px;
        }

        /* Location */
        .location {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #555;
            margin: 0 15px;
            margin-top: -10px;
        }

        .location i {
            margin-right: 6px;
            color: red;
        }


        /* FASHION DETAILS SECTION CSS */
        .product-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            max-width: 1200px;
            width: 100%;
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        /* Left Side: Image Gallery */
        .product-gallery {
            display: flex;
            flex-direction: column;
        }

        .main-image-container {
            position: relative;
            margin-bottom: 15px;
        }

        .main-image {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #f0f0f0;
        }

        .wishlist-button {
            position: absolute;
            top: 15px;
            right: 15px;
            background: white;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            border: 1px solid #eee;
        }

        .wishlist-button svg {
            width: 20px;
            height: 20px;
            color: #555;
        }

        .thumbnail-slider {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnails {
            display: flex;
            gap: 12px;
            overflow: hidden;
            padding: 0 40px;
        }

        .thumbnail-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .thumbnail-img.active,
        .thumbnail-img:hover {
            border-color: #F57224;
        }

        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: 1px solid #ddd;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            color: #333;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }

        .arrow-left {
            left: 0;
        }

        .arrow-right {
            right: 0;
        }

        /* Right Side: Product Details */
        .product-details {
            display: flex;
            flex-direction: column;
        }

        .ratting {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .stars {
            color: #FFC107;
        }

        .stars .star-inactive {
            color: #E0E0E0;
        }

        .ratting span {
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .product-title {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            line-height: 1.3;
            color: #000;
        }

        .product-info {
            font-size: 13px;
            color: #757575;
            margin: 15px 0 20px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .product-info span {
            color: #424242;
            font-weight: 500;
        }

        .product-pricing {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .current-price {
            font-size: 32px;
            font-weight: bold;
            color: #F57224;
        }

        .original-price {
            font-size: 20px;
            text-decoration: line-through;
            color: #757575;
        }

        .discount-tag {
            background: #fef4e8;
            color: #F57224;
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 14px;
        }

        .options-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 15px;
            color: #212121;
        }

        .color-selector {
            display: flex;
            flex-direction: column;
            /* gap: 10px; */
            /* margin-bottom: 25px; */
        }

        .color-swatch {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            padding: 2px;
            background-clip: content-box;
            transition: border-color 0.3s;
        }

        .color-swatch.active {
            /* border-color: #F57224; */
        }

        .size-selector {
            margin-bottom: 25px;
        }

        .size-dropdown {
            width: 100%;
            width: 200px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            color: #555;
            appearance: none;
            background: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e") no-repeat right 12px center;
            background-size: 20px;
        }

        .actions {
            display: grid;
            grid-template-columns: auto 1fr 1fr;
            gap: 15px;
            align-items: center;
            margin-bottom: 30px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .quantity-selector button {
            border: none;
            background: transparent;
            font-size: 24px;
            font-weight: 300;
            padding: 5px 15px;
            cursor: pointer;
            color: #555;
        }

        .quantity-selector .quantity {
            font-size: 18px;
            font-weight: 500;
            padding: 5px 15px;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            color: #555;
        }

        .btn {
            padding: 15px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            border: 1px solid;
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-add-to-cart {
            background: #F57224;
            color: white;
            border-color: #F57224;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-add-to-cart:hover {
            background: #d9681e;
            border-color: #d9681e;
        }

        .btn-buy-now {
            background: white;
            color: #F57224;
            border-color: #F57224;
        }

        .btn-buy-now:hover {
            background: #fef4e8;
        }

        .product-description h3,
        .checkout-guarantee h3,
        .delivery-details h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 10px 0;
            padding-bottom: 10px;

            color: #000;
        }

        .checkout-guarantee {
            border: 1px solid #eee;
            padding: 10px;
            background: #eee
        }

        .product-description p {
            font-size: 14px;
            color: #555;
            line-height: 1.7;
            margin: 0 0 15px 0;
        }

        .checkout-guarantee {
            margin-top: 20px;
        }

        .payment-methods {
            height: 26px;
            object-fit: cover;

        }

        .delivery-details {
            margin-top: 20px;
            color: #555
        }

        /* ---------------------------------------- */


        /* Responsive Design */
        @media (max-width: 992px) {
            .main-content {
                flex-direction: column;
                padding: 0 20px;
            }

            .filters {
                width: 100%;
                flex: auto;
                position: static;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .filter-section h4 {
                font-size: 1em;
            }

            .filter-header h5 {
                font-size: 0.95em;
            }

            .size-btn {
                padding: 6px 10px;
                font-size: 0.9em;
            }
        }

        @media (max-width: 480px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .filter-options label,
            .filter-options input {
                font-size: 0.9em;
            }
        }
    </style>
</head>

<body>
    <!-- banner Section -->
    <section class="breadcrumb-section">
        <div class="breadcrumb-container">
            <span class="breadcrumb-home">HOME /</span>
            <span>FASHION APPAREL</span>

        </div>
    </section>
    <!-- ----------------------------------------------------------------------------------------------- -->

    <!-- Category Section Ends Here -->
    <div class='cate'>
        <div class="categories-section">
            <div class="categories-header">
                <img src="{{ asset('images/heading6.png') }}" alt="Summer fashion" style="width: auto; height: 40px;" />
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for products...">
                </div>
            </div>

            <div class="categories-wrapper">
                <div class="category-card active">
                    <img src="./svg/event.svg" alt="Event">
                    <span class="category-name">Event</span>
                    <span class="count">(250)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/fashion.svg" alt="Fashion">
                    <span class="category-name">Fashion Apparel</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/resto.svg" alt="Restaurant">
                    <span class="category-name">Restaurant</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/salon.svg" alt="Salon">
                    <span class="category-name">Salon & SPA</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/edu.svg" alt="Education">
                    <span class="category-name">Education</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/gym.svg" alt="Gym">
                    <span class="category-name">Gym and Aerobics</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/elec.svg" alt="Electronic">
                    <span class="category-name">Electronic</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/retail.svg" alt="Retailer">
                    <span class="category-name">Retailer</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/home.svg" alt="Home Services">
                    <span class="category-name">Home services</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/health.svg" alt="Health">
                    <span class="category-name">Health</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/hotel.svg" alt="Hotel">
                    <span class="category-name">Hotel & Resort</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/auto.svg" alt="Hotel">
                    <span class="category-name">AutoMobile</span>
                    <span class="count">(50)</span>
                </div>
                <div class="category-card">
                    <img src="./svg/pg.svg" alt="Hotel">
                    <span class="category-name">Home & Pg</span>
                    <span class="count">(50)</span>
                </div>
            </div>
        </div>
    </div>
    <!-- --------------------------------------------------------------------------------------------------- -->

    <!-- FASHION APPAREL SECTION -->
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/heading21.png') }}" alt="Summer fashion" style="width: auto; height: 40px;" />
        </div>

        <div class="main-content">
            <aside class="filters">
                <div class="filter-section">
                    <h4>Filters <i class="fas fa-filter"></i></h4>
                </div>

                <div class="filter-group">
                    <div class="filter-header">
                        <h5>T-shirts</h5><i class="fas fa-chevron-right"></i>
                    </div>

                </div>

                <div class="filter-group">
                    <div class="filter-header">
                        <h5>Shorts</h5><i class="fas fa-chevron-right"></i>
                    </div>

                </div>
                <div class="filter-group">
                    <div class="filter-header">
                        <h5>Shirts</h5><i class="fas fa-chevron-right"></i>
                    </div>

                </div>
                <div class="filter-group">
                    <div class="filter-header">
                        <h5>Hoodie</h5><i class="fas fa-chevron-right"></i>
                    </div>

                </div>
                <div class="filter-group" style="border-bottom: 1px solid #eee; ">
                    <div class="filter-header">
                        <h5>Jeans</h5><i class="fas fa-chevron-right"></i>
                    </div>

                </div>


                <div class="filter-group">
                    <div class="filter-header">
                        <h5>Price</h5><i class="fas fa-chevron-up" style="color: #5c5b5bff"></i>
                    </div>
                    <div class="filter-options price-slider-options active">
                        <div class="price-range">
                            <input type="range" min="100" max="2000" value="500" class="slider" id="minPrice">
                            <input type="range" min="100" max="2000" value="2000" class="slider" id="maxPrice">
                            <div class="slider-track" id="sliderTrack"></div>
                            <div class="price-labels">
                                <span id="minPriceValue">₹0</span> <span id="maxPriceValue">₹2000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-header">
                        <h5>Colors</h5><i class="fas fa-chevron-up" style="color: #5c5b5bff"></i>
                    </div>
                    <div class="filter-options color-options active">
                        <div class="color-palette">
                            <div class="color-swatch green" data-color="green"></div>
                            <div class="color-swatch red" data-color="red"></div>
                            <div class="color-swatch yellow" data-color="yellow"></div>
                            <div class="color-swatch orange" data-color="orange"></div>
                            <div class="color-swatch blue selected" data-color="blue"></div>
                            <div class="color-swatch purple" data-color="purple"></div>
                            <div class="color-swatch pink" data-color="pink"></div>
                            <div class="color-swatch white" data-color="white"></div>
                            <div class="color-swatch black" data-color="black"></div>
                        </div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-header">
                        <h5>Size</h5><i class="fas fa-chevron-up" style="color: #5c5b5bff"></i>
                    </div>
                    <div class="filter-options size-options active">
                        <div class="size-grid">
                            <button class="size-btn" data-size="xxs">XX-Small</button>
                            <button class="size-btn" data-size="xs">X-Small</button>
                            <button class="size-btn" data-size="s">Small</button>
                            <button class="size-btn" data-size="m">Medium</button>
                            <button class="size-btn selected" data-size="l">Large</button>
                            <button class="size-btn" data-size="xl">X-Large</button>
                            <button class="size-btn" data-size="xxl">XX-Large</button>
                            <button class="size-btn" data-size="3xl">3X-Large</button>
                            <button class="size-btn" data-size="6xl">6X-Large</button>
                        </div>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-header">
                        <h5>Dress Style</h5><i class="fas fa-chevron-up" style="color: #5c5b5bff"></i>
                    </div>
                    <div class="filter-options dress-style-options active" style="color: #ccc">
                        <div class="filter-group">
                            <div class="filter-header">
                                <h5>Casual</h5><i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="filter-header">
                                <h5>Formal</h5><i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="filter-header">
                                <h5>Party</h5><i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="filter-header">
                                <h5>Gym</h5><i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="apply-filter-btn">Apply Filter</button>
            </aside>

            <section class="product-grid">
                <!-- Product Card 1 -->
                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash6.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash7.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash8.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash3.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash4.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash5.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash17.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash16.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash9.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash10.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash11.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash12.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash1.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash2.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- ----------------------------------------------------------------------------------------------------- -->

    <button class="show-more-btn">
        Show More
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M7 13l5 5 5-5" />
            <path d="M7 6l5 5 5-5" />
        </svg>
    </button>
    <!-- -------------------------------------------------------------------------------------------------------- -->

    <!-- Top Fashion Section -->
    <div class='cate' style="margin-top: 20px">
        <div class="banners2" style="margin-top: -20px;">
            <div class='brand1'
                style="display: flex; justify-content: space-between; align-items: center; margin-top: 2%;">
                <img src="{{ asset('images/heading22.png') }}" alt="Summer fashion"
                    style="width: auto; height: 40px;" />
                <p class='text' style="color: rgba(255, 107, 0, 1); font-weight: 600; cursor: pointer; margin: 0;">
                    VIEW ALL >>
                </p>
            </div>
            <div class="offers-grid " style="margin-top: 2%">
                <!-- Offer Card Example -->
                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash1.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash2.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash3.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>
                <!-- Repeat cards as needed... -->
            </div>
        </div>
    </div>
    <!-- --------------------------------------------------------------------------------------------------- -->

    <!-- Download Section -->
    <section class="download-section" style="margin: 0">
        <div class="download-container">

            <div class="download-content">
                <h1 class="download-heading">DOWNLOAD APP GET EXCITING<br>AMAZING DISCOUNTS</h1>
                <p class="download-description">
                    Join thousands of happy users already unlocking amazing discounts and shopping smarter every day.
                </p>
                <p class="download-stores-title">Available On</p>
                <div class="download-buttons-wrapper">
                    <a href="#" class="download-button" aria-label="Get it on Google Play">
                        <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.50368 0.662891C0.290527 0.944563 0.171875 1.29106 0.171875 1.66186V16.3379C0.171875 16.6824 0.274602 17.0059 0.460156 17.2762L8.44555 8.94687L0.50368 0.662891ZM9.17669 8.18415L11.7673 5.48204L2.66108 0.224739C2.26592 -0.00356585 1.81244 -0.0576713 1.38934 0.0612623L9.17669 8.18415ZM9.17669 9.70948L1.31059 17.9143C1.47838 17.9709 1.65427 17.9999 1.83136 18C2.11633 18 2.40142 17.925 2.66111 17.7751L11.8328 12.4798L9.17669 9.70948ZM15.3709 7.56273L12.7087 6.02563L9.90798 8.94676L12.774 11.9364L15.3709 10.437C15.8906 10.1371 16.2008 9.59975 16.2008 8.99988C16.2008 8.39991 15.8906 7.86265 15.3709 7.56273Z"
                                fill="#333333" />
                        </svg>
                        <span>Google Play Store</span>
                    </a>

                    <a href="#" class="download-button" aria-label="Download on the App Store">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.9588 4.10428C14.8557 3.71983 14.6092 3.39844 14.2645 3.19947C13.553 2.78867 12.6399 3.03323 12.229 3.74492L11.9996 4.14213L11.7702 3.74486C11.3594 3.03335 10.4463 2.78867 9.73472 3.19941C9.02315 3.61027 8.77847 4.52336 9.18927 5.23499L10.2789 7.12233L6.25831 14.0863H3.32704C2.50539 14.0863 1.83691 14.7548 1.83691 15.5764C1.83691 16.3981 2.50539 17.0666 3.32704 17.0666H14.6437L12.923 14.0863H9.69961L14.8099 5.23505C15.0089 4.89035 15.0618 4.48873 14.9588 4.10428Z"
                                fill="#333333" />
                            <path
                                d="M20.6725 14.0858H17.7413L14.4089 8.31403L12.6883 11.2943L17.8623 20.2558C18.0613 20.6006 18.3826 20.8471 18.7671 20.9502C18.8955 20.9846 19.0258 21.0016 19.1552 21.0016C19.4134 21.0016 19.6683 20.9339 19.898 20.8013C20.6095 20.3904 20.8542 19.4773 20.4433 18.7658L19.4619 17.0661H20.6725C21.4942 17.0661 22.1627 16.3976 22.1627 15.576C22.1627 14.7543 21.4942 14.0858 20.6725 14.0858ZM3.84983 18.2582L3.55675 18.7658C3.14595 19.4774 3.39063 20.3905 4.10219 20.8013C4.32784 20.932 4.584 21.0007 4.84475 21.0006C5.3601 21.0006 5.86204 20.7334 6.13777 20.2559L7.29113 18.2582H3.84983Z"
                                fill="#333333" />
                        </svg>
                        <span>Apple App Store</span>
                    </a>
                </div>
            </div>
            <div class="download-image-wrapper">
                <img src="{{ asset('images/phone.png') }}" alt="App interface on a smartphone held in hands">
            </div>
        </div>
    </section>
    <!-- --------------------------------------------------------------------------------------------------------- -->

    <!-- FASHION DETAILS SECTION -->
    <div class="product-container">
        <div class="product-gallery">
            <div class="main-image-container">
                <img src="{{ asset('images/jac.png') }}" alt="Cotton Jacket" class="main-image">
                <div class="wishlist-button">
                    <svg xmlns="" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-1.113 2.175-.239 5.244 2.135 7.429l.289.273.001.001.002.002.003.003.004.004.005.004.006.005.007.005.008.006.009.006.01.006.011.006.012.005.013.005.014.005.015.004.016.004.017.003.018.003.019.003.02.002.021.002.022.002.023.001.024.001.025.001.026.001.027.001.028 0 .029 0 .03 0 .031-.001.032-.001.033-.001.034-.001.035-.001.036-.002.037-.002.038-.002.039-.003.04-.003.041-.003.042-.004.043-.004.044-.005.045-.005.046-.005.047-.006.048-.006.049-.006.05-.007.051-.008.052-.008.053-.009.054-.01.055-.01.056-.011.057-.012.058-.013.059-.014.06-.015.06-.016.061-.017.062-.018.063-.019.064-.02.065-.021.066-.022.067-.023.068-.024.069-.025.07-.026.071-.027.072-.028.073-.029.074-.03.075-.031.076-.032.077-.033.078-.034.079-.035.08-.036.081-.037.082-.038.083-.039.084-.04.085-.041.086-.042.087-.043.088-.044.089-.045.09-.046.091-.047.092-.048.093-.049.094-.05.095-.051.096-.052.097-.053.098-.054.099-.055.1-.056.101-.057.102-.058.103-.059.104-.06.105-.061.106-.062.107-.063.108-.064.109-.065.11-.066.111-.067.112-.068.113-.069.114-.07.115-.071.116-.072.117-.073.118-.074.119-.075.12-.076.121-.077.122-.078.123-.079.124-.08.125-.081.126-.082.127-.083.128-.084.129-.085.13-.086.131-.087.132-.088.133-.089.134-.09.135-.091.136-.092.137-.093.138-.094.139-.095.14-.096.141-.097.142-.098.143-.099.144-.1.145-.101.146-.102.147-.103.148-.104.149-.105.15-.106.151-.107.152-.108.153-.109.154-.11.155-.111.156-.112.157-.113.158-.114.159-.115.16-.116.161-.117.162-.118.163-.119.164-.12.165-.121.166-.122.167-.123.168-.124.169-.125.17-.126.171-.127.172-.128.173-.129.174-.13.175-.131.176-.132.177-.133.178-.134.179-.135.18-.136.181-.137.182-.138.183-.139.184-.14.185-.141.186-.142.187-.143.188-.144.189-.145.19-.146.191-.147.192-.148.193-.149.194-.15.195-.151.196-.152.197-.153.198-.154.199-.155.2-.156.201-.157.202-.158.203-.159.204-.16.205-.161.206-.162.207-.163.208-.164.209-.165.21-.166.211-.167.212-.168.213-.169.214-.17.215-.171.216-.172.217-.173.218-.174.219-.175.22-.176.221-.177.222-.178.223-.179.224-.18.225-.181.226-.182.227-.183.228-.184.229-.185.23-.186.231-.187.232-.188.233-.189.234-.19.235-.191.236-.192.237-.193.238-.194.239-.195.24-.196.241-.197.242-.198.243-.199.244-.2.245-.201.246-.202.247-.203.248-.204.249-.205.25-.206.251-.207.252-.208.253-.209.254-.21.255-.211.256-.212.257-.213.258-.214.259-.215.26-.216.261-.217.262-.218.263-.219.264-.22.265-.221.266-.222.267-.223.268-.224.269-.225.27-.226.271-.227.272-.228.273-.229.274-.23.275-.231.276-.232.277-.233.278-.234.279-.235.28-.236.281-.237.282-.238.283-.239.284-.24.285-.241.286-.242.287-.243.288-.244.289-.245.29-.246.291-.247.292-.248.293-.249.294-.25.295-.251.296-.252.297-.253.298-.254.299-.255.3-.256.301-.257.302-.258.303-.259.304-.26.305-.261.306-.262.307-.263.308-.264.309-.265.31-.266.311-.267.312-.268.313-.269.314-.27.315-.271.316-.272.317-.273.318-.274.319-.275.32-.276.321-.277.322-.278.323-.279.324-.28.325-.281.326-.282.327-.283.328-.284.329-.285.33-.286.331-.287.332-.288.333-.289.334-.29.335-.291.336-.292.337-.293.338-.294.339-.295.34-.296.341-.297.342-.298.343-.299.344-.3.345-.301.346-.302.347-.303.348-.304.349-.305.35-.306.351-.307.352-.308.353-.309.354-.31.355-.311.356-.312.357-.313.358-.314.359-.315.36-.316.361-.317.362-.318.363-.319.364-.32.365-.321.366-.322.367-.323.368-.324.369-.325.37-.326.371-.327.372-.328.373-.329.374-.33.375-.331.376-.332.377-.333.378-.334.379-.335.38-.336.381-.337.382-.338.383-.339.384-.34.385-.341.386-.342.387-.343.388-.344.389-.345.39-.346.391-.347.392-.348.393-.349.394-.35.395-.351.396-.352.397-.353.398-.354.399-.355.4-.356.401-.357.402-.358.403-.359.404-.36.405-.361.406-.362.407-.363.408-.364.409-.365.41-.366.411-.367.412-.368.413-.369.414-.37.415-.371.416-.372.417-.373.418-.374.419-.375.42-.376.421-.377.422-.378.423-.379.424-.38.425-.381.426-.382.427-.383.428-.384.429-.385.43-.386.431-.387.432-.388.433-.389.434-.39.435-.391.436-.392.437-.393.438-.394.439-.395.44-.396.441-.397.442-.398.443-.399.444-.4.445-.401.446-.402.447-.403.448-.404.449-.405.45-.406.451-.407.452-.408.453-.409.454-.41.455-.411.456-.412.457-.413.458-.414.459-.415.46-.416.461-.417.462-.418.463-.419.464-.42.465-.421.466-.422.467-.423.468-.424.469-.425.47-.426.471-.427.472-.428.473-.429.474-.43.475-.431.476-.432.477-.433.478-.434.479-.435.48-.436.481-.437.482-.438.483-.439.484-.44.485-.441.486-.442.487-.443.488-.444.489-.445.49-.446.491-.447.492-.448.493-.449.494-.45.495-.451.496-.452.497-.453.498-.454.499-.455.5-.456.501-.457.502-.458.503-.459.504-.46.505-.461.506-.462.507-.463.508-.464.509-.465.51-.466.511-.467.512-.468.513-.469.514-.47.515-.471.516-.472.517-.473.518-.474.519-.475.52-.476.521-.477.522-.478.523-.479.524-.48.525-.481.526-.482.527-.483.528-.484.529-.485.53-.486.531-.487.532-.488.533-.489.534-.49.535-.491.536-.492.537-.493.538-.494.539-.495.54-.496.541-.497.542-.498.543-.499.544-.5.545-.501.546-.502.547-.503.548-.504.549-.505.55-.506.551-.507.552-.508.553-.509.554-.51.555-.511.556-.512.557-.513.558-.514.559-.515.56-.516.561-.517.562-.518.563-.519.564-.52.565-.521.566-.522.567-.523.568-.524.569-.525.57-.526.571-.527.572-.528.573-.529.574-.53.575-.531.576-.532.577-.533.578-.534.579-.535.58-.536.581-.537.582-.538.583-.539.584-.54.585-.541.586-.542.587-.543.588-.544.589-.545.59-.546.591-.547.592-.548.593-.549.594-.55.595-.551.596-.552.597-.553.598-.554.599-.555.6-.556.601-.557.602-.558.603-.559.604-.56.605-.561.606-.562.607-.563.608-.564.609-.565.61-.566.611-.567.612-.568.613-.569.614-.57.615-.571.616-.572.617-.573.618-.574.619-.575.62-.576.621-.577.622-.578.623-.579.624-.58.625-.581.626-.582.627-.583.628-.584.629-.585.63-.586.631-.587.632-.588.633-.589.634-.59.635-.591.636-.592.637-.593.638-.594.639-.595.64-.596.641-.597.642-.598.643-.599.644-.6.645-.601.646-.602.647-.603.648-.604.649-.605.65-.606.651-.607.652-.608.653-.609.654-.61.655-.611.656-.612.657-.613.658-.614.659-.615.66-.616.661-.617.662-.618.663-.619.664-.62.665-.621.666-.622.667-.623.668-.624.669-.625.67-.626.671-.627.672-.628.673-.629.674-.63.675-.631.676-.632.677-.633.678-.634.679-.635.68-.636.681-.637.682-.638.683-.639.684-.64.685-.641.686-.642.687-.643.688-.644.689-.645.69-.646.691-.647.692-.648.693-.649.694-.65.695-.651.696-.652.697-.653.698-.654.699-.655.7-.656.701-.657.702-.658.703-.659.704-.66.705-.661.706-.662.707-.663.708-.664.709-.665.71-.666.711-.667.712-.668.713-.669.714-.67.715-.671.716-.672.717.718c-.324.325-.324.851 0 1.176l6.364 6.364c.324.325.85.325 1.176 0l.288-.289c.324-.325.324-.851 0-1.176L9.449 8.5l6.082-6.082c.324-.325.324-.851 0-1.176l-.288-.289c-.325-.324-.851-.324-1.176 0L8 6.551 2.21 1.76c-.325-.324-.851-.324-1.176 0l-.289.289c-.324.325-.324.851 0 1.176L6.551 8 .76 13.79c-.324.325-.324.851 0 1.176l.289.289c.325.324.851.324 1.176 0L8 9.449l5.79 5.79c.324.325.851.325 1.176 0l.289-.289c.324-.325.324-.851 0-1.176L9.449 8z" />
                    </svg>
                </div>
            </div>
            <div class="thumbnail-slider">
                <div class="slider-arrow arrow-left">&#10094;</div>
                <div class="thumbnails">
                    <img src="{{ asset('images/jac1.png') }}" alt="Thumbnail 1" class="thumbnail-img">
                    <img src="{{ asset('images/jac2.png') }}" alt="Thumbnail 2" class="thumbnail-img">
                    <img src="{{ asset('images/jac3.png') }}" alt="Thumbnail 3" class="thumbnail-img">
                    <img src="{{ asset('images/jac4.png') }}" alt="Thumbnail 4" class="thumbnail-img active">
                    <img src="{{ asset('images/jac5.png') }}" alt="Thumbnail 5" class="thumbnail-img">
                    <img src="{{ asset('images/jac6.png') }}" alt="Thumbnail 5" class="thumbnail-img">
                </div>
                <div class="slider-arrow arrow-right">&#10095;</div>
            </div>
        </div>

        <div class="product-details">
            <div class="ratting">
                <div class="stars">
                    &#9733;&#9733;&#9733;&#9733;<span class="star-inactive">&#9733;</span>
                </div>
                <span>4.7 Star Rating</span>
            </div>

            <h1 class="product-title">Cotton Jacket with Exclusive Design</h1>

            <div class="product-info">
                SKU: A264671&nbsp;&nbsp;|&nbsp;&nbsp;Brand: <span>Gucci</span>&nbsp;&nbsp;|&nbsp;&nbsp;Availability:
                <span style="color: green;">In Stock</span>
            </div>

            <div class="product-pricing">
                <span class="current-price">₹1699</span>
                <span class="original-price">₹1999.00</span>
                <span class="discount-tag">21% OFF</span>
            </div>

            <div style="display: flex; justify-content: space-between">

                <div class="options-group color-selector">
                    <label>Color</label>
                    <div style="display: flex">
                        <div class="color-swatch active" style="background-color: #5d3a31;"></div>
                        <div class="color-swatch" style="background-color: #808080;"></div>
                    </div>
                </div>

                <div class="options-group size-selector">
                    <label for="size">Size</label>
                    <select id="size" class="size-dropdown">
                        <option>--- Select Size ---</option>
                        <option>Small</option>
                        <option>Medium</option>
                        <option>Large</option>
                        <option>Extra Large</option>
                    </select>
                </div>
            </div>

            <div class="actions">
                <div class="quantity-selector">
                    <button>-</button>
                    <span class="quantity">01</span>
                    <button>+</button>
                </div>

                <a href="{{ route('cart') }}" class="btn btn-add-to-cart"
                    style="text-align: center; text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.49.402H3.21l.938 4.691a.5.5 0 0 1-.976.218L2.09 11.21l-.938-4.69A.5.5 0 0 1 .5 6H1a.5.5 0 0 1 0-1h-.5A.5.5 0 0 1 0 1.5zM2.903 4l.75 3.747h10.094l.75-3.747H2.903zM5 12a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm5.5 2a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm5.5-2a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                    </svg>
                    ADD TO CART
                </a>
                <a href="{{ route('order_summary') }}" class="btn btn-buy-now"
                    style="text-align: center; text-decoration: none;"> BUY NOW</a>
            </div>

            <div class="product-description">
                <h3>Product Detail</h3>
                <p>Culpa aliquam consequuntur veritatis at consequuntur praesentium beatae temporibus nobis. Velit
                    dolorem facilis neque autem. Itaque voluptatem expedita qui eveniet id veritatis eaque. Blanditiis
                    quia placeat nemo. Nobis laudantium nesciunt perspiciatis sit eligendi.</p>
            </div>

            <div class="checkout-guarantee">
                <h3>100% Guarantee Safe Checkout</h3>
                <img src="{{ asset('images/pay.png') }}" alt="Payment Methods" class="payment-methods">
                <img src="{{ asset('images/pay1.png') }}" alt="Payment Methods" class="payment-methods">
                <img src="{{ asset('images/pay2.png') }}" alt="Payment Methods" class="payment-methods">
                <img src="{{ asset('images/pay3.png') }}" alt="Payment Methods" class="payment-methods">
                <img src="{{ asset('images/pay4.png') }}" alt="Payment Methods" class="payment-methods">
            </div>

            <div class="delivery-details">
                <h3>Delivery Details</h3>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------------------------------------------------------------- -->

    <!-- SCRIPT SECTIONS -->
    <script>
        $(document).ready(function () {

            // Toggle filter options
            $('.filter-header').on('click', function () {
                $(this).next('.filter-options').toggleClass('active');
                $(this).find('.fas').toggleClass('fa-chevron-down fa-chevron-up');
            });

            // Handle Category and Dress Style checkboxes
            $('.filter-options input[type="checkbox"]').on('change', function () {
                console.log(`${$(this).val()} selected: ${$(this).is(':checked')}`);
            });

            // Handle Color Swatch (single selection)
            $('.color-swatch').on('click', function () {
                $('.color-swatch').removeClass('selected');
                $(this).addClass('selected');
                console.log(`Color selected: ${$(this).data('color')}`);
            });

            // Handle Size Button (multiple selection)
            $('.size-btn').on('click', function () {
                $('.size-btn').removeClass('selected');
                $(this).addClass('selected');
                const selectedSize = $(this).data('size');
                console.log('Selected size:', selectedSize);
            });

            function updatePriceRange() {
                let minVal = parseInt($('#minPrice').val());
                let maxVal = parseInt($('#maxPrice').val());
                if (minVal > maxVal) {
                    const temp = minVal;
                    minVal = maxVal;
                    maxVal = temp;
                    $('#minPrice').val(minVal);
                    $('#maxPrice').val(maxVal);
                }

                $('#minPriceValue').text(`₹${minVal}`);
                $('#maxPriceValue').text(`₹${maxVal}`);
                const minLimit = parseInt($('#minPrice').attr('min')) || 100;
                const maxLimit = parseInt($('#maxPrice').attr('max')) || 10000;
                const totalRange = maxLimit - minLimit;

                const minPercentage = ((minVal - minLimit) / totalRange) * 100;
                const maxPercentage = ((maxVal - minLimit) / totalRange) * 100;

                $('#sliderTrack').css({
                    left: `${minPercentage}%`,
                    width: `${maxPercentage - minPercentage}%`,
                    transition: 'left 0.05s linear, width 0.05s linear'
                });
            }

            updatePriceRange();

            $('#minPrice, #maxPrice').on('input', updatePriceRange);

            // Handle favorite icon click
            $('.favorite-icon').on('click', function () {
                $(this).find('i').toggleClass('far fa-heart fas fa-heart').toggleClass('active');
                console.log('Favorite toggled!');
            });

            // Handle add to cart button click
            $('.add-to-cart-btn').on('click', function (event) {
                event.stopPropagation();
                alert('Product added to cart!');

            });
        });
    </script>
</body>

</html>