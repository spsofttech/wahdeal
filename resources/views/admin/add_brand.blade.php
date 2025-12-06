@extends('admin.layouts.app')

@section('title', 'Add Brand')

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
                        <h1 class="m-0">Add Brand</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Brand</li>
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



                                        <div class="form-group col-md-6">
                                            <label for="page" class="form-label">Category <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="category_id" id="category_id" required
                                                onchange="get_subcategory(this.value)">
                                                <option value="" selected>Select Category</option>
                                                @foreach($category as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="page" class="form-label">SubCategory</label>
                                            <select class="form-control" name="subcategory_id" id="subcategory_id">
                                                <option value="" selected>Select SubCategory</option>
                                            </select>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name"
                                                required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile">Upload Icon <span
                                                    class="text-red">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="image" required
                                                        id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile2">Upload Banner Image <span
                                                    class="text-red">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="banner_image" required
                                                        id="exampleInputFile2">
                                                    <label class="custom-file-label" for="exampleInputFile2">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="title" class="form-label">Description <span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control" id="description" name="description"
                                                placeholder="Enter Description" required></textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="website" class="form-label">Website</label>
                                            <input type="text" class="form-control" name="website"
                                                placeholder="Enter Website">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="veg_nonveg" class="form-label">Veg/Non Veg</label>
                                            <select class="form-control" name="veg_nonveg" id="veg_nonveg">
                                                <option value="" selected>Select</option>
                                                <option value="1">Veg</option>
                                                <option value="2">Non Veg</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="menus">Brand Menu Images</label>
                                            <input type="file" name="menus[]" class="form-control" multiple
                                                accept="image/*">
                                            <small class="text-muted">You can select multiple menu images.</small>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="menus">Brand Gallary Images</label>
                                            <input type="file" name="gallery[]" class="form-control" multiple
                                                accept="image/*">
                                            <small class="text-muted">You can select multiple gallery images.</small>
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
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

<script src="{{asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category_id').select2({
        allowClear: true
        });

        $('#subcategory_id').select2({
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
    $(".fa-spinner").removeClass("d-none");
    $.ajax({
        url: '{{route("admin.insert_brand")}}',
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
            var errors = xhr.responseJSON.errors;
            $("#email-error").html(errors.email);
        }
    });
});

function get_subcategory(id) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "{{ route('admin.get_subcategory') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            id: id,
        },
        success: function(response) {
            if (response.status === 'success') {
                $('#subcategory_id').empty();
                $('#subcategory_id').append('<option value="">Select SubCategory</option>');
                $.each(response.data, function(index, subcat) {
                    $('#subcategory_id').append(
                        `<option value="${subcat.id}">${subcat.name}</option>`
                    );
                });
            } else {
                $('#subcategory_id').empty().append('<option value="">No SubCategories Found</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

</script>

@endsection