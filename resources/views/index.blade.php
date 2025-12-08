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
        @if(!empty($category))
        @foreach ($category as $calval)
        <div class="card text-center border-0 flex-shrink-0" style="width: 100px;">
          <div class="card-body p-2 d-flex flex-column align-items-center justify-content-center">
            <img src="{{$calval->image_url}}" class="img-fluid mb-2" alt="{{$calval->name}}"
              style="width: 50px; height: 50px;">
            <span class="text-truncate d-block w-100" title="{{$calval->name}}">{{$calval->name}}</span>
            <small class="text-light">({{$calval->brands_count}})</small>
          </div>
        </div>
        @endforeach
        @endif
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

        @if(!empty($promote_data))
        @foreach($promote_data as $pval)
        <div class="brand-card">
          <div class="brand-top">
            <span><i class="fa-regular fa-eye"></i> {{$pval['count']}}</span>
            <div class="d-flex align-items-center gap-2">
              @if($pval['veg'] == '1')
              <img src="{{ asset('images/veg.png') }}" width="20">
              @elseif($pval['veg'] == '2')
              <img src="{{ asset('images/non_veg.png') }}" width="20">
              @elseif($pval['veg'] == '0')
              @else
              <img src="{{ asset('images/veg-non.png') }}" width="20">
              @endif
              <span class="brand-heart text-danger"><i
                  class="@if($pval['like_status'] == '1')fa-solid @else fa-regular @endif fa-heart"></i></span>
            </div>
          </div>

          <div class="brand-img">
            <img src="{{$pval['icon']}}">
          </div>

          <div class="brand-name">{{ Str::limit($pval['name'], 18) }}</div>
          <div class="offer-strip">UP TO @if($pval['discount_amount'] > 0) {{$pval['discount_amount']}} @else 0 @endif
            OFF</div>
        </div>
        @endforeach
        @endif


      </div>
    </div>

  </div>
</section>

@foreach($filteredCategories as $keys => $category)
<!-- section 3 -->
<div class="container-fluid py-4 event">

  <div class="row align-items-center">

    <!-- Left Title -->
    <div class="col-12 col-md-3 mb-3 mb-md-0">
      <div class="section-title">{{ $category['category_name'] }}</div>
    </div>

    <!-- Right Filters -->
    <div class="col-12 col-md-9">
      <div class="d-flex flex-wrap gap-2 gap-md-3 
                  justify-content-center justify-content-md-end">

        <button class="filter-btn active" data-target="all" data-category="{{ $category['category_id'] }}">ALL</button>
        @foreach($category['subcategories'] as $key => $sub)
        <button class="filter-btn" data-target="{{ $sub['subcategory_id'] }}"
          data-category="{{ $category['category_id'] }}">{{ $sub['subcategory_name'] }}</button>
        @endforeach

      </div>
    </div>
  </div>

</div>

@foreach($category['subcategories'] as $sub)

