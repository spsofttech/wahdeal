@extends('admin.layouts.app')

@section('title', 'Edit Brand')

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
                        <h1 class="m-0">Edit Brand</h1>
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
                                <input type="hidden" class="form-control" name="id" value="{{ $brand->id }}">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-6">
                                            <label for="page" class="form-label">Category <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="category_id" id="category_id" required
                                                onchange="get_subcategory(this.value)">
                                                <option value="" selected>Select Category</option>
                                                @foreach($category as $val)
                                                <option value="{{$val->id}}" {{ $val->id == $brand->category_id ?
                                                    'selected' : '' }}>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="page" class="form-label">SubCategory</label>
                                            <select class="form-control" name="subcategory_id" id="subcategory_id">
                                                <option value="" selected>Select SubCategory</option>
                                                @foreach($subcategory as $val)
                                                <option value="{{$val->id}}" {{ $val->id == $brand->subcategory_id ?
                                                    'selected' : '' }}>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name"
                                                required value="{{$brand->name}}">
                                        </div>



                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile">Upload Icon <span
                                                    class="text-red">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="image"
                                                        id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div><br>
                                            <img src="{{ asset('uploads/brand/' . ($brand->icon ?? 'logo.png')) }}"
                                                style="width:50px">
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile2">Upload Banner Image <span
                                                    class="text-red">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="banner_image"
                                                        id="exampleInputFile2">
                                                    <label class="custom-file-label" for="exampleInputFile2">Choose
                                                        file</label>
                                                </div>
                                            </div><br>
                                            <img src="{{ asset('uploads/brand/' . ($brand->banner_image ?? 'logo.png')) }}"
                                                style="width:100px">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="title" class="form-label">Description <span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control" id="description" name="description"
                                                placeholder="Enter Description"
                                                required>{{$brand->description}}</textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="website" class="form-label">Website</label>
                                            <input type="text" class="form-control" name="website"
                                                placeholder="Enter Website" value="{{$brand->website}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="veg_nonveg" class="form-label">Veg/Non Veg</label>
                                            <select class="form-control" name="veg_nonveg" id="veg_nonveg">
                                                <option value="" selected>Select</option>
                                                <option value="1" @if($brand->veg_nonveg == '1') selected @endif>Veg
                                                </option>
                                                <option value="2" @if($brand->veg_nonveg == '2') selected @endif>Non
                                                    Veg</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="menus">Menu Images</label>
                                            <input type="file" name="menus[]" class="form-control" multiple
                                                accept="image/*">
                                            <small class="text-muted">You can select multiple menu images.</small>
                                        </div>

                                        {{-- Show existing menu images if editing --}}
                                        @if(isset($menus) && $menus->count())

                                        @foreach($menus as $menu)
                                        <div class="col-md-2 text-center" id="remove_menu_{{ $menu->id }}">
                                            <img src="{{ asset('uploads/brand/'.$menu->image) }}"
                                                class="img-thumbnail mb-2" style="width:100px;height:100px;"><br>
                                            <button type="button" class="btn btn-danger btn-sm deleteMenu"
                                                onclick="deletemenu({{ $menu->id }})">Delete</button>
                                        </div>
                                        @endforeach

                                        @endif


                                        <div class="form-group col-md-12 mt-5">
                                            <label for="menus">Brand Gallary Images</label>
                                            <input type="file" name="gallery[]" class="form-control" multiple
                                                accept="image/*">
                                            <small class="text-muted">You can select multiple gallery images.</small>
                                        </div>


                                        @if(isset($gallery) && $gallery->count())

                                        @foreach($gallery as $gimage)
                                        <div class="col-md-2 text-center" id="remove_gallery_{{ $gimage->id }}">
                                            <img src="{{ asset('uploads/brand/'.$gimage->image) }}"
                                                class="img-thumbnail mb-2" style="width:100px;height:100px;"><br>
                                            <button type="button" class="btn btn-danger btn-sm deleteMenu"
                                                onclick="deletegallery({{ $gimage->id }})">Delete</button>
                                        </div>
                                        @endforeach

                                        @endif

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
        url: '{{route("admin.update_brand")}}',
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


function deletemenu(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want delete this data!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('admin.menu_delete') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $("#remove_menu_" + id).remove();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        }
    });
}


function deletegallery(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want delete this data!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('admin.brand_gallery_delete') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $("#remove_gallery_" + id).remove();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        }
    });
}

</script>

@endsection