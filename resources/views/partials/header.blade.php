<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wahdeal</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css"
        integrity="sha512-t7Few9xlddEmgd3oKZQahkNI4dS6l80+eGEzFQiqtyVYdvcSG2D3Iub77R20BdotfRPA9caaRkg1tyaJiPmO0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet" />

    <link href="{{asset('web/main.css')}}?v={{ time() }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('web/slick/slick.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('web/slick/slick-theme.css')}}" />

    @yield('styles')
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container" style="width: 85%;">

            <!-- Left: Logo -->
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo1.png') }}" alt="Wahdeal Logo">
            </a>

            <!-- Toggler (Modal trigger) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="modal" data-bs-target="#menuModal"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon mx-auto" style="font-size: 14px;"></span>
            </button>

            <!-- Center: Menu (Desktop only) -->
            <div class="collapse navbar-collapse justify-content-center" id="mainNav">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Offer</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                            <li><a class="dropdown-item" href="#">Electronics</a></li>
                            <li><a class="dropdown-item" href="#">Fashion</a></li>
                            <li><a class="dropdown-item" href="#">Groceries</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Shopping</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Event</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Deals</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
            </div>

            <!-- Right: Icons -->
            <div class="nav-icons">
                <div class="location-dropdown">
                    Utran, Surat, 394101 <i class="fa-solid fa-chevron-down fs-6"></i>
                </div>
                <i class="fa-solid fa-cart-shopping fs-6"></i>
                <img src="{{ asset('images/Frame.png') }}" alt="Offer Icon">
                <i class="fa-duotone fa-solid fa-circle-user"></i>
            </div>

        </div>
    </nav>

    <!-- Menu Modal -->
    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="menuModalLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="navbar-nav text-center">
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Offer</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link text-dark dropdown-toggle" href="#" id="categoriesDropdownModal"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Categories
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="categoriesDropdownModal">
                                <li><a class="dropdown-item" href="#">Electronics</a></li>
                                <li><a class="dropdown-item" href="#">Fashion</a></li>
                                <li><a class="dropdown-item" href="#">Groceries</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Shopping</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Event</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Deals</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">About Us</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>