@extends('admin.layouts.app')

@section('title', 'Edit Color')

@section('styles')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-minicolors/2.3.6/jquery.minicolors.css">

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Color</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Color</li>
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
                                <input type="hidden" class="form-control" name="id" value="{{ $color->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" id="colorname" name="name"
                                                placeholder="Enter Name" required value="{{$color->name}}">
                                        </div>



                                        <div class="form-group col-md-4">
                                            <label for="colorPicker">Choose Color:</label>

                                            <input type="text" id="colorPicker" name="color_code" required
                                                class="color-input form-control" value="{{$color->color_code}}">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-minicolors/2.3.6/jquery.minicolors.min.js"></script>
<script>
    // Predefined color name map
    function getColorName(hex) {
    const colors = {
    "#000000": "Black",
    "#FFFFFF": "White",
    "#FF0000": "Red",
    "#00FF00": "Lime",
    "#0000FF": "Blue",
    "#FFFF00": "Yellow",
    "#FFA500": "Orange",
    "#800080": "Purple",
    "#FFC0CB": "Pink",
    "#808080": "Gray",
    "#008000": "Green",
    "#A52A2A": "Brown",
    "#00FFFF": "Cyan",
    "#800000": "Maroon",
    "#808000": "Olive",
    "#ADD8E6": "Light Blue",
    "#FF00FF": "Magenta",
    "#C0C0C0": "Silver",
    "#F5F5DC": "Beige"
    };
    
    const upperHex = hex.toUpperCase();
    return colors[upperHex] || "Custom Color";
    }
</script>



<script>
    $(document).ready(function() {
  $('#colorPicker').minicolors({
    control: 'hue',
    format: 'hex',
    theme: 'bootstrap',
    change: function(value) {
      $('#colorCode').val(value);
      const colorName = getColorName(value);
     $('#colorname').val(colorName);
    }
  });
});
</script>

<script>
    $('#registerForm').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission
    var formData = new FormData(this);
    $("#email-error").html('');

   $(".fa-spinner").removeClass("d-none");
    $.ajax({
        url: '{{route("admin.update_color")}}',
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