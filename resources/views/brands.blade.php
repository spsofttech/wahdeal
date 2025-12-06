<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brands</title>

  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('web/main.css') }}">

  <style>
    /* brand Section */
    .brand-category-section {
      padding: 30px 20px;
      background: #f7f7f7;
      text-align: center;
    }

    /* Container with fixed width and centered */
    .brand-category-container {
      max-width: 1100px;
      margin: 0 auto;
    }

    /* Category filter styling */
    .categories-grid {
      display: flex;
      gap: 15px;
      overflow-x: auto;
      white-space: nowrap;
      padding: 10px 0;
      scrollbar-width: thin;
      scrollbar-color: #ccc transparent;
    }

    .categories-grid::-webkit-scrollbar {
      height: 6px;
    }

    .categories-grid::-webkit-scrollbar-track {
      background: transparent;
    }

    .categories-grid::-webkit-scrollbar-thumb {
      background: #ccc;
      border-radius: 4px;
    }

    /* Each category item */
    .category-item {
      flex: 0 0 auto;
      text-align: center;
      text-decoration: none;
      color: #333;
      transition: all 0.3s ease;
      border-radius: 8px;
      padding: 8px 12px;
      background: transparent;
    }

    .category-item:hover {
      background: rgba(255, 122, 0, 0.08);
    }

    /* Icon container */
    .category-icon {
      width: 40px;
      height: 40px;
      margin: 0 auto 5px;
      display: flex;
      align-items: center;
      justify-content: center;
    }


    /* Text below icon */
    .category-item span {
      font-size: 13px;
      font-weight: 500;
      display: block;
      white-space: nowrap;
      color: #333;
    }

    /* Active state */
    .category-item.active {
      background: #ffe6e6;
      border-radius: 6px;
    }

    /* Brand grid */
    .brand-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .brand-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 8px;
      display: block;
    }

    .brand-card:hover {
      border: 1px dashed #ff7a00;
    }

    /* Selected state */
    .brand-card.selected {
      border: 2px dashed #ff7a00;
    }

    /* Responsive */

    @media (min-width: 481px) and (max-width: 768px) {
      .brand-category-container {
        padding: 0 10px;
      }

      .brand-grid {
        grid-template-columns: repeat(3, 2fr);
      }
    }

    @media (min-width: 320px) and (max-width: 480px) {
      .brand-grid {
        grid-template-columns: repeat(2, 2fr);
      }
    }
  </style>
</head>

<body>
  <!-- banner Section -->
  <section class="breadcrumb-section">
    <div class="breadcrumb-container">
      <span class="breadcrumb-home">HOME /</span>
      <span class="breadcrumb-current">BRANDS</span>
    </div>
  </section>
  <!-- ------------------------------------------------------------------------------------------ -->

  <!-- brand section -->
  <section class="brand-category-section">
    <div class="brand-category-container">
      <div style="display: flex; justify-content: center; align-items: center; margin: 2%;">
        <img src="{{ asset('images/heading5.png') }}" alt="Summer fashion" style="max-width: 70%; height: auto;" />
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

      <!-- Brand grid -->
      <div class="brand-grid">
        <div class="brand-card"><img src="{{asset('images/brnds.png')}}" alt="GUCCI"></div>
        <div class="brand-card"><img src="{{asset('images/brnds1.png')}}" alt="NEXT"></div>
        <div class="brand-card"><img src="{{asset('images/brnds2.png')}}" alt="Calvin Klein"></div>
        <div class="brand-card"><img src="{{asset('images/brnds3.png')}}" alt="Adidas"></div>
        <div class="brand-card"><img src="{{asset('images/brnds4.png')}}" alt="Uniqlo"></div>
        <div class="brand-card"><img src="{{asset('images/brnds5.png')}}" alt="H&M"></div>
        <div class="brand-card"><img src="{{asset('images/brnds6.png')}}" alt="ZARA"></div>
        <div class="brand-card"><img src="{{asset('images/brnds7.png')}}" alt="Nike"></div>
        <div class="brand-card"><img src="{{asset('images/brnds8.png')}}" alt="Prada"></div>
        <div class="brand-card"><img src="{{asset('images/brnds9.png')}}" alt="Versace"></div>
        <div class="brand-card"><img src="{{asset('images/brnds0.png')}}" alt="Polo"></div>
      </div>
    </div>
  </section>
  <!-- ------------------------------------------------------------------------------------------- -->

  <!-- script Section -->
  <script>
    const brandCards = document.querySelectorAll('.brand-card');

    brandCards.forEach(card => {
      card.addEventListener('click', () => {
        brandCards.forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
      });
    });
  </script>
</body>

</html>