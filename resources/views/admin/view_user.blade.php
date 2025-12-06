@extends('admin.layouts.app')

@section('title', 'View User')

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
                                src="{{ asset('uploads/user/' . ($user->image ?? 'logo.png')) }}"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $user->first_name }} {{ $user->last_name}}</h3>

                        <p class="text-muted text-center">{{ $user->email }}</p>

                        <p class="text-muted text-center">
                            @if($user->status == '1')
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
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Contact No</strong>

                        <p class="text-muted">
                            {{ $user->mobile }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                        <p class="text-muted">{{ $user->city }}, {{ $user->state }}</p>

                        <hr>

                        <strong><i class="fas fa-user mr-1"></i> Reffer By</strong>

                        <p class="text-muted">{{ $ref_user->first_name ?? '' }} {{ $ref_user->last_name ?? '' }}</p>

                        <hr>

                        <strong><i class="fas fa-wallet mr-1"></i> Wallet Balance</strong>

                        <p class="text-muted">{{ $user->wallet_balance ?? '-' }}</p>

                        <hr>

                        <strong><i class="fas fa-calendar mr-1"></i> Registration Date</strong>

                        <p class="text-muted">{{ $user->created_at ? $user->created_at->format('d M, Y h:i A') : '-' }}
                        </p>


                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#Addresses"
                                    data-toggle="tab">Addresses</a></li>
                            <li class="nav-item"><a class="nav-link" href="#Deals" data-toggle="tab">Deals</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#user_likes" data-toggle="tab">User Like</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#user_booking" data-toggle="tab">Booking</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="Addresses">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Full Address</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($user_address as $val)
                                                <tr>
                                                    <td><strong>{{ ucfirst($val->type) }}</strong></td>
                                                    <td>
                                                        {{ $val->address_1 ?? '' }}
                                                        @if(!empty($val->address_2)), {{ $val->address_2 }} @endif
                                                        @if(!empty($val->address_3)), {{ $val->address_3 }} @endif
                                                        @if(!empty($val->address_4)), {{ $val->address_4 }} @endif
                                                        @if(!empty($val->pincode)) - {{ $val->pincode }} @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-3">
                                                        <i class="fas fa-info-circle me-1"></i> No addresses found.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="Deals">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Offer</th>
                                                    <th>Branch</th>
                                                    <th>Brand</th>
                                                    <th>Product</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse ($deal as $dval)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>

                                                    <td><strong>{{ $dval->offer->title ?? '-' }}</strong></td>
                                                    <td>
                                                        {{ $dval->branch->address ?? '-' }},
                                                        {{ $dval->branch->city ?? '-' }} -
                                                        {{ $dval->branch->pincode ?? '-' }},
                                                        {{ $dval->branch->state ?? '-' }}
                                                    </td>
                                                    <td>{{ $dval->product->brand->name ?? '-' }}</td>
                                                    <td>{{ $dval->product->name ?? '-' }}</td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="user_likes">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Brand</th>
                                                    <th>Product</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <tr>
                                                    <td>{{ $b_like }}</td>
                                                    <td>{{ $p_like }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane" id="user_booking">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Brand</th>
                                                    <th>Branch</th>
                                                    <th>Booking/Appointment</th>
                                                    <th>Booking/Appointment Data</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse ($booking as $key => $bval)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $bval->brand->name ?? '-' }}</td>
                                                    <td>{{ $bval->branch->address }}, {{ $bval->branch->state }}, {{
                                                        $bval->branch->city }}, {{ $bval->branch->pincode }}</td>
                                                    <td>
                                                        @if($bval->is_booking_appointment == 1)
                                                        Booking
                                                        @else
                                                        Appointment
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                        $formData = json_decode($bval->form_data, true);
                                                        @endphp

                                                        @if(is_array($formData))
                                                        <ul>
                                                            @foreach($formData as $fd)
                                                            <li><strong>{{ $fd['label'] }}:</strong> {{ $fd['value'] }}
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                    <td>{{ $bval->book_status_text ?? '-' }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No data found</td>
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