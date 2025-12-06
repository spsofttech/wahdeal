<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Deals</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('web/main.css') }}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        /* ================== GENERAL STYLES ================== */

        .container {
            display: flex;
            max-width: 85%;
            margin: 20px auto;
        }

        /* ================== SIDEBAR ================== */
        .sidebar {
            width: 230px;
            padding: 10px 24px;
            border: 1px solid #e0e0e0;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .filter-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 24px;
            color: #f35309ff
        }

        .filter-group {
            margin-bottom: 32px;
        }

        .filter-group h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #000;
        }

        .filter-group li {
            padding: 10px 0;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            font-weight: 500;
            color: #555;
            transition: background-color 0.2s;
            list-style: none;
        }

        .filter-group li.active {
            color: #ff6300;
        }

        .brands-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .brand-btn {
            background-color: #f1f1f1;
            border: none;
            padding: 8px;
            border-radius: 20px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background-color 0.2s;
        }

        .brand-btn img {
            height: 20px;
        }

        .brand-btn.active {
            background-color: #ff6300;
            color: white;
        }

        /* ================== MAIN CONTENT ================== */
        .main-content {
            flex-grow: 1;
            padding: 0 24px;
        }

        .banner img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 12px;
        }

        .store-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 8px;
        }

        .store-details {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .store-logo {
            height: 50px;
            width: 50px;
        }

        .store-text h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #000
        }

        .store-text p {
            color: #777;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .store-rating .star {
            font-size: 1.5rem;
            color: #e0e0e0;
        }

        .store-rating .star.filled {
            color: #ffc107;
        }

        /* ================== OFFERS GRID ================== */
        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .location-display {
            display: flex;
            align-items: center;
            font-size: 16px;
            color: #333;
            gap: 5px;
            margin-top: 5px
        }

        .location-display i {
            color: #ff6b00;
        }

        .foot {
            padding: 0 15px 10px 15px;
        }

        .expiry {
            font-size: 14px;
            color: #ff0000ff
        }
    </style>
</head>

<body>
    <!-- banner Section -->
    <section class="breadcrumb-section">
        <div class="breadcrumb-container">
            <span class="breadcrumb-home">HOME /</span>
            <span>HOT DEALS</span>
        </div>
    </section>
    <!-- ---------------------------------------------------------------------------- -->

    <!-- MAIN SECTIONS -->
    <div class="container">
        <aside class="sidebar">
            <h2 class="filter-title">Filter</h2>

            <div class="filter-group">
                <h3>Fashion Apparel <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg></h3>           
                    <li>All (50)</li>
                    <li>Man (50)</li>
                    <li class="active">Woman (50)</li>
                    <li>Children (50)</li>               
            </div>

            <div class="filter-group">
                <h3>Brands <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg></h3>
                <div class="brands-grid">
                    <button class="brand-btn active">
                        <img src="./svg/hm.svg" alt="H&M"> H&M
                    </button>
                    <button class="brand-btn">
                        <img src="./svg/guci.svg" alt="Gucci"> GUCCI
                    </button>
                    <button class="brand-btn"> <img src="./svg/polo.svg" alt="H&M">POLO</button>
                    <button class="brand-btn"> <img src="./svg/nxt.svg" alt="H&M">NEXT</button>
                    <button class="brand-btn"> <img src="./svg/zara.svg" alt="H&M">ZARA</button>
                    <button class="brand-btn"> <img src="./svg/nike.svg" alt="H&M">NIKE</button>
                    <button class="brand-btn"> <img src="./svg/prada.svg" alt="H&M">PRADA</button>
                    <button class="brand-btn"> <img src="./svg/uniq.svg" alt="H&M">UNIQLO</button>
                    <button class="brand-btn"> <img src="./svg/addi.svg" alt="H&M">ADIDAS</button>
                </div>
            </div>

            <div class="filter-group">
                <h3>Offers <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                    </svg></h3>
                <div class="brands-grid">
                    <button class="brand-btn active">
                       All
                    </button>
                    <button class="brand-btn">
                       80%
                    </button>
                    <button class="brand-btn">70%</button>
                    <button class="brand-btn">60%</button>
                    <button class="brand-btn">50%</button>
                    <button class="brand-btn">30%</button>
                </div>
            </div>
        </aside>

        <main class="main-content">

            <div class="banner">
                <img src="{{ asset('images/abv.png') }}" alt="H&M Store Banner">
            </div>

            <div class="store-info">
                <div class="store-details">
                    <img src="{{ asset('images/log.png') }}" alt="H&M Logo" class="store-logo">
                    <div class="store-text">
                        <h2>H&M</h2>
                        <p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                            </svg>
                            Amroli 394107
                        </p>
                    </div>
                </div>
                <div class="store-rating">
                    <span class="star filled">★</span>
                    <span class="star filled">★</span>
                    <span class="star filled">★</span>
                    <span class="star filled">★</span>
                    <span class="star">★</span>
                </div>
            </div>


            <div class="offers-grid " style="margin-top: 2%">
                <!-- Offer Card Example -->
                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fas0.png') }}" alt="La Pino'z Pizza Offer">
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
                    <div class="foot">
                        <span class="expiry">EXPIRES:1/31/25</span>
                        <div class="location-display">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Vadodara – 390005</span>
                        </div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fas1.png') }}" alt="La Pino'z Pizza Offer">
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
                    <div class="foot">
                        <span class="expiry">EXPIRES:1/31/25</span>
                        <div class="location-display">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Vadodara – 390005</span>
                        </div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fas2.png') }}" alt="La Pino'z Pizza Offer">
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
                    <div class="foot">
                        <span class="expiry">EXPIRES:1/31/25</span>
                        <div class="location-display">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Vadodara – 390005</span>
                        </div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fas3.png') }}" alt="La Pino'z Pizza Offer">
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
                    <div class="foot">
                        <span class="expiry">EXPIRES:1/31/25</span>
                        <div class="location-display">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Vadodara – 390005</span>
                        </div>
                    </div>
                </div>
                <!-- Repeat cards as needed... -->

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fas4.png') }}" alt="La Pino'z Pizza Offer">
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
                    <div class="foot">
                        <span class="expiry">EXPIRES:1/31/25</span>
                        <div class="location-display">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Vadodara – 390005</span>
                        </div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fas5.png') }}" alt="La Pino'z Pizza Offer">
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
                    <div class="foot">
                        <span class="expiry">EXPIRES:1/31/25</span>
                        <div class="location-display">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Vadodara – 390005</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>