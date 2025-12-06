@extends('admin.layouts.app')

@section('title', 'Edit Branch')

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
                        <h1 class="m-0">Edit Branch</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Branch</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form id="registerForm" method="POST" enctype="multipart/form-data">
                                <input type="hidden" class="form-control" name="id" value="{{ $branch->id }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label>Brand <span class="text-red">*</span></label>
                                            <select class="form-control" name="brand" readonly>
                                                <option value="">Select Brand</option>
                                                @foreach($brand as $val)
                                                <option value="{{ $val->id }}" {{ $branch->brand_id == $val->id ?
                                                    'selected' : '' }}>
                                                    {{ $val->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Contact No<span class="text-red">*</span></label>
                                            <input type="number" class="form-control" name="contact"
                                                value="{{ $branch->contact_no }}" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="email" class="form-label">Email<span
                                                    class="text-red">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Enter Email" required value="{{ $branch->email }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>State<span class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="state"
                                                value="{{ $branch->state }}" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>City<span class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ $branch->city }}" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Pincode<span class="text-red">*</span></label>
                                            <input type="number" class="form-control" name="pincode"
                                                value="{{ $branch->pincode }}" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Address<span class="text-red">*</span></label>
                                            <textarea class="form-control" name="address"
                                                required>{{ $branch->address }}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Area<span class="text-red">*</span></label>
                                            <textarea class="form-control" name="area"
                                                required>{{ $branch->area }}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Latitude<span class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="latitude"
                                                value="{{ $branch->latitude }}" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Longitude<span class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="longitude"
                                                value="{{ $branch->longitude }}" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="is_booking" class="form-label">Is Booking <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_booking" required id="is_booking">
                                                <option value="" selected>Select</option>
                                                <option value="1" @if($branch->is_booking == '1') selected @endif>Yes
                                                </option>
                                                <option value="0" @if($branch->is_booking == '0') selected @endif>No
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="is_appointment" class="form-label">Is Appointment <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_appointment" required
                                                id="is_appointment">
                                                <option value="" selected>Select</option>
                                                <option value="1" @if($branch->is_appointment == '1') selected
                                                    @endif>Yes</option>
                                                <option value="0" @if($branch->is_appointment == '0') selected
                                                    @endif>No</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="facebook" class="form-label">Facebook</label>
                                            <input type="text" class="form-control" name="facebook"
                                                placeholder="Enter Facebook" value="{{ $branch->facebook }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="twitter" class="form-label">Twitter</label>
                                            <input type="text" class="form-control" name="twitter"
                                                placeholder="Enter Twitter" value="{{ $branch->twitter }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="instagram" class="form-label">Instagram</label>
                                            <input type="text" class="form-control" name="instagram"
                                                placeholder="Enter Instagram" value="{{ $branch->instagram }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="linkedin" class="form-label">linkedin</label>
                                            <input type="text" class="form-control" name="linkedin"
                                                placeholder="Enter Linkedin" value="{{ $branch->linkedin }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="pinterest" class="form-label">Pinterest</label>
                                            <input type="text" class="form-control" name="pinterest"
                                                placeholder="Enter Pinterest" value="{{ $branch->pinterest }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="whatsapp_no" class="form-label">Whatsapp No</label>
                                            <input type="number" class="form-control" name="whatsapp_no"
                                                placeholder="Enter Whatsapp no" value="{{ $branch->whatsapp_no }}">
                                        </div>


                                        <div class="form-group col-md-12">
                                            <label for="title" class="form-label">About</label>
                                            <textarea class="form-control" id="description" name="description"
                                                placeholder="Enter Description">{{ $branch->about }}</textarea>
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
                                                    @endphp
                                                    @foreach($days as $day)
                                                    @php
                                                    $t = $timing[$day];
                                                    $open = \Carbon\Carbon::parse($t['open_time'])->format('H:i');
                                                    $close = \Carbon\Carbon::parse($t['close_time'])->format('H:i');
                                                    $active = $t['status'];
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $day }}</td>
                                                        <td>
                                                            <input type="time" name="timings[{{ $day }}][open_time]"
                                                                value="{{ $open }}" class="form-control" required>
                                                        </td>
                                                        <td>
                                                            <input type="time" name="timings[{{ $day }}][close_time]"
                                                                value="{{ $close }}" class="form-control" required>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="timings[{{ $day }}][status]" value="1" {{
                                                                    $active ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="menus">Menu Images</label>
                                            <input type="file" name="menus[]" class="form-control" multiple
                                                accept="image/*">
                                            <small class="text-muted">You can select multiple menu images.</small>
                                        </div>

                                        @if(isset($menus) && $menus->count())

                                        @foreach($menus as $menu)
                                        <div class="col-md-2 text-center" id="remove_menu_{{ $menu->id }}">
                                            <img src="{{ asset('uploads/brand/'.$menu->image) }}"
                                                class="img-thumbnail mb-2" style="width:100px;height:100px;"><br>
                                            <button type="button" class="btn btn-danger btn-sm deleteMenu"
                                                onclick="deletemenu({{ $menu->id }})">Delete</button>
                                        </div>
                                        @endforeach

                                        @endif

                                        <div class="form-group col-md-12 mt-5">
                                            <label for="menus">Gallary Images</label>
                                            <input type="file" name="gallery[]" class="form-control" multiple
                                                accept="image/*">
                                            <small class="text-muted">You can select multiple gallery images.</small>
                                        </div>


                                        @if(isset($gallery) && $gallery->count())

                                        @foreach($gallery as $gimage)
                                        <div class="col-md-2 text-center" id="remove_gallery_{{ $gimage->id }}">
                                            <img src="{{ asset('uploads/brand/'.$gimage->image) }}"
                                                class="img-thumbnail mb-2" style="width:100px;height:100px;"><br>
                                            <button type="button" class="btn btn-danger btn-sm deleteMenu"
                                                onclick="deletegallery({{ $gimage->id }})">Delete</button>
                                        </div>
                                        @endforeach

                                        @endif

                                        <!-- Submit Button -->
                                        <div class="form-group col-md-12 text-right">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-spinner fa-spin d-none"></i>Submit</button>
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
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

<script src="{{asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(function() {
    bsCustomFileInput.init();
});

document.addEventListener("DOMContentLoaded", function() {
    // Initialize CKEditor
    CKEDITOR.replace('description');

    // Ensure CKEditor updates the textarea before submitting
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            Object.keys(CKEDITOR.instances).forEach(instance => {
                CKEDITOR.instances[instance].updateElement();
            });

            // Debug: Check if CKEditor values are being updated
            console.log("Disclaimer:", document.getElementById('description').value);
        });
    });
});
</script>


<script>
    $('#registerForm').submit(function(e) {
        e.preventDefault();
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var formData = new FormData(this);
        var formData = new FormData(this);
        $(".fa-spinner").removeClass("d-none");
        $.ajax({
            url: '{{ route("admin.update_branch") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $(".fa-spinner").addClass("d-none");
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
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });


function deletemenu(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want delete this data!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('admin.menu_delete') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $("#remove_menu_" + id).remove();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        }
    });
}

function deletegallery(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want delete this data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('admin.brand_gallery_delete') }}",
                    type: "POST",
                    data: {
                        _token: csrfToken,
                        id: id,
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $("#remove_gallery_" + id).remove();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error: ' + error);
                    }
                });
            }
        });
    }
</script>
@endsection