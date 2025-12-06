@php
$roles = getBranchRoles();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business | @yield('title', 'Wahdeal')</title>


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
            <a href="{{ route('brand.dashboard') }}" class="brand-link">
                <!-- <img src="{{asset('images/logo.jpg')}}" alt="Explorr" class="brand-image elevation-3"> -->

            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">


                        <li class="nav-item">
                            <a href="{{ route('brand.dashboard') }}"
                                class="nav-link {{ request()->routeIs('brand.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        @if(in_array('branch', $roles))
                        <li class="nav-item">
                            <a href="{{ route('brand.branch') }}"
                                class="nav-link {{ request()->routeIs('brand.branch') ? 'active' : '' }} {{ request()->routeIs('brand.add_branch') ? 'active' : '' }} {{ request()->routeIs('brand.branch_edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Branch</p>
                            </a>
                        </li>
                        @endif


                        @if(in_array('product', $roles))
                        <li class="nav-item">
                            <a href="{{ route('brand.product') }}"
                                class="nav-link {{ request()->routeIs('brand.product') ? 'active' : '' }} {{ request()->routeIs('brand.add_product') ? 'active' : '' }} {{ request()->routeIs('brand.product_edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Product</p>
                            </a>
                        </li>
                        @endif

                        @if(in_array('order', $roles))
                        <li class="nav-item">
                            <a href="{{ route('brand.order') }}"
                                class="nav-link {{ request()->routeIs('brand.order') ? 'active' : '' }} {{ request()->routeIs('brand.order_view') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Order</p>
                            </a>
                        </li>
                        @endif




                        <li class="nav-item">
                            <a href="{{ route('brand.logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p class="text">Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">