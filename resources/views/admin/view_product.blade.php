@extends('admin.layouts.app')

@section('title', 'View Product')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row mb-2 mt-2">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('uploads/product/' . ($product->image ?? 'logo.png')) }}"
                                alt="Brand picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $product->name }}</h3>

                        <p class="text-muted text-center">
                            @if($product->status == '1')
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>

                    </div>
                </div>

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Product</h3>
                    </div>

                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Category</strong>

                        <p class="text-muted">
                            {{ $product->category->name }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-folder mr-1"></i> Sub Category</strong>

                        <p class="text-muted">{{ $product->subcategory->name }}</p>

                        <hr>

                        <strong><i class="fas fa-briefcase mr-1"></i> Brand</strong>

                        <p class="text-muted">{{ $product->brand->name }}</p>

                        <hr>

                        <strong><i class="fas fa-money-bill-wave mr-1"></i> Price</strong>

                        <p class="text-muted">{{ $product->price }}</p>






                    </div>

                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#brand_description"
                                    data-toggle="tab">Description</a></li>
                            <li class="nav-item"><a class="nav-link" href="#product_image_data"
                                    data-toggle="tab">Product Images</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#product_rating_data"
                                    data-toggle="tab">Product Rating</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="brand_description">
                                <p><b>Description : </b><br>{{ strip_tags($product->description) }}</p>
                                <p><b>Disclaimer : </b><br>{{ strip_tags($product->disclaimer) }}</p>
                                <p><b>Veg/Nonveg : </b><br>@if($product->veg_nonveg == '1') veg
                                    @elseif($product->veg_nonveg == '2') Non veg @else Both @endif
                                </p>
                                <p><b>Online/Offline : </b><br>@if($product->is_fashion == '0') Offline
                                    @elseif($product->is_fashion == '1') Online @else Both @endif
                                </p>
                                <p><b>Promote : </b><br>@if($product->is_promote == '0') No
                                    @else Yes @endif
                                </p>
                            </div>


                            <div class="tab-pane" id="product_image_data">
                                <div class="row">
                                    @foreach($product_image as $val)
                                    <div class="col-md-4 mb-4">
                                        <div class="card shadow-sm border-0">
                                            <img src="{{ asset('uploads/product/' . $val->image) }}"
                                                class="card-img-top img-fluid rounded" alt="Product Image"
                                                style="width:50%; height:50%;">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tab-pane" id="product_rating_data">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Image</th>
                                                    <th>Rating</th>
                                                    <th>Review</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($product_review as $val)
                                                <tr>
                                                    <td>{{ $val->user->first_name }} {{ $val->user->last_name }}</td>
                                                    <td><img src="{{ asset('uploads/user/'.$val->user->image) }}"
                                                            class="img-thumbnail mb-2" style="width:50px;height:50px;">
                                                    </td>
                                                    <td>{{ $val->rating }}</td>
                                                    <td>{{ $val->review }}</td>

                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-3">
                                                        <i class="fas fa-info-circle me-1"></i> No Review found.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    </div>
</section>
@endsection

@section('scripts')


@endsection