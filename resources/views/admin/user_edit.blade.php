@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
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
                                <input type="hidden" class="form-control" name="id" value="{{ $user->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Image -->
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile">Image <span class="text-red">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" id="exampleInputFile"
                                                        name="image">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <br>
                                            <img src="{{ asset('uploads/user/' . ($user->image ?? 'logo.png')) }}"
                                                style="width:50px">
                                        </div>

                                        <!-- First Name -->
                                        <div class="form-group col-md-4">
                                            <label for="first_name" class="form-label">First Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="first_name"
                                                value="{{ $user->first_name }}" required>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="form-group col-md-4">
                                            <label for="last_name" class="form-label">Last Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="last_name"
                                                value="{{ $user->last_name }}" required>
                                        </div>

                                        <!-- Gender -->
                                        <div class="form-group col-md-4">
                                            <label for="gender" class="form-label">Gender <span
                                                    class="text-red">*</span></label><br>
                                            <input type="radio" name="gender" value="Male"
                                                {{ (isset($user->gender) && $user->gender == 'Male') ? 'checked' : '' }}>&nbsp;Male
                                            <input type="radio" name="gender" value="Female"
                                                {{ (isset($user->gender) && $user->gender == 'Female') ? 'checked' : '' }}>&nbsp;Female
                                        </div>

                                        <!-- DOB -->
                                        <div class="form-group col-md-4">
                                            <label for="dob" class="form-label">DOB <span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control" name="dob"
                                                value="{{ $user->date_of_birth }}" required>
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group col-md-4">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $user->email }}" readonly>
                                        </div>

                                        <!-- Phone No -->
                                        <div class="form-group col-md-4">
                                            <label for="phone" class="form-label">Phone No.</label>
                                            <input type="number" class="form-control" name="phone"
                                                value="{{ $user->mobile }}" readonly>
                                        </div>

                                        <!-- User Name -->
                                        <div class="form-group col-md-4">
                                            <label for="username" class="form-label">User Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="username"
                                                value="{{ $user->user_name }}" required>
                                        </div>

                                        <!-- Nick Name -->
                                        <div class="form-group col-md-4">
                                            <label for="nickname" class="form-label">Nick Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="nickname"
                                                value="{{ $user->nick_name }}" required>
                                        </div>

                                        <!-- Location -->
                                        <div class="form-group col-md-4">
                                            <label for="location" class="form-label">Location <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="location"
                                                value="{{ $user->city }}" required>
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


            <!-- <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div> -->
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
<script src="{{asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}">
</script>

<script>
$(function() {
    bsCustomFileInput.init();
});
</script>

<script>
$('#registerForm').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission
    var formData = new FormData(this);
    $("#email-error").html('');

    // Send the AJAX request
    $.ajax({
        url: '{{route("admin.update_user")}}',
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
            } else {
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
            var errors = xhr.responseJSON.errors;
            $("#email-error").html(errors.email);
        }
    });
});
</script>

@endsection