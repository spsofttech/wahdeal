@foreach($filteredCategories as $keys => $category)
<!-- section 3 -->
<div class="container-fluid py-4 event categorydata">

    <div class="row align-items-center">

        <!-- Left Title -->
        <div class="col-12 col-md-3 mb-3 mb-md-0">
            <div class="section-title">{{ $category['category_name'] }}</div>
        </div>

        <!-- Right Filters -->
        <div class="col-12 col-md-9">
            <div class="d-flex flex-wrap gap-2 gap-md-3 
                  justify-content-center justify-content-md-end">

                <button class="filter-btn active" data-target="all"
                    data-category="{{ $category['category_id'] }}">ALL</button>
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
                        <span><i
                                class="fa-heart @if($brand['like_status'] == '1')fa-solid @else fa-regular @endif"></i></span>
                    </div>
                </div>

                <div class="brand-img">
                    <img src="{{$brand['icon']}}">
                </div>

                <div class="brand-name">{{$brand['name']}}</div>
                <div class="offer-strip">UP TO @if($brand['discount_amount'] > 0) {{$brand['discount_amount']}} @else 0
                    @endif
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
                                {{-- <p class="text-warning fw-semibold mb-1" style="color:#FF6A00 !important;">UP TO
                                    60% OFF</p> --}}

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



@endforeach