@extends('admin.layouts.app')

@section('title', 'Permission')

<style>
#permission-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    /* space between checkboxes */
}

#permission-list label {
    display: flex;
    align-items: center;
    gap: 5px;
    min-width: 150px;
    /* control width of each item */
}
</style>

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Permission</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Permission</li>
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
                                <h3 class="card-title">Add Permission</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="PermissionForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="title" class="form-label">Organizer <span
                                                class="text-red">*</span></label>
                                        <select class="form-control" id="organizer" name="organizer"
                                            placeholder="Enter Organizer" required>
                                            <option value="">Select Organizer</option>
                                            @foreach($udata as $val)
                                            <option value="{{$val->id}}">{{$val->first_name .' '.$val->last_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="form-label">Permission <span
                                                class="text-red">*</span></label>
                                        <div id="permission-list">
                                            <label><input type="checkbox" class="permissions" name="permissions[]"
                                                    value="match">
                                                Match</label><br>

                                            <label><input type="checkbox" class="permissions" name="permissions[]"
                                                    value="tournament">
                                                Tournament</label><br>
                                        </div>
                                    </div>



                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->


                    </div>

                </div>
            </div>
    </div>
</section>
</div>
</section>
@endsection

@section('scripts')
<script>
$('#PermissionForm').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission
    var formData = new FormData(this);
    $("#email-error").html('');

    // Send the AJAX request
    $.ajax({
        url: '{{route("admin.add_permission")}}',
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
                window.location.reload();
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

<script>
$('#organizer').on('change', function() {
    var id = $(this).val();

    _data = {};
    _data['id'] = id;
    $('input.permissions[type="checkbox"]').prop('checked', false);

    if (id) {
        $.ajax({
            url: '{{route("admin.get_permission")}}',
            method: 'POST',
            data: _data,
            success: function(response) {
                response.permissions.forEach(function(perm) {
                    $('input.permissions[value="' + perm + '"]').prop('checked', true);
                });
            },
            error: function() {
                alert('Failed to fetch permissions.');
            }
        });
    }
});
</script>
@endsection