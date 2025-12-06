<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events Page</title>

  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('web/main.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    /* Main Container */
    .center-text-section {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      width: 100%;
      max-width: 900px;
      margin: 0 auto;
      padding: 30px 20px;
      color: black;
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin-top: -3%;
      box-sizing: border-box;
      word-wrap: break-word;
      overflow-wrap: break-word;
    }

    .center-text-section p {
      margin-bottom: 15px;
      font-size: clamp(14px, 2vw, 16px);
      color: #333;
      max-width: 100%;
      line-height: 1.6;
    }

    .center-text-section p:last-child {
      margin-bottom: 0;
    }

    /* Section Container */
    .vision-mission-section {
      display: flex;
      justify-content: center;
      padding: 40px 20px;
    }

    .container {
      display: flex;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      max-width: 900px;
      width: 100%;
      padding: 30px;
      gap: 30px;
      align-items: flex-start;
    }

    /* Individual Card */
    .card {
      flex: 1;
    }

    .card-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
    }

    .card-header .icon {
      width: 20px;
      height: 20px;
    }

    .card-header .title {
      font-size: 0.75rem;
      text-transform: uppercase;
      font-weight: 500;
      color: #555;
    }

    .card-heading {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 10px;
      color: #222;
    }

    .card-text {
      font-size: 0.85rem;
      line-height: 1.5;
      color: #666;
    }

    /* Divider Line */
    .divider {
      width: 1px;
      background: #ddd;
      margin: 0 10px;
    }

    @media (max-width: 992px) {
      .download-container {
        grid-template-columns: 1fr;
        text-align: center;
      }

      .download-content {
        padding-right: 0;
        order: 1;
      }

      .download-image-wrapper {
        order: 1;
        margin-bottom: -15%;
      }

      .download-buttons-wrapper {
        justify-content: center;
      }
    }

    /* Responsive Design */
    @media (max-width: 425px) {
      .container {
        flex-direction: column;
        gap: 20px;
      }

      .divider {
        width: 100%;
        height: 1px;
      }

      .center-text-section {
        padding: 15px 10px;
        margin-top: 0;
      }

      .center-text-section p {
        font-size: 14px;
        line-height: 1.5;
        word-break: break-word;
      }
    }
  </style>
</head>

<body>
  <!-- Banner Section -->
  <section class="breadcrumb-section">
    <div class="breadcrumb-container">
      <span class="breadcrumb-home">HOME /</span>
      <span class="breadcrumb-current">ABOUT US</span>
    </div>
  </section>

  <!-- Brand Details Section -->
  <section class="banners1">
    <div style="display: flex; justify-content: center; align-items: center; height: 100px; width: 100%;">
      <img src="{{ asset('images/heading14.png') }}" alt="Summer fashion" style="width: auto; height: 40px;" />
    </div>

    <div class="center-text-section">
      <p>
        We believe that shopping should be exciting, rewarding, and effortless.
        Our platform brings together the best brands, the latest products, and the biggest offers and deals,
        all in one place. Whether you’re looking for fashion, electronics, home essentials, or lifestyle products,
        we make sure you get quality at the best price.
      </p>

      <p>
        Our goal is simple: to help you save more, shop smarter, and discover amazing deals every day.
      </p>
    </div>
  </section>
  <!-- --------------------------------------------------------------------------------------- -->

  <section class="vision-mission-section">
    <div class="container">
      <!-- Vision Card -->
      <div class="card">
        <div class="card-header">
          <img src="./svg/eye.svg" alt="Vision Icon" class="icon">
          <span class="title">OUR VISION</span>
        </div>
        <h3 class="card-heading">Your Go-To Savings Destination</h3>
        <p class="card-text">
          Our vision is to be the most trusted platform for deals, discounts, and product discovery.
          We want to transform the way people shop by turning every purchase into a money-saving experience
          while building a community of smart shoppers.
        </p>
      </div>

      <!-- Divider Line -->
      <div class="divider"></div>

      <!-- Mission Card -->
      <div class="card">
        <div class="card-header">
          <img src="./svg/misn.svg" alt="Mission Icon" class="icon">
          <span class="title">OUR MISSION</span>
        </div>
        <h3 class="card-heading">Making Savings Simple</h3>
        <p class="card-text">
          Our mission is to make finding deals effortless for everyone.
          We aim to connect shoppers with real value by curating the best offers across categories —
          from fashion and electronics to home essentials — helping you get more for less.
        </p>
      </div>
    </div>
  </section>
  <!-- --------------------------------------------------------------------------------------------------- -->
  <!-- Download Section -->
  <section class="download-section">
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


  <!-- script Section -->

</body>

</html>