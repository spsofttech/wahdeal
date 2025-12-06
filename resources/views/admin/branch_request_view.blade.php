@extends('admin.layouts.app')

@section('title', 'View Branch Request')

@section('styles')
<style>
    .cke_notification_warning {
        display: none !important;
    }
</style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">View Branch Request</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Branch</li>
                        </ol>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <label for="page" class="form-label">Approve/Reject</label>
                    <select class="form-control" onchange="changestatus(this.value)">
                        <option value="">Select Status</option>
                        <option value="approved">Approve</option>
                        <option value="rejected">Reject</option>
                    </select>
                </div>



            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form id="registerForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">

                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>About: </label> {{ strip_tags($about) }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->state != $oldbranch->state ? 'text-danger font-weight-bold' : '' }}">
                                                State:
                                            </label>
                                            {{ $branch->state }}
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->city != $oldbranch->city ? 'text-danger font-weight-bold' : '' }}">City:
                                            </label> {{ $branch->city }}
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->area != $oldbranch->area ? 'text-danger font-weight-bold' : '' }}">Area:
                                            </label> {{ $branch->area }}
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->pincode != $oldbranch->pincode ? 'text-danger font-weight-bold' : '' }}">Pincode:
                                            </label> {{ $branch->pincode }}
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label
                                                class="{{ $branch->address != $oldbranch->address ? 'text-danger font-weight-bold' : '' }}">Address:
                                            </label> {{ $branch->address }}
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->latitude != $oldbranch->latitude ? 'text-danger font-weight-bold' : '' }}">Latitude:
                                            </label> {{ $branch->latitude }}
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->longitude != $oldbranch->longitude ? 'text-danger font-weight-bold' : '' }}">Longitude:
                                            </label> {{ $branch->longitude }}
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->facebook != $oldbranch->facebook ? 'text-danger font-weight-bold' : '' }}">Facebook:
                                            </label> {{ $branch->facebook }}
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->twitter != $oldbranch->twitter ? 'text-danger font-weight-bold' : '' }}">Twitter:
                                            </label> {{ $branch->twitter }}
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->instagram != $oldbranch->instagram ? 'text-danger font-weight-bold' : '' }}">Instagram:
                                            </label> {{ $branch->instagram }}
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->linkedin != $oldbranch->linkedin ? 'text-danger font-weight-bold' : '' }}">Linkedin:
                                            </label> {{ $branch->linkedin }}
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->pinterest != $oldbranch->pinterest ? 'text-danger font-weight-bold' : '' }}">Pinterest:
                                            </label> {{ $branch->pinterest }}
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->is_booking != $oldbranch->is_booking ? 'text-danger font-weight-bold' : '' }}">Is
                                                Booking: </label> @if($branch->is_booking == '1') Yes @else No
                                            @endif
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label
                                                class="{{ $branch->is_appointment != $oldbranch->is_appointment ? 'text-danger font-weight-bold' : '' }}">Is
                                                Appointment: </label> @if($branch->is_appointment == '1') Yes
                                            @else No
                                            @endif
                                        </div>






                                        <!-- Branch Timing Section -->
                                        <div class="col-md-12 mt-4">
                                            <h4>Branch Timings</h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>Open Time</th>
                                                        <th>Close Time</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $days =
                                                    ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                                                    $old = collect($oldtime)->keyBy('day')->toArray();
                                                    @endphp

                                                    @foreach($days as $day)
                                                    @php
                                                    $t = $timing[$day];
                                                    $new_open = $t['open_time'];
                                                    $new_close = $t['close_time'];
                                                    $new_status = $t['status'];

                                                    $old_open = $old[$day]['open_time'] ?? '';
                                                    $old_close = $old[$day]['close_time'] ?? '';
                                                    $old_status = $old[$day]['status'] ?? '';
                                                    @endphp

                                                    {{-- highlight entire row if ANY value does NOT match --}}
                                                    <tr>

                                                        <td>{{ $day }}</td>

                                                        <td
                                                            class="{{ $new_open != $old_open ? 'text-danger font-weight-bold' : '' }}">
                                                            {{ $new_open }}
                                                        </td>

                                                        <td
                                                            class="{{ $new_close != $old_close ? 'text-danger font-weight-bold' : '' }}">
                                                            {{ $new_close }}
                                                        </td>

                                                        <td
                                                            class="text-center {{ $new_status != $old_status ? 'text-danger font-weight-bold' : '' }}">
                                                            {{ $new_status ? 'Active' : 'Deactive' }}
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="menus">Menu Images</label><br>

                                            @php
                                            $oldImages = $oldmenu->pluck('image')->toArray();
                                            $newImages = $menus['images'] ?? [];
                                            @endphp

                                            @foreach($newImages as $image)
                                            @php
                                            $isNew = !in_array($image, $oldImages);
                                            @endphp

                                            <img src="{{ asset('uploads/brand/'.$image) }}"
                                                class="img-thumbnail mb-2 {{ $isNew ? 'border border-danger' : '' }}"
                                                style="width:100px;height:100px;">
                                            @endforeach
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label for="menus">Gallery Images</label><br>

                                            @php
                                            $oldGalleryImages = $oldgallery->pluck('image')->toArray();
                                            $newGalleryImages = $gallery['images'] ?? [];
                                            @endphp

                                            @foreach($newGalleryImages as $image)
                                            @php
                                            $isNew = !in_array($image, $oldGalleryImages);
                                            @endphp

                                            <img src="{{ asset('uploads/brand/'.$image) }}"
                                                class="img-thumbnail mb-2 {{ $isNew ? 'border border-danger' : '' }}"
                                                style="width:100px;height:100px;">
                                            @endforeach
                                        </div>




                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


<script>
    function changestatus(status) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "{{ route('admin.branch_request_change_status') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            id: '{{ $id }}',
            status:status
        },
        success: function(response) {
             if (response.status == 'success') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    toast: true,
                    timer: 5000
                });
                window.location.href = response.redirect;
            }else{
                 Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: response.message,
                    showConfirmButton: false,
                    toast: true,
                    timer: 5000
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
</script>
@endsection