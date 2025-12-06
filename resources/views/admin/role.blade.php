@extends('admin.layouts.app')

@section('title', 'Add Role')



@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Role</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Role</li>
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
                                        <div class="form-group col-md-12">
                                            <label for="page" class="form-label">Branch</label>
                                            <select class="form-control" id="branch" name="branch"
                                                onchange="changebranch(this.value)" required>
                                                <option value="">Select Branch</option>
                                                @foreach($branch as $val)
                                                <option value="{{$val->id}}">{{$val->email}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="productchk"
                                                    name="role[]" value="product">
                                                <label class="form-check-label" for="product">Product</label>
                                            </div>
                                        </div>

                                        <!-- Branch -->
                                        <div class="col-md-1">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="branchchk"
                                                    name="role[]" value="branch">
                                                <label class="form-check-label" for="branch">Branch</label>
                                            </div>
                                        </div>

                                        <!-- Order -->
                                        <div class="col-md-1">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="orderchk"
                                                    name="role[]" value="order">
                                                <label class="form-check-label" for="order">Order</label>
                                            </div>
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
<script src="{{asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}">
</script>

<script>
    $(function() {
    bsCustomFileInput.init();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#branch').select2({
       placeholder: "Select Branch",
            allowClear: true
        });
    });
</script>

<script>
    function changebranch(id) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "{{ route('admin.get_role_using_branch') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            id: id,
        },
        success: function(response) {
            if (response.status === 'success') {
                $("#productchk").prop("checked", false);
                $("#branchchk").prop("checked", false);

                response.roles.forEach(function(role) {
                    if (role.role == "product") {
                        if(role.status == "1"){
                            $("#productchk").prop("checked", true);
                        }
                        
                    }
                    if (role.role == "branch") {
                        if(role.status == "1"){
                            $("#branchchk").prop("checked", true);
                        }
                       
                    }

                    if (role.role == "order") {
                        if(role.status == "1"){
                        $("#orderchk").prop("checked", true);
                        }
                    
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
</script>

<script>
    $('#registerForm').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission
    var formData = new FormData(this);
    $("#email-error").html('');

   $(".fa-spinner").removeClass("d-none");
    $.ajax({
        url: '{{route("admin.insert_role")}}',
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
                location.reload();
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