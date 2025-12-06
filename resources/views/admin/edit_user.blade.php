@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
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
                                        <div class="form-group col-md-4">
                                            <label for="first_name" class="form-label">First Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="first_name"
                                                placeholder="Enter First Name" required value="{{$user->first_name}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="last_name" class="form-label">Last Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="last_name"
                                                placeholder="Enter Last Name" required value="{{$user->last_name}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="mobile" class="form-label">Mobile</label>
                                            <input type="number" class="form-control" name="mobile"
                                                placeholder="Enter Mobile" value="{{$user->mobile}}" readonly>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Enter Email" value="{{$user->email}}" readonly>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="gender" class="form-label">Gender <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="gender" id="gender" required>
                                                <option value="" selected>Select Gender</option>
                                                <option value="Male" @if($user->gender == 'Male') selected @endif>Male
                                                </option>
                                                <option value="Female" @if($user->gender == 'Female') selected
                                                    @endif>Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile">Upload Image <span
                                                    class="text-red">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="image"
                                                        id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div><br>
                                            <img src="{{ asset('uploads/user/' . ($user->image ?? 'logo.png')) }}"
                                                style="width:100px">
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Enter Password">
                                        </div>

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

    $(".fa-spinner").removeClass("d-none");
    $.ajax({
        url: '{{route("admin.update_user")}}',
        type: 'POST',
        data: formData,
        processData: false, // Don't process data
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