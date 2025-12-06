@extends('brand.layouts.app')

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
                            <li class="breadcrumb-item"><a href="{{ route('brand.dashboard') }}">Home</a></li>
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
                                <input type="hidden" class="form-control" name="id" value="{{ $id }}">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">Category <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="category_id" id="category_id" required>
                                                <option value="" selected>Select Category</option>
                                                @foreach($category as $val)
                                                <option value="{{$val->id}}" @if($editproduct['category_id']==$val->id)
                                                    selected
                                                    @endif>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">SubCategory</label>
                                            <select class="form-control" name="subcategory_id" id="subcategory_id">
                                                <option value="" selected>Select SubCategory</option>
                                                @foreach($subcategories as $subval)
                                                <option value="{{$subval->id}}"
                                                    @if($editproduct['subcategory_id']==$subval->id)
                                                    selected
                                                    @endif>{{$subval->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">Brand <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="brand" id="brand" required>
                                                <option value="" selected>Select Brand</option>
                                                @foreach($brand as $bval)
                                                <option value="{{$bval->id}}" @if($editproduct['brand_id']==$bval->id)
                                                    selected
                                                    @endif>{{$bval->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name"
                                                required value="{{$editproduct['name']}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="price" class="form-label">Price <span
                                                    class="text-red">*</span></label>
                                            <input type="number" step="any" class="form-control" name="price"
                                                placeholder="Enter Price" required value="{{$editproduct['price']}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="veg_nonveg" class="form-label">Veg/Non Veg</label>
                                            <select class="form-control" name="veg_nonveg" id="veg_nonveg">
                                                <option value="" selected>Select</option>
                                                <option value="1" @if($editproduct['veg_nonveg']=='1' ) selected @endif>
                                                    Veg</option>
                                                <option value="2" @if($editproduct['veg_nonveg']=='2' ) selected @endif>
                                                    Non Veg</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="is_fashion" class="form-label">Is Fashion <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_fashion" required id="is_fashion">
                                                <option value="" selected>Select</option>
                                                <option value="0" @if($editproduct['is_fashion']=='0' ) selected @endif>
                                                    Offline</option>
                                                <option value="1" @if($editproduct['is_fashion']=='1' ) selected @endif>
                                                    Online</option>
                                                <option value="2" @if($editproduct['is_fashion']=='2' ) selected @endif>
                                                    Both</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="is_fashion" class="form-label">Cart Cancel Product<span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="is_cart_cancel_product" required
                                                id="is_cart_cancel_product">
                                                <option value="" selected>Select</option>
                                                <option value="0" @if($editproduct['is_cart_cancel_product']=='0' )
                                                    selected @endif>No</option>
                                                <option value="1" @if($editproduct['is_cart_cancel_product']=='1' )
                                                    selected @endif>Yes</option>
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
                                            <img src="{{ asset('uploads/product/' . ($editproduct['image'] ?? 'logo.png')) }}"
                                                style="width:50px">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="title" class="form-label">Description <span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control" id="description" name="description"
                                                placeholder="Enter Description" required>{{$editabout}}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="title" class="form-label">Disclaimer</label>
                                            <textarea class="form-control" name="disclaimer"
                                                placeholder="Enter Disclaimer">{{$editproduct['disclaimer']}}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="images">Product Images</label>
                                            <input type="file" name="images[]" class="form-control" multiple
                                                accept="image/*">
                                            <small class="text-muted">You can select multiple images.</small>
                                        </div>

                                        @if(isset($editproductimages['images']))

                                        @foreach($editproductimages['images'] as $key => $pimage)
                                        <div class="col-md-3 text-center" id="remove_menu_{{ $key }}">
                                            <input type="hidden" name="old_product_images[]" value="{{ $pimage }}">
                                            <img src="{{ asset('uploads/product/'.$pimage) }}"
                                                class="img-thumbnail mb-2" style="width:100px;height:100px;"><br>
                                            <button type="button" class="btn btn-danger btn-sm deleteMenu"
                                                onclick="deletemenu('{{ $key }}')">Delete</button>
                                        </div>
                                        @endforeach

                                        @endif



                                        <!-- Submit Button -->

                                    </div>

                                    <div class="row">
                                        @php
                                        $selectedSizes = isset($editsizes['size'])
                                        ? collect($editsizes['size'])->pluck('size_id')->toArray()
                                        : [];
                                        @endphp
                                        <div class="form-group col-md-7 mt-5">
                                            <label for="color" class="form-label">Size</label>
                                            <select class="form-control" name="size[]" id="size" multiple>
                                                @foreach($size as $val)
                                                <option value="{{ $val->id }}" {{ in_array($val->id, $selectedSizes) ?
                                                    'selected' : '' }}>
                                                    {{ $val->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        @php
                                        $selectedColors = collect($editcolors['colors'])->pluck('color_id') ->toArray();
                                        @endphp
                                        <div class="form-group col-md-5 mt-5">
                                            <label for="color" class="form-label">Color</label>
                                            <select class="form-control" name="color[]" id="color" multiple>
                                                @foreach($color as $vals)
                                                <option value="{{ $vals->id }}" {{ in_array($vals->id, $selectedColors)
                                                    ? 'selected' : '' }}>
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
                                        </div>
                                    </div>

                                    @foreach ($sizecolorresult as $index => $variant)
                                    <div class="row mt-3" id="remove_size_color_price_{{$index}}">

                                        <input type="hidden" name="oldvariant[{{$index}}][size_id]"
                                            value="{{$variant['size_id']}}">
                                        <input type="hidden" name="oldvariant[{{$index}}][color_id]"
                                            value="{{$variant['color_id']}}">
                                        <input type="hidden" name="oldvariant[{{$index}}][price]"
                                            value="{{$variant['price']}}">
                                        <div class="form-group col-md-3">
                                            <label>Size:</label>
                                            {{$variant['size']}}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Color:</label>
                                            {{$variant['color']}}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Price:</label>
                                            {{$variant['price']}}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deletesizecolorprice('{{ $index }}')">X</button>
                                        </div>

                                    </div>
                                    @endforeach

                                    <div class="form-group col-md-12">
                                        <div id="variantList"></div>
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
        url: '{{route("brand.update_product")}}',
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
            $("#remove_menu_" + id).remove();
        }
    });
}

function deletesizecolorprice(id) {
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
            $("#remove_size_color_price_" + id).remove();
        }
    });
}
</script>

@endsection