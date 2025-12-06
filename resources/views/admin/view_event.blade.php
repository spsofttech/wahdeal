@extends('admin.layouts.app')

@section('title', 'View Event')

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
                                src="{{ asset('uploads/event/' . ($event->event_image ?? 'logo.png')) }}"
                                alt="Brand picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $event->title }}</h3>

                        <p class="text-muted text-center">
                            @if($event->status == '1')
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
                        <h3 class="card-title">About Event</h3>
                    </div>

                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Category</strong>

                        <p class="text-muted">
                            {{ $event->category->name }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-book mr-1"></i> Address</strong>

                        <p class="text-muted">
                            {{ $event->address }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-calendar mr-1"></i> Start Date</strong>

                        <p class="text-muted">{{ \Carbon\Carbon::parse($event->start_date)->format('d, M Y'); }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-calendar mr-1"></i> End Date</strong>

                        <p class="text-muted">{{ \Carbon\Carbon::parse($event->end_date)->format('d, M Y'); }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-calendar mr-1"></i> Time</strong>

                        <p class="text-muted">{{ $event->time }}
                        </p>

                    </div>

                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#event_description"
                                    data-toggle="tab">Description</a></li>

                            <li class="nav-item"><a class="nav-link" href="#event_celebrities" data-toggle="tab">Event
                                    Celebrities</a></li>

                            <li class="nav-item"><a class="nav-link" href="#event_passes" data-toggle="tab">Event
                                    Passes</a></li>

                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="event_description">
                                <p><b>Description : </b><br>{{ strip_tags($event->description) }}</p>
                                <p><b>Organizer Name : </b><br>{{ $event->organizer_name }}</p>
                                <p><b>Organizer Image : </b><br><img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('uploads/event/' . ($event->organizer_image ?? 'logo.png')) }}"
                                        alt="Brand picture"></p>
                                <p><b>Organizer Contact No : </b><br>{{ $event->contact_no }}</p>
                                <p><b>Organizer Pass Pdf : </b><br><a
                                        href="{{ asset('uploads/event/' . $event->pass_pdf) }}" target="_blank">{{
                                        $event->pass_pdf }}</a>
                                </p>
                            </div>

                            <div class="tab-pane" id="event_celebrities">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Image</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($event_celebrities as $val)
                                                <tr>
                                                    <td>{{ $val->name }}</td>
                                                    <td><img src="{{ asset('uploads/event/'.$val->image) }}"
                                                            class="img-thumbnail mb-2" style="width:80px;height:80px;">
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-3">
                                                        <i class="fas fa-info-circle me-1"></i> No Data found.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="event_passes">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Day</th>
                                                    <th>Start Date</th>
                                                    <th>Time</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($event_passes as $val)
                                                <tr>
                                                    <td>{{ $val->day }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d, M Y');
                                                        }}
                                                    </td>
                                                    <td>{{ $val->time }}</td>
                                                    <td>{{ $val->price }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-3">
                                                        <i class="fas fa-info-circle me-1"></i> No Data found.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>




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