<div class="subcategory-block" id="{{ $sub['subcategory_id'] }}" data-category="{{ $category['category_id'] }}">

  @if(!empty($sub['brands']))
  <div class="container-fluid py-4 event">

    <div class="brand-scroll d-flex gap-3">

      @foreach($sub['brands'] as $brand)
      <div class="brand-card">
        <div class="brand-top">
          <span><i class="fa-regular fa-eye"></i> {{$brand['count']}}</span>
          <div class="d-flex align-items-center gap-2">
            @if($brand['veg'] == '1')
            <img src="{{ asset('images/veg.png') }}" width="20">
            @elseif($brand['veg'] == '2')
            <img src="{{ asset('images/non_veg.png') }}" width="20">
            @elseif($brand['veg'] == '0')
            @else
            <img src="{{ asset('images/veg-non.png') }}" width="20">
            @endif
            <span><i class="fa-heart @if($brand['like_status'] == '1')fa-solid @else fa-regular @endif"></i></span>
          </div>
        </div>

        <div class="brand-img">
          <img src="{{$brand['icon']}}">
        </div>

        <div class="brand-name">{{$brand['name']}}</div>
        <div class="offer-strip">UP TO @if($brand['discount_amount'] > 0) {{$brand['discount_amount']}} @else 0 @endif
          OFF
        </div>
      </div>
      @endforeach

    </div>

  </div>
  @endif

  @if(!empty($sub['products']))
  <section class="container-fluid my-5 event">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="fw-bold" style="font-size: 24px;">Best Offer</h3>
      <a href="#" class="view-all">VIEW ALL ></a>
    </div>

    <!-- HORIZONTAL SCROLL WRAPPER -->
    <div class="offer-scroll">

      @foreach($sub['products'] as $product)
      <div class="offer-card">
        <div class="offer-img-wrapper">

          <span class="offer-badge">{{$product['offer']->title ?? ''}}</span>
          <img src="{{$product['image_url']}}" class="offer-img">

          <!-- ⭐ Rating inside image -->
          <div class="img-rating">⭐ {{$product['rating']}} | {{$product['count']}}</div>



          @if($product['veg'] == '1')
          <img src="{{ asset('images/veg.png') }}" class="veg-img">
          @elseif($product['veg'] == '2')
          <img src="{{ asset('images/non_veg.png') }}" class="veg-img">
          @elseif($product['veg'] == '0')
          @else
          <img src="{{ asset('images/veg-non.png') }}" class="veg-img">
          @endif

          <!-- Heart -->
          <button class="fav-btn"><span class="text-danger"><i
                class="fa-heart @if($product['like_status'] == '1')fa-solid @else fa-regular @endif"></i></span></button>
        </div>

        <div class="p-3 d-flex justify-content-between">
          <div>
            <h6 class="fw-semibold mb-1">{{$product['name'] ?? ''}}</h6>

            <div class="location">
              <i class="fa-solid fa-location-dot"></i> {{$product['location']->area ?? ''}} –
              {{$product['location']->pincode
              ?? ''}}
            </div>
          </div>

          <!-- RIGHT : Small brand logo -->
          <img src="{{$product['brand_image']}}" class="brand-logo">
        </div>

      </div>
      @endforeach


    </div>
  </section>
  @endif

  @if(!empty($sub['booking']))
  <div class="container-fluid py-2 event">
    <h3 class="mb-4 fw-bold" style="font-size: 24px;">Book Your Table</h3>

    <div class="row g-2">

      @foreach($sub['booking'] as $booking)
      <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="restaurant-card">

          <!-- CARD TOP CONTENT -->
          <div class="card-content p-2 d-flex gap-1 justify-content-between">

            <!-- LEFT (Logo + Text) -->
            <div class="d-flex gap-2 mx-2">
              <img src="{{ $booking['icon'] }}" width="45" height="45">

              <div>
                <h6 class="fw-semibold mb-1" style="font-size: 15px;">{{$booking['name']}}</h6>
                {{-- <p class="text-warning fw-semibold mb-1" style="color:#FF6A00 !important;">UP TO 60% OFF</p> --}}

                <div class="d-flex align-items-center gap-2">
                  <span style="font-size:14px;" class="text-muted fw-semibold"><i
                      class="bi bi-eye-fill fs-6 text-muted"></i> {{$booking['count']}}</span>
                </div>
              </div>
            </div>

            <!-- RIGHT (Heart + Veg icon) -->
            <div class="d-flex flex-column align-items-end gap-2">
              <button class="border-0 bg-white"><span class="text-danger"><i
                    class="fa-heart @if($booking['like_status'] == '1')fa-solid @else fa-regular @endif"></i></span></button>

              @if($booking['veg'] == '1')
              <img src="{{ asset('images/veg.png') }}" class="veg-img-resto mx-auto">
              @elseif($booking['veg'] == '2')
              <img src="{{ asset('images/non_veg.png') }}" class="veg-img-resto mx-auto">
              @elseif($booking['veg'] == '0')
              @else
              <img src="{{ asset('images/veg-non.png') }}" class="veg-img-resto mx-auto">
              @endif
            </div>
          </div>

          <div class="d-flex justify-content-between">
            <div class="location mx-3 mb-1">
              <i class="fa-solid fa-location-dot"></i> {{$booking['location']->area ?? ''}} –
              {{$booking['location']->pincode
              ?? ''}}
            </div>
          </div>
          <div class="book-btn">BOOK NOW ➜</div>
        </div>
      </div>
      @endforeach

    </div>
  </div>
  @endif

  @if(!empty($sub['brand_banner']))
  <div class="banner mt-3 container-fluid">
    <h3 class="w-100 text-center fw-bold" style="font-size: 24px;">
      Every Day deals For you
    </h3>

    <!-- scrollable container has the id -->
    <div class="banner-scroll" id="slider">
      @foreach($sub['brand_banner'] as $brand_banner)
      <div class="banner-item"><img src="{{ $brand_banner['image_url'] }}" alt=""></div>
      @endforeach
    </div>
  </div>
  @endif


  @if(!empty($sub['own_banner']))
  <div class="container-fluid py-3" style="background-color: var(--nav-bg);">

    <h3 class="text-center text-light fw-semibold mb-3 container" style="font-size: 24px;">
      Best Offer In This Week
    </h3>

    <!-- HORIZONTAL SCROLL WRAPPER -->
    <div class="best-offer-scroll container">
      @foreach($sub['own_banner'] as $own_banner)
      <div class="offer-card">
        <img src="{{ $own_banner['image_url'] }}" class="offer-img" alt="">
      </div>
      @endforeach

    </div>
  </div>
  @endif

