@extends('admin.layouts.app')

@section('title', 'Add Banner')

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
                        <h1 class="m-0">Add Banner</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Banner</li>
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
                                            <label for="brand" class="form-label">Brand</label>
                                            <select class="form-control" name="brand" id="brand">
                                                <option value="" selected>Select Brand</option>
                                                @foreach($brand as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="product" class="form-label">Product</label>
                                            <select class="form-control" name="product" id="product">
                                                <option value="" selected>Select Product</option>
                                                @foreach($product as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="own" class="form-label">Own Banner <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="own" id="own" required>
                                                <option value="" selected>Select</option>
                                                <option value="1">Own</option>
                                                <option value="0">Not Own</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="ltype" class="form-label">Launch Type <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="ltype" id="ltype" required>
                                                <option value="" selected>Select Launch Type</option>
                                                <option value="brand">Brand</option>
                                                <option value="website">Website</option>
                                                <option value="product">Product</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="btype" class="form-label">Banner Type <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="btype" id="btype" required>
                                                <option value="" selected>Select Banner Type</option>
                                                <option value="square">Square</option>
                                                <option value="marketing">Marketing</option>
                                                <option value="poster">Poster</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile">Upload Image <span
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
                                            <label for="website" class="form-label">Website</label>
                                            <input type="text" class="form-control" name="website"
                                                placeholder="Enter Website">
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
<script src="{{asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
    $(function() {
    bsCustomFileInput.init();
    });
</script>

<script>
    $('#registerForm').submit(function(e) {
    
    var brand = $("#brand").val();
    var product = $("#product").val();
    var ltype = $("#ltype").val();

    if(brand == '' && product == ''){
         Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'please select at list brand or product',
                    showConfirmButton: false,
                    toast: true,
                    timer: 5000
                });
        return false;
    }

    if(ltype == 'brand' && brand == ''){
        Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'please select brand',
                    showConfirmButton: false,
                    toast: true,
                    timer: 5000
        });
        return false;
    }

     if(ltype == 'product' && product == ''){
        Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'please select product',
                    showConfirmButton: false,
                    toast: true,
                    timer: 5000
        });
        return false;
    }


    e.preventDefault();
    var formData = new FormData(this);
    $(".fa-spinner").removeClass("d-none");
    $.ajax({
        url: '{{route("admin.insert_banner")}}',
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
            }else {
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