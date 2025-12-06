@extends('admin.layouts.app')

@section('title', 'Add Product')

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
                        <h1 class="m-0">Add Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
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

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">SubCategory</label>
                                            <select class="form-control" name="subcategory_id" id="subcategory_id"
                                                onchange="fetchbrand()">
                                                <option value="" selected>Select SubCategory</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">Brand <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="brand" id="brand" required
                                                onchange="get_branch(this.value)">
                                                <option value="" selected>Select Brand</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name"
                                                required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="price" class="form-label">Price <span
                                                    class="text-red">*</span></label>
                                            <input type="number" step="any" class="form-control" name="price"
                                                placeholder="Enter Price" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="veg_nonveg" class="form-label">Veg/Non Veg</label>
                                            <select class="form-control" name="veg_nonveg" id="veg_nonveg">
                                                <option value="" selected>Select</option>
                                                <option value="1">Veg</option>
                                                <option value="2">Non Veg</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="is_fashion" class="form-label">Is Fashion <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_fashion" required id="is_fashion">
                                                <option value="" selected>Select</option>
                                                <option value="0">Offline</option>
                                                <option value="1">Online</option>
                                                <option value="2">Both</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="is_fashion" class="form-label">Cart Cancel Product<span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_cart_cancel_product" required
                                                id="is_cart_cancel_product">
                                                <option value="" selected>Select</option>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile2">Upload Image <span
                                                    class="text-red">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="image" required
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

                                        <div class="form-group col-md-6">
                                            <label for="title" class="form-label">Disclaimer</label>
                                            <textarea class="form-control" name="disclaimer"
                                                placeholder="Enter Disclaimer"></textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="images">Product Images</label>
                                            <input type="file" name="images[]" class="form-control" multiple
                                                accept="image/*">
                                            <small class="text-muted">You can select multiple images.</small>
                                        </div>

                                        <div class="form-group col-md-7">
                                            <label for="color" class="form-label">Size</label>
                                            <select class="form-control" name="size[]" id="size" multiple>
                                                @foreach($size as $val)
                                                <option value="{{ $val->id }}">
                                                    {{ $val->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group col-md-5">
                                            <label for="color" class="form-label">Color</label>
                                            <select class="form-control" name="color[]" id="color" multiple>
                                                @foreach($color as $vals)
                                                <option value="{{ $vals->id }}">
                                                    {{ $vals->color_code }} ({{ $vals->name }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group col-md-2 d-flex align-items-end">
                                            <button type="button" id="addVariantBtn" class="btn btn-success w-100">
                                                + Add Price
                                            </button>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Size & Color Price List</label>
                                            <div id="variantList"></div>
                                        </div>


                                        <!-- Submit Button -->

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="offer_type" class="form-label">Offer Type</label>
                                            <select class="form-control" name="offer_type" id="offer_type">
                                                <option value="" selected>Select Offer Type</option>
                                                @foreach($ot as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>



                                        <div class="form-group col-md-4">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Enter Title">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="title" class="form-label">Description</label>
                                            <textarea class="form-control" id="offerdescription" name="offerdescription"
                                                placeholder="Enter Description"></textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="discount_type" class="form-label">Discount Type</label>
                                            <select class="form-control" name="discount_type" id="discount_type">
                                                <option value="" selected>Select Discount Type</option>
                                                <option value="percentage">Percentage</option>
                                                <option value="fixed">Fixed</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="discount_value" class="form-label">Discount Value </label>
                                            <input type="number" step="any" class="form-control" name="discount_value"
                                                placeholder="Enter Discount Value">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="date" class="form-control" name="start_date"
                                                placeholder="Enter Start Date">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="date" class="form-control" name="end_date"
                                                placeholder="Enter End Date">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="branch" class="form-label">Branch </label>
                                            <select class="form-control" name="branch[]" id="branch" multiple>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-spinner fa-spin d-none"></i>Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

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
        $('#brand').select2({
        allowClear: true
        });
        $('#color').select2({
        allowClear: true
        });
        $('#size').select2({
        allowClear: true
        });
        $('#branch').select2({
        placeholder: "Select Branch",
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
        url: '{{route("admin.new_product_insert")}}',
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
</script>

<script>
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
                fetchbrand();
            } else {
                $('#subcategory_id').empty().append('<option value="">No SubCategories Found</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}


function fetchbrand() {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    var cat = $("#category_id").val();
    var subcat = $("#subcategory_id").val();

    $.ajax({
        url: "{{ route('admin.get_brand') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            category_id: cat,
            subcategory_id: subcat
        },
        success: function(response) {
            if (response.status === 'success') {
                $('#brand').empty();
                $('#brand').append('<option value="">Select Brand</option>');
                $.each(response.data, function(index, subcat) {
                    $('#brand').append(
                        `<option value="${subcat.id}">${subcat.name}</option>`
                    );
                });
            } else {
                $('#brand').empty().append('<option value="">No Brand Found</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}


</script>

<script>
    $(document).ready(function () {
    let variantIndex = 0;

    $('#addVariantBtn').on('click', function () {
       
        let selectedSizes = $('#size').val() || [];
        let selectedColors = $('#color').val() || [];

        if (selectedSizes.length === 0 || selectedColors.length === 0) {
            alert('Please select both Size and Color before adding.');
            return;
        }

        variantIndex++;
        hasRow = true;

        // Create dropdown options using only selected values
        let sizeOptions = '';
        selectedSizes.forEach(sizeId => {
            let text = $('#size option[value="' + sizeId + '"]').text();
            sizeOptions += `<option value="${sizeId}">${text}</option>`;
        });

        let colorOptions = '';
        selectedColors.forEach(colorId => {
            let text = $('#color option[value="' + colorId + '"]').text();
            colorOptions += `<option value="${colorId}">${text}</option>`;
        });

        // Append one row only
        let row = `
            <div class="row align-items-end mb-2" id="variant_${variantIndex}">
                <div class="col-md-3">
                    <select class="form-control" name="variant[${variantIndex}][size_id]" required>
                        ${sizeOptions}
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="variant[${variantIndex}][color_id]" required>
                        ${colorOptions}
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" step="any" class="form-control" name="variant[${variantIndex}][price]" placeholder="Enter Price" required>
                </div>
                <div class="col-md-1 text-right">
                    <button type="button" class="btn btn-danger btn-sm removeVariant" data-id="${variantIndex}">X</button>
                </div>
            </div>
        `;

        $('#variantList').append(row); // replace any previous row
    });

    // Remove row
    $(document).on('click', '.removeVariant', function () {
        let id = $(this).data('id');
        $(`#variant_${id}`).remove();
    });
});


function get_branch(id) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "{{ route('admin.get_branch_using_brand') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            id: id,
        },
        success: function(response) {
            if (response.status === 'success') {
                $('#branch').empty();
                $('#branch').append('<option value="">Select Branch</option>');
                $.each(response.data, function(index, subcat) {
                    $('#branch').append(
                        `<option value="${subcat.id}">${subcat.address}, ${subcat.city}, ${subcat.state}</option>`
                    );
                });
            } else {
                $('#branch').empty().append('<option value="">No Branch Found</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
</script>

@endsection