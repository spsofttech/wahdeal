@extends('admin.layouts.app')

@section('title', 'Edit Product')

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
                        <h1 class="m-0">Edit Product</h1>
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
                                <input type="hidden" class="form-control" name="id" value="{{ $product->id }}">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">Category <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="category_id" id="category_id" required
                                                onchange="get_subcategory(this.value)">
                                                <option value="" selected>Select Category</option>
                                                @foreach($category as $val)
                                                <option value="{{$val->id}}" {{ $product->category_id == $val->id ?
                                                    'selected' : '' }}>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">SubCategory</label>
                                            <select class="form-control" name="subcategory_id" id="subcategory_id"
                                                onchange="fetchbrand()">
                                                <option value="" selected>Select SubCategory</option>
                                                @foreach($subcategory as $val)
                                                <option value="{{$val->id}}" {{ $product->subcategory_id == $val->id ?
                                                    'selected' : '' }}>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">Brand <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="brand" id="brand" required>
                                                <option value="" selected>Select Brand</option>
                                                @foreach($brand as $val)
                                                <option value="{{$val->id}}" {{ $product->brand_id == $val->id ?
                                                    'selected' : '' }}>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name"
                                                required value="{{$product->name}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="price" class="form-label">Price <span
                                                    class="text-red">*</span></label>
                                            <input type="number" step="any" class="form-control" name="price"
                                                placeholder="Enter Price" required value="{{$product->price}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="veg_nonveg" class="form-label">Veg/Non Veg</label>
                                            <select class="form-control" name="veg_nonveg" id="veg_nonveg">
                                                <option value="" selected>Select</option>
                                                <option value="1" @if($product->veg_nonveg == '1') selected @endif>Veg
                                                </option>
                                                <option value="2" @if($product->veg_nonveg == '2') selected @endif>Non
                                                    Veg</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="is_fashion" class="form-label">Is Fashion <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_fashion" required id="is_fashion">
                                                <option value="" selected>Select</option>
                                                <option value="0" @if($product->is_fashion == '0') selected
                                                    @endif>Offline</option>
                                                <option value="1" @if($product->is_fashion == '1') selected
                                                    @endif>Online</option>
                                                <option value="2" @if($product->is_fashion == '2') selected
                                                    @endif>Both</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="is_fashion" class="form-label">Cart Cancel Product<span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_cart_cancel_product" required
                                                id="is_cart_cancel_product">
                                                <option value="" selected>Select</option>
                                                <option value="0" @if($product->is_cart_cancel_product == '0') selected
                                                    @endif>No</option>
                                                <option value="1" @if($product->is_cart_cancel_product == '1') selected
                                                    @endif>Yes</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile2">Upload Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="image"
                                                        id="exampleInputFile2">
                                                    <label class="custom-file-label" for="exampleInputFile2">Choose
                                                        file</label>
                                                </div>
                                            </div><br>
                                            <img src="{{ asset('uploads/product/' . ($product->image ?? 'logo.png')) }}"
                                                style="width:50px">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="title" class="form-label">Description <span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control" id="description" name="description"
                                                placeholder="Enter Description"
                                                required>{{$product->description}}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="title" class="form-label">Disclaimer</label>
                                            <textarea class="form-control" name="disclaimer"
                                                placeholder="Enter Disclaimer">{{$product->disclaimer}}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="images">Product Images</label>
                                            <input type="file" name="images[]" class="form-control" multiple
                                                accept="image/*">
                                            <small class="text-muted">You can select multiple images.</small>
                                        </div>


                                        @if(isset($product_image) && $product_image->count())

                                        @foreach($product_image as $menu)
                                        <div class="col-md-3 text-center" id="remove_image_{{$menu->id}}">
                                            <img src="{{ asset('uploads/product/'.$menu->image) }}"
                                                class="img-thumbnail mb-2" style="width:100px;height:100px;"><br>
                                            <button type="button" class="btn btn-danger btn-sm deleteMenu"
                                                onclick="deletemenu({{ $menu->id }})">Delete</button>
                                        </div>
                                        @endforeach

                                        @endif


                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                <label for="color" class="form-label">Size</label>
                                                <select class="form-control" name="size[]" id="size" multiple>
                                                    @foreach($size as $val)
                                                    <option value="{{ $val->id }}" {{ in_array($val->id, $ps) ?
                                                        'selected' :
                                                        '' }}>
                                                        {{ $val->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label for="color" class="form-label">Color</label>
                                                <select class="form-control" name="color[]" id="color" multiple>
                                                    @foreach($color as $vals)
                                                    <option value="{{ $vals->id }}" {{ in_array($vals->id, $pc) ?
                                                        'selected'
                                                        :
                                                        '' }}>
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
                                                <div id="variantListOld">
                                                    @foreach ($variants as $index => $variant)
                                                    <div class="row align-items-end mb-2"
                                                        id="remove_price_{{ $variant->id }}">
                                                        <div class="col-md-3">
                                                            <select class="form-control"
                                                                name="variant[{{ $index }}][size_id]" required>
                                                                @foreach($size as $s)
                                                                <option value="{{ $s->id }}" {{ $variant->size_id ==
                                                                    $s->id
                                                                    ?
                                                                    'selected' : '' }}>
                                                                    {{ $s->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select class="form-control"
                                                                name="variant[{{ $index }}][color_id]" required>
                                                                @foreach($color as $c)
                                                                <option value="{{ $c->id }}" {{ $variant->color_id ==
                                                                    $c->id
                                                                    ?
                                                                    'selected' : '' }}>
                                                                    {{ $c->name }} ({{ $c->color_code }})
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="number" step="any" class="form-control"
                                                                name="variant[{{ $index }}][price]"
                                                                value="{{ $variant->price }}" required>
                                                        </div>
                                                        <div class="col-md-1 text-right">
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="deleteprice({{ $variant->id }})"
                                                                data-id="{{ $index }}">X</button>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>

                                                <div id="variantList">

                                                </div>
                                            </div>
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
        $('#brand').select2({
        allowClear: true
        });
        $('#color').select2({
        allowClear: true
        });
        $('#size').select2({
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
        url: '{{route("admin.update_product")}}',
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
                url: "{{ route('admin.product_image_delete') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $("#remove_image_" + id).remove();
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

<script>
    $(document).ready(function () {
    let variantIndex = 200;

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
</script>

<script>
    function deleteprice(id) {
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
                url: "{{ route('admin.product_price_delete') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $("#remove_price_" + id).remove();
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