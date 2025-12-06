@extends('admin.layouts.app')

@section('title', 'Add Coupon')


@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Coupon</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Coupon</li>
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
                                            <label for="code" class="form-label">Code <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" id="code" name="code"
                                                placeholder="Enter Code" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="title" class="form-label">Title <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                placeholder="Enter Title" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="discount_type" class="form-label">Discount Type <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="discount_type" required
                                                id="discount_type">
                                                <option value="" selected>Select</option>
                                                <option value="percentage">percentage</option>
                                                <option value="fixed">fixed</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="discount_value" class="form-label">Discount Value <span
                                                    class="text-red">*</span></label>
                                            <input type="number" step="any" class="form-control" id="discount_value"
                                                name="discount_value" placeholder="Enter Discount Value" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="end_date" class="form-label">End Date <span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                placeholder="Enter End Date" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="usage_limit" class="form-label">Usage Limit <span
                                                    class="text-red">*</span></label>
                                            <input type="number" step="any" class="form-control" id="usage_limit"
                                                name="usage_limit" placeholder="Enter Usage Limit" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="type" class="form-label">Type <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="type" required id="type">
                                                <option value="" selected>Select</option>
                                                <option value="1">Offline</option>
                                                <option value="2">Online</option>
                                                <option value="3">Subscription</option>
                                                <option value="4">Booking</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile">Image <span class="text-red">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="image" required
                                                        id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>


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

<script src="{{asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

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
        url: '{{route("admin.insert_coupon")}}',
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