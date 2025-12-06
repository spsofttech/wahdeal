@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Category</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Category</li>
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

                                        <input type="hidden" class="form-control" name="id" value="{{ $category->id }}">



                                        <div class="form-group col-md-4">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name"
                                                required value="{{ $category->name }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile">Upload Icon <span
                                                    class="text-red">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" id="exampleInputFile"
                                                        name="image">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <br>
                                            <img src="{{ asset('uploads/category/' . ($category->icon ?? 'logo.png')) }}"
                                                style="width:50px">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">Is Fashion <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_fashion" required id="is_fashion">
                                                <option value="" selected>Select</option>
                                                <option value="1" @if($category->is_fashion == '1') selected @endif>Yes
                                                </option>
                                                <option value="0" @if($category->is_fashion == '0') selected @endif>No
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="is_booking" class="form-label">Is Booking <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_booking" required id="is_booking">
                                                <option value="" selected>Select</option>
                                                <option value="1" @if($category->is_booking == '1') selected @endif>Yes
                                                </option>
                                                <option value="0" @if($category->is_booking == '0') selected @endif>No
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="is_appointment" class="form-label">Is Appointment <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_appointment" required
                                                id="is_appointment">
                                                <option value="" selected>Select</option>
                                                <option value="1" @if($category->is_appointment == '1') selected
                                                    @endif>Yes</option>
                                                <option value="0" @if($category->is_appointment == '0') selected
                                                    @endif>No</option>
                                            </select>
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

   $(".fa-spinner").removeClass("d-none");
    $.ajax({
        url: '{{route("admin.update_category")}}',
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