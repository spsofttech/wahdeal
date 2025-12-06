@extends('brand.layouts.app')

@section('title', 'Add Branch')

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
                        <h1 class="m-0">Add Branch</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('brand.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Branch</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
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



                                        <div class="form-group col-md-4">
                                            <label for="state" class="form-label">State<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="state"
                                                placeholder="Enter State" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="city" class="form-label">City<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="city" placeholder="Enter City"
                                                required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="area" class="form-label">Area<span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control" name="area" placeholder="Enter Area"
                                                required></textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="pincode" class="form-label">Pincode<span
                                                    class="text-red">*</span></label>
                                            <input type="number" class="form-control" name="pincode"
                                                placeholder="Enter Pincode" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="contact" class="form-label">Contact No<span
                                                    class="text-red">*</span></label>
                                            <input type="number" class="form-control" name="contact"
                                                placeholder="Enter Contact No" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="address" class="form-label">Address<span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control" name="address" placeholder="Enter Address"
                                                required></textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="latitude" class="form-label">Latitude<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="latitude"
                                                placeholder="Enter Latitude" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="longitude" class="form-label">Longitude<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="longitude"
                                                placeholder="Enter Longitude" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="facebook" class="form-label">Facebook</label>
                                            <input type="text" class="form-control" name="facebook"
                                                placeholder="Enter Facebook">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="twitter" class="form-label">Twitter</label>
                                            <input type="text" class="form-control" name="twitter"
                                                placeholder="Enter Twitter">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="instagram" class="form-label">Instagram</label>
                                            <input type="text" class="form-control" name="instagram"
                                                placeholder="Enter Instagram">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="linkedin" class="form-label">linkedin</label>
                                            <input type="text" class="form-control" name="linkedin"
                                                placeholder="Enter Linkedin">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="pinterest" class="form-label">Pinterest</label>
                                            <input type="text" class="form-control" name="pinterest"
                                                placeholder="Enter Pinterest">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="whatsapp_no" class="form-label">Whatsapp No</label>
                                            <input type="number" class="form-control" name="whatsapp_no"
                                                placeholder="Enter Whatsapp no">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="is_booking" class="form-label">Is Booking <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_booking" required id="is_booking">
                                                <option value="" selected>Select</option>
                                                <option value="1">Yes
                                                </option>
                                                <option value="0">No
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="is_appointment" class="form-label">Is Appointment <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_appointment" required
                                                id="is_appointment">
                                                <option value="" selected>Select</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>

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
                                                    <tr>
                                                        <td>{{ $day }}</td>
                                                        <td>
                                                            <input type="time" name="timings[{{ $day }}][open_time]"
                                                                class="form-control" value="09:00" required>
                                                        </td>
                                                        <td>
                                                            <input type="time" name="timings[{{ $day }}][close_time]"
                                                                class="form-control" value="22:00" required>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="timings[{{ $day }}][status]" value="1"
                                                                    checked>
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

                                        <div class="form-group col-md-12">
                                            <label for="menus">Gallary Images</label>
                                            <input type="file" name="gallery[]" class="form-control" multiple
                                                accept="image/*">
                                            <small class="text-muted">You can select multiple gallery images.</small>
                                        </div>



                                        <!-- Submit Button -->
                                        <div class="form-group col-md-12 text-right">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    $(document).ready(function() {
        $('#brand').select2({
        allowClear: true
        });
    });
</script>


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
    // Send the AJAX request
    $.ajax({
        url: '{{route("brand.insert_branch")}}',
        type: 'POST',
        data: formData,
        processData: false, // Don't process data
        contentType: false,
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
            }
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            $("#email-error").html(errors.email);
        }
    });
});


</script>

@endsection