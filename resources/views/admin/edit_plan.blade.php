@extends('admin.layouts.app')

@section('title', 'Edit Plan')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Plan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Plan</li>
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
                                <input type="hidden" class="form-control" name="id" value="{{ $plan->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="name" class="form-label">Title <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Enter Title" required value="{{$plan->title}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="month" class="form-label">Month <span
                                                    class="text-red">*</span></label>
                                            <input type="number" class="form-control" name="month"
                                                placeholder="Enter Month" required min="1" value="{{$plan->month}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="oldamount" class="form-label">Old Amount <span
                                                    class="text-red">*</span></label>
                                            <input type="number" step="1" class="form-control" name="old_amount"
                                                placeholder="Enter Old Amount" required value="{{$plan->old_amount}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="latestamount" class="form-label">Latest Amount <span
                                                    class="text-red">*</span></label>
                                            <input type="number" step="1" class="form-control" name="latest_amount"
                                                placeholder="Enter Latest Amount" required
                                                value="{{$plan->latest_amount}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="month" class="form-label">Discount Text <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="discount_text"
                                                placeholder="Enter Discount Text" required
                                                value="{{$plan->discount_text}}">
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
<script>
    $('#registerForm').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission
    var formData = new FormData(this);
    $("#email-error").html('');

    $(".fa-spinner").removeClass("d-none");
    $.ajax({
        url: '{{route("admin.update_plan")}}',
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