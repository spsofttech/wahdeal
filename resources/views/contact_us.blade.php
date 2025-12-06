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
    /* Section Styling */
    /* Contact Section */
    .contact-section {
      padding: 20px;
      background-color: #f8f8f8;
    }

    .contact-container {
      display: flex;
      flex-wrap: wrap;
      align-items: stretch;
      max-width: 1100px;
      margin: 0 auto;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      box-sizing: border-box;
      width: 100%;
    }

    /* Map Section */
    .map-container {
      flex: 1;
      min-width: 280px;
      padding: 30px;
      box-sizing: border-box;
    }

    .map-container iframe {
      width: 100%;
      height: 100%;
      border: none;
      display: block;
    }

    /* Form Section */
    .form-container {
      flex: 1;
      padding: 30px 40px 30px 0;
      min-width: 280px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      box-sizing: border-box;
    }

    .form-container h2 {
      text-align: center;
      font-size: 1.4rem;
      font-weight: bold;
      margin-bottom: 10px;
      color: #000;
    }

    .form-container p {
      text-align: center;
      font-size: 0.95rem;
      color: #555;
      margin-bottom: 20px;
      line-height: 1.5;
    }

    /* Form Styling */
    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      width: 100%;
      box-sizing: border-box;
    }

    form input,
    form textarea {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 0.95rem;
      outline: none;
      transition: border 0.3s ease;
      width: 100%;
      box-sizing: border-box;
    }

    form textarea {
      resize: none;
      min-height: 120px;
    }

    form input:focus,
    form textarea:focus {
      border-color: rgba(255, 107, 0, 1);
    }

    /* Submit Button */
    form button {
      background-color: rgba(255, 107, 0, 1);
      color: white;
      padding: 12px;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
      width: 100%;
      box-sizing: border-box;
    }

    form button:hover {
      background-color: rgba(255, 107, 0, 1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .map-container {
        padding: none;
      }

      .form-container {
        padding: 30px 10px;
      }
    }
  </style>
</head>

<body>
  <!-- Banner Section -->
  <section class="breadcrumb-section">
    <div class="breadcrumb-container">
      <span class="breadcrumb-home">HOME /</span>
      <span class="breadcrumb-current">CONTACT US</span>
    </div>
  </section>
  <!-- ------------------------------------------------------------------------------------ -->

  <!--Main Details Section -->
  <section class="contact-section">
    <div class="contact-container">
      <!-- Map Section -->
      <div class="map-container">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.84543952857!2d72.8054920746946!3d21.17024068137764!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e594ad8a6a1%3A0x7a441c0c4e76fd2f!2sSurat%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1726491350769!5m2!1sen!2sin"
          width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
      </div>

      <!-- Form Section -->
      <div class="form-container">
        <h2>GET IN TOUCH</h2>
        <p>Reach Out To Us And Discover How We Can Make Your Shopping Journey Even Better.</p>

        <form>
          <input type="text" placeholder="First Name" required>
          <input type="text" placeholder="Last Name" required>
          <input type="tel" placeholder="Mobile Number" required>
          <input type="email" placeholder="Email Address" required>
          <input type="text" placeholder="Subject" required>
          <textarea placeholder="Message" rows="4" required></textarea>
          <button type="submit">Submit</button>
        </form>
      </div>
    </div>
  </section>

  <!-- script Section -->

</body>

</html>