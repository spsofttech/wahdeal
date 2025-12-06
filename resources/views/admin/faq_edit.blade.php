@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit FAQ</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">FAQ</li>
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
                                <input type="hidden" class="form-control" name="id" value="{{ $faq->id }}">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <label for="name" class="form-label">Question <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="question"
                                                placeholder="Enter Question" required value="{{ $faq->question }}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="name" class="form-label">Answer <span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control" name="answer" placeholder="Enter Answer"
                                                required>{{ $faq->answer }}</textarea>
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
        url: '{{route("admin.update_faq")}}',
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