</div>


@endforeach

@if($keys == '0' && !empty($events))
<!-- section 9 -->
<div class="event-bg py-2 container-fluid">
  <div class="container-fluid py-4 event">

    <!-- Heading Row -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="event-title">EVENT</h4>
      <a href="#" class="more-events">MORE EVENTS <i class="bi bi-chevron-double-right"></i></a>
    </div>

    <div class="row g-4">

      @foreach($events as $eventval)
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="event-card shadow-sm rounded-4">
          <img src="{{ $eventval['image_url'] }}" class="img-fluid rounded-top" alt="event">

          <div class="content-box">
            <p class="date-line mb-1">
              {{ \Carbon\Carbon::parse($eventval['start_date'])->format('d M Y') }} to {{
              \Carbon\Carbon::parse($eventval['end_date'])->format('d M Y') }}

              {{ $eventval['time'] }}
            </p>

            <h6 class="fw-semibold mb-1">{{ $eventval['title'] }}</h6>

            <p class="location-text mb-2">
              {{ $eventval['address'] }}
            </p>

            <a href="#" class="buy-link">
              <i class="bi bi-ticket-detailed"></i> Buy Passes
            </a>
          </div>
        </div>
      </div>
      @endforeach




    </div>
  </div>
</div>
@endif

@endforeach


<div id="ajax_home_data">

</div>

<!-- ⭐ Center Button -->
<div class="text-center mt-3">
  <input type="hidden" id="pageid" value="1">
  <button class="show-more-btn bg-white" onclick="showmoreoffer()">Show More Offers <i
      class="bi bi-chevron-double-down fw-semibold"></i></button>
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


<script>
  document.addEventListener("click", function (e) {

    if (e.target.classList.contains("filter-btn")) {

        let btn = e.target;

        let categoryId = btn.getAttribute("data-category");
        let target = btn.getAttribute("data-target");

        // Remove active only from this category
        document.querySelectorAll(`.filter-btn[data-category='${categoryId}']`)
                .forEach(b => b.classList.remove("active"));

        btn.classList.add("active");

        // If ALL → show all subcategory blocks of this category
        if (target === "all") {
            document.querySelectorAll(`.subcategory-block[data-category='${categoryId}']`)
                    .forEach(block => block.style.display = "block");
            return;
        }

        // Hide only this category's subcategory blocks
        document.querySelectorAll(`.subcategory-block[data-category='${categoryId}']`)
                .forEach(block => block.style.display = "none");

        // Show selected one
        document.getElementById(target).style.display = "block";
    }

});
</script>

<script>
  function showmoreoffer(){
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var pageid = parseInt($("#pageid").val());
    var newpage = pageid + 1;
    $.ajax({
        url: "{{ route('get_home_data_page_wise') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            page: newpage
        },
        success: function(response) {
            $("#pageid").val(newpage);
            if (response.status == 'success') {
                $("#ajax_home_data").append(response.message);
            }else{
                 
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
  }
</script>

@endsection