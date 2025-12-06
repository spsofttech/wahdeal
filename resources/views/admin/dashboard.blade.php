@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>



        <div class="row">

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$data['total_category']}}</h3>

                        <p>Category</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('admin.category') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>

                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$data['total_subcategory']}}</h3>

                        <p>SubCategory</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('admin.sub_category') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>

                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$data['total_brand']}}</h3>

                        <p>Brand</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('admin.brand') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>

                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$data['total_product']}}</h3>

                        <p>Product</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('admin.product') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>

                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{$data['total_event']}}</h3>

                        <p>Event</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('admin.event') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>

                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{$data['total_user']}}</h3>

                        <p>User</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('admin.user') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>

                </div>
            </div>


        </div>
    </div>
</section>
@endsection