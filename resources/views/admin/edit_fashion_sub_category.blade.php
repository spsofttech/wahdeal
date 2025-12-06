@extends('admin.layouts.app')

@section('title', 'Edit Fashion SubCategory')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Fashion SubCategory</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Fashion SubCategory</li>
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

                                        <input type="hidden" class="form-control" name="id"
                                            value="{{ $subcategory->id }}">

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">Category <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="category_id" required id="category_id">
                                                <option value="">Select Category</option>
                                                @foreach($category as $val)
                                                <option value="{{$val->id}}" {{ isset($subcategory) && $subcategory->
                                                    category_id == $val->id ? 'selected' : '' }}>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name"
                                                required value="{{ $subcategory->name }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name" class="form-label">GST</label>
                                            <input type="text" class="form-control" name="gst" placeholder="Enter GST"
                                                value="{{ $subcategory->gst }}">
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
                                            <img src="{{ asset('uploads/subcategory/' . ($subcategory->icon ?? 'logo.png')) }}"
                                                style="width:50px">
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category_id').select2({
        placeholder: "Select Category",
        allowClear: true
        });
    });
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
        url: '{{route("admin.update_fashion_sub_category")}}',
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