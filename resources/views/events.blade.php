<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events Page</title>

  <link rel="stylesheet" href="{{ asset('web/main.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    .card-content {
      padding: 0 1rem;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
      /* height: 160px; */
    }

    .event-card1 {
    position: relative;
    overflow: hidden;
    transition: 0.3s ease;
    text-align: start;
    cursor: pointer;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: start;
}

    @media (max-width: 540px) {
      .events-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }
    }
  </style>
</head>

<body>
  <!-- Banner Section -->
  <section class="breadcrumb-section">
    <div class="breadcrumb-container">
      <span class="breadcrumb-home">HOME /</span>
      <span class="breadcrumb-current">Events</span>
    </div>
  </section>
  <!-- ------------------------------------------------------------------------------------------------ -->

  <!-- Events Section -->
  <section class="spotlight-section">
    <div class="events-grid">
      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img6.png')}}" alt="VHALAM NAVRATRI">
        </div>
        <div class="card-content">
          <h3 class="event-title">SACHA Navratri Festival With Jigardan Gadhavi</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>

      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img7.png')}}" alt="KINJAL DAVE">
        </div>
        <div class="card-content">
          <h3 class="event-title">SACHA Navratri Festival With Kinjal Dave</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>

      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img8.png')}}" alt="BHOOMI">
        </div>
        <div class="card-content">
          <h3 class="event-title">SACHA Navratri Festival With Bhoomi Trivedi</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>

      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img9.png')}}" alt="Gazal Night">
        </div>
        <div class="card-content">
          <h3 class="event-title">Gazal Night With Shyamal-Saumil & Band</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>

      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img9.png')}}" alt="BHOOMI">
        </div>
        <div class="card-content">
          <h3 class="event-title">SACHA Navratri Festival With Bhoomi Trivedi</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>

      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img7.png')}}" alt="Gazal Night">
        </div>
        <div class="card-content">
          <h3 class="event-title">SACHA Navratri Festival With Jigardan Gadhavi</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>

      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img8.png')}}" alt="VHALAM NAVRATRI">
        </div>
        <div class="card-content">
          <h3 class="event-title">Gazal Night With Shyamal-Saumil & Band</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>

      <article class="event-card">
        <div class="card-image-container">
          <img src="{{asset('images/img6.png')}}" alt="KINJAL DAVE">
        </div>
        <div class="card-content">
          <h3 class="event-title">SACHA Navratri Festival With Kinjal Dave</h3>
          <div class="event-card1">
            <ul class="event-details">
              <li><i class="fa-solid fa-location-dot"></i>Ras Garba Ground, Vadodara</li>
              <li><i class="fa-solid fa-calendar-days"></i>22 Sep - 25 Sep 2025</li>
              <li><i class="fa-solid fa-clock"></i>10:00 PM</li>
            </ul>
            <div class="buy-pass-btn">
              <button>Buy Passes</button>
            </div>
          </div>
        </div>
      </article>
    </div>

    <button class="show-more-btn">
      Show More Events
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
        stroke-linejoin="round">
        <path d="M7 13l5 5 5-5" />
        <path d="M7 6l5 5 5-5" />
      </svg>
    </button>
  </section>
  <!-- --------------------------------------------------------------------------------------------------- -->
  <script>
    $(function () {
      const data = [
        { t: 'New Event: Live Music Night', i: '{{asset("images/img9.png")}}' },
        { t: 'New Event: Tech Innovators Meetup', i: '{{asset("images/img8.png")}}' },
        { t: 'New Event: Art & Craft Workshop', i: '{{asset("images/img7.png")}}' },
        { t: 'New Event: Open Mic Comedy', i: '{{asset("images/img6.png")}}' }
      ];

      const maxCards = 6;
      let addedCards = 0;

      $('.show-more-btn').click(function () {
        const $tmpl = $('.events-grid .event-card').first();
        const remaining = maxCards - addedCards;
        if (remaining <= 0) return;

        const cardsToAdd = Math.min(4, remaining);
        for (let j = 0; j < cardsToAdd; j++) {
          const d = data[j % data.length];
          const $newCard = $tmpl.clone()
            .find('img').attr({ src: d.i, alt: d.t }).end()
            .find('.event-title').text(d.t).end();
          $('.events-grid').append($newCard);
          addedCards++;
        }
      });
    });
  </script>
</body>

</html>