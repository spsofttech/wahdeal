@extends('admin.layouts.app')

@section('title', 'View Brand')

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
                                src="{{ asset('uploads/brand/' . ($brand->icon ?? 'logo.png')) }}" alt="Brand picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $brand->name }}</h3>

                        <p class="text-muted text-center">
                            @if($brand->status == '1')
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>

                        <p class="text-muted text-center">
                            @if($brand->veg_nonveg == '1')
                            <span class="badge bg-success">Veg</span>
                            @elseif($brand->veg_nonveg == '2')
                            <span class="badge bg-success">NonVeg</span>
                            @else
                            <span class="badge bg-success">Both</span>
                            @endif
                        </p>

                    </div>
                </div>

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Brand</h3>
                    </div>

                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Category</strong>

                        <p class="text-muted">
                            {{ $brand->category->name }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-folder mr-1"></i> Sub Category</strong>

                        <p class="text-muted">{{ $brand->subcategory->name }}</p>

                        <hr>

                        <strong><i class="fas fa-globe mr-1"></i> Website</strong>

                        <p class="text-muted">{{ $brand->website }}</p>

                        <hr>

                        <strong><i class="fas fa-bullhorn mr-1"></i> Is Promote</strong>

                        <p class="text-muted">
                            @if($brand->is_promote == '1')
                            <span class="badge bg-success">Yes</span>
                            @else
                            <span class="badge bg-danger">No</span>
                            @endif
                        </p>

                        <hr>

                        <strong><i class="fas fa-file-image mr-1"></i> Banner Image</strong>

                        <p class="text-muted">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('uploads/brand/' . ($brand->banner_image ?? 'logo.png')) }}"
                                alt="Brand banner picture">
                        </p>

                        <hr>

                        <strong><i class="fas fa-eye mr-1"></i>View</strong>

                        <p class="text-muted">
                            {{$total_view}}
                        </p>





                    </div>

                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#brand_description"
                                    data-toggle="tab">Description</a></li>
                            <li class="nav-item"><a class="nav-link" href="#brand_branch" data-toggle="tab">Branch</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#brand_menu" data-toggle="tab">Menu</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#brand_banner" data-toggle="tab">Banner</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="brand_description">
                                {{ strip_tags($brand->description) }}
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="brand_branch">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Area</th>
                                                    <th>Pincode</th>
                                                    <th>Contact No</th>
                                                    <th>QR Code</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($branch as $val)
                                                <tr>
                                                    <td>{{ $val->address }}</td>
                                                    <td>{{ $val->city }}</td>
                                                    <td>{{ $val->state }}</td>
                                                    <td>{{ $val->area }}</td>
                                                    <td>{{ $val->pincode }}</td>
                                                    <td>{{ $val->contact_no }}</td>
                                                    <td><img src="{{ asset('uploads/brand/'.$val->qr_code) }}"
                                                            class="img-thumbnail mb-2"
                                                            style="width:100px;height:100px;"></td>

                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-3">
                                                        <i class="fas fa-info-circle me-1"></i> No Branch found.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="brand_menu">
                                <div class="row">
                                    @foreach($menu as $menu)
                                    <div class="col-md-4 mb-4">
                                        <div class="card shadow-sm border-0">
                                            <img src="{{ asset('uploads/brand/' . $menu->image) }}"
                                                class="card-img-top img-fluid rounded" alt="Brand Menu Image"
                                                style="width:50%; height:50%;">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tab-pane" id="brand_banner">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Own Banner</th>
                                                    <th>Type</th>
                                                    <th>Image</th>
                                                    <th>Website</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($banner as $val)
                                                <tr>
                                                    <td>{{ $val->own_banner == '0' ? 'Not Own' : 'Own' }}</td>
                                                    <td>{{ $val->type }}</td>
                                                    <td><img src="{{ asset('uploads/brand/'.$val->image) }}"
                                                            class="img-thumbnail mb-2"
                                                            style="width:100px;height:100px;"></td>
                                                    <td>{{ $val->website }}</td>

                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-3">
                                                        <i class="fas fa-info-circle me-1"></i> No Image found.
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