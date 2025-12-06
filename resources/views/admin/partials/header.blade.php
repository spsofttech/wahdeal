@php
$tot_branch_request = getBranchRequestCount();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | @yield('title', 'Wahdeal')</title>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">

    <link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">

    @yield('styles')
    <style>
        .mybtn {
            padding: 0.2rem !important;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider - the part that slides */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 50px;
        }

        /* When the checkbox is checked, add a green background */
        input:checked+.slider {
            background-color: #4CAF50;
        }

        /* The slider circle (the round part) */
        .slider:before {
            position: absolute;
            content: "";
            height: 12px;
            width: 12px;
            border-radius: 50px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }

        /* Move the circle to the right when checked */
        input:checked+.slider:before {
            transform: translateX(14px);
        }

        .nav-sidebar .nav-link p {
            white-space: nowrap;
        }

        .brand-link .brand-image {
            float: none !important;
        }

        .select2-selection__clear {
            display: none;
        }

        .buttonload {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            box-shadow: none;
        }

        /* Add a right margin to each icon */
        .fa {
            margin-left: -12px;
            margin-right: 8px;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{asset('admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>


            <!-- Right navbar links -->

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <!-- <img src="{{asset('images/logo.jpg')}}" alt="Explorr" class="brand-image elevation-3"> -->

            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">


                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>


                        <li
                            class="nav-item {{ request()->routeIs('admin.category') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.sub_category') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.event_category') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_category') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.category_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_subcategory') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.sub_category_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_event_category') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.event_category_edit') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Category
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.category') }}"
                                        class="nav-link {{ request()->routeIs('admin.category') ? 'active' : '' }} {{ request()->routeIs('admin.add_category') ? 'active' : '' }} {{ request()->routeIs('admin.category_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.sub_category') }}"
                                        class="nav-link {{ request()->routeIs('admin.sub_category') ? 'active' : '' }} {{ request()->routeIs('admin.add_subcategory') ? 'active' : '' }} {{ request()->routeIs('admin.sub_category_edit') ? 'active' :'' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Sub Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.event_category') }}"
                                        class="nav-link {{ request()->routeIs('admin.event_category') ? 'active' : '' }} {{ request()->routeIs('admin.add_event_category') ? 'active' : '' }} {{ request()->routeIs('admin.event_category_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Event Category</p>
                                    </a>
                                </li>
                            </ul>
                        </li>






                        <li
                            class="nav-item {{ request()->routeIs('admin.brand') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_brand') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.brand_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.branch') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_branch') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.branch_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.brand_view') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.branch_request') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.branch_request_view') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Brand
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.brand') }}"
                                        class="nav-link {{ request()->routeIs('admin.brand') ? 'active' : '' }} {{ request()->routeIs('admin.add_brand') ? 'active' : '' }} {{ request()->routeIs('admin.brand_edit') ? 'active' : '' }} {{ request()->routeIs('admin.brand_view') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Brand</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.branch') }}"
                                        class="nav-link {{ request()->routeIs('admin.branch') ? 'active' : '' }} {{ request()->routeIs('admin.add_branch') ? 'active' : '' }} {{ request()->routeIs('admin.branch_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Branch</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.branch_request') }}"
                                        class="nav-link {{ request()->routeIs('admin.branch_request') ? 'active' : '' }} {{ request()->routeIs('admin.branch_request_view') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Branch Request @if($tot_branch_request > 0) ({{$tot_branch_request}}) @endif
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li
                            class="nav-item {{ request()->routeIs('admin.product') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_product') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.product_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.product_view') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.product_request') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.product_request_view') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Product
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.product') }}"
                                        class="nav-link {{ request()->routeIs('admin.product') ? 'active' : '' }} {{ request()->routeIs('admin.add_product') ? 'active' : '' }} {{ request()->routeIs('admin.product_edit') ? 'active' : '' }} {{ request()->routeIs('admin.product_view') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Product</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.product_request') }}"
                                        class="nav-link {{ request()->routeIs('admin.product_request') ? 'active' : '' }} {{ request()->routeIs('admin.product_request_view') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Product Request</p>
                                    </a>
                                </li>

                            </ul>
                        </li>




                        <li
                            class="nav-item {{ request()->routeIs('admin.size') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_size') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.size_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.color') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_color') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.color_edit') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Size & Color
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.size') }}"
                                        class="nav-link {{ request()->routeIs('admin.size') ? 'active' : '' }} {{ request()->routeIs('admin.add_size') ? 'active' : '' }} {{ request()->routeIs('admin.size_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Size</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.color') }}"
                                        class="nav-link {{ request()->routeIs('admin.color') ? 'active' : '' }} {{ request()->routeIs('admin.add_color') ? 'active' : '' }} {{ request()->routeIs('admin.color_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Color</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li
                            class="nav-item {{ request()->routeIs('admin.offer_type') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_offer_type') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.offer_type_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.offer') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_offer') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.offer_edit') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Offer
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.offer_type') }}"
                                        class="nav-link {{ request()->routeIs('admin.offer_type') ? 'active' : '' }} {{ request()->routeIs('admin.add_offer_type') ? 'active' : '' }} {{ request()->routeIs('admin.offer_type_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Offer Type</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.offer') }}"
                                        class="nav-link {{ request()->routeIs('admin.offer') ? 'active' : '' }} {{ request()->routeIs('admin.add_offer') ? 'active' : '' }} {{ request()->routeIs('admin.offer_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Offer</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="nav-item {{ request()->routeIs('admin.event') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.event_view') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_event') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.event_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.event_pass') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_event_pass') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.event_pass_edit') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Event
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.event') }}"
                                        class="nav-link {{ request()->routeIs('admin.event') ? 'active' : '' }} {{ request()->routeIs('admin.event_view') ? 'active' : '' }} {{ request()->routeIs('admin.add_event') ? 'active' : '' }} {{ request()->routeIs('admin.event_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Event</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.event_pass') }}"
                                        class="nav-link {{ request()->routeIs('admin.event_pass') ? 'active' : '' }} {{ request()->routeIs('admin.add_event_pass') ? 'active' : '' }} {{ request()->routeIs('admin.event_pass_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Event Pass</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.user') }}"
                                class="nav-link {{ request()->routeIs('admin.user') ? 'active' : '' }} {{ request()->routeIs('admin.user_edit') ? 'active' : '' }} {{ request()->routeIs('admin.user_view') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>User</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.fashion_banner') }}"
                                class="nav-link {{ request()->routeIs('admin.fashion_banner') ? 'active' : '' }} {{ request()->routeIs('admin.add_fashion_banner') ? 'active' : '' }} {{ request()->routeIs('admin.fashion_banner_edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>Fashion Banner</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('admin.banner') }}"
                                class="nav-link {{ request()->routeIs('admin.banner') ? 'active' : '' }} {{ request()->routeIs('admin.add_banner') ? 'active' : '' }} {{ request()->routeIs('admin.banner_edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>Banner</p>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="{{ route('admin.plan') }}"
                                class="nav-link {{ request()->routeIs('admin.plan') ? 'active' : '' }} {{ request()->routeIs('admin.add_plan') ? 'active' : '' }} {{ request()->routeIs('admin.plan_edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>Subscribe Plan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.coupon') }}"
                                class="nav-link {{ request()->routeIs('admin.coupon') ? 'active' : '' }} {{ request()->routeIs('admin.add_coupon') ? 'active' : '' }} {{ request()->routeIs('admin.coupon_edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>Coupon</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.role') }}"
                                class="nav-link {{ request()->routeIs('admin.role') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>Role</p>
                            </a>
                        </li>


                        <li
                            class="nav-item {{ request()->routeIs('admin.product_issue_category') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_product_issue_category') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.product_issue_category_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.product_issue_reason') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_product_issue_reason') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.product_issue_reason_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.booking_cancel_reason') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_booking_cancel_reason') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.booking_cancel_reason_edit') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Help & Support
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.product_issue_category') }}"
                                        class="nav-link {{ request()->routeIs('admin.product_issue_category') ? 'active' : '' }} {{ request()->routeIs('admin.add_product_issue_category') ? 'active' : '' }} {{ request()->routeIs('admin.product_issue_category_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Product Issue Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product_issue_reason') }}"
                                        class="nav-link {{ request()->routeIs('admin.product_issue_reason') ? 'active' : '' }} {{ request()->routeIs('admin.add_product_issue_reason') ? 'active' : '' }} {{ request()->routeIs('admin.product_issue_reason_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Product Issue Reason</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.booking_cancel_reason') }}"
                                        class="nav-link {{ request()->routeIs('admin.booking_cancel_reason') ? 'active' : '' }} {{ request()->routeIs('admin.add_booking_cancel_reason') ? 'active' : '' }} {{ request()->routeIs('admin.booking_cancel_reason_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Booking Cancel Reason</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li
                            class="nav-item {{ request()->routeIs('admin.category_form_field_option') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_category_form_field_option') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.category_form_field_option_edit') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.category_form_field') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.add_category_form_field') ? 'menu-is-opening menu-open' : '' }} {{ request()->routeIs('admin.category_form_field_edit') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Category Form
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.category_form_field_option') }}"
                                        class="nav-link {{ request()->routeIs('admin.category_form_field_option') ? 'active' : '' }} {{ request()->routeIs('admin.add_category_form_field_option') ? 'active' : '' }} {{ request()->routeIs('admin.category_form_field_option_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Form Option</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.category_form_field') }}"
                                        class="nav-link {{ request()->routeIs('admin.category_form_field') ? 'active' : '' }} {{ request()->routeIs('admin.add_category_form_field') ? 'active' : '' }} {{ request()->routeIs('admin.category_form_field_edit') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Form</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.profile') }}"
                                class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>Profile</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p class="text">Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">