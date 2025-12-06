@extends('admin.layouts.app')

@section('title', 'Add News')

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
                        <h1 class="m-0">News</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">News</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add News</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="registerForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">



                                    <div class="form-group">
                                        <label for="exampleInputFile">Image <span class="text-red">*</span></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="form-control" id="exampleInputFile"
                                                    name="image" accept="image/*" required>
                                                <label class="custom-file-label" for="exampleInputFile">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Video</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="form-control" name="video">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="link" class="form-label">Youtube Link</label>
                                        <input type="text" class="form-control" name="link" placeholder="Enter Link"
                                            value="{{ old('link') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="form-label">Title <span
                                                class="text-red">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="Enter Title" value="{{ old('title') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="form-label">Description <span
                                                class="text-red">*</span></label>
                                        <textarea class="form-control" id="description" name="description"
                                            placeholder="Enter Description" value="{{ old('description') }}"
                                            required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="form-label">Is Highlight</label>
                                        <label class="switch"><input type="checkbox" name="ishighlight"><span
                                                class="slider"></span></label>
                                    </div>



                                </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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

<script src="{{asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}">
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
        url: '{{route("admin.insert_news")}}',
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
                $('#registerForm')[0].reset();
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