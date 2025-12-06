@extends('admin.layouts.app')

@section('title', 'Fashion Category')

@section('styles')
<style>
    .status-img {
        width: 30px;
        height: 30px;
        object-fit: cover;
        border-radius: 50px;
        display: block;
        margin: 0 auto;
    }

    .ui-state-highlight {
        background: #f0f0f0;
        height: 45px;
        border: 1px dashed #ccc;
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
                        <h1 class="m-0">Fashion Category</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Fashion Category</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Icon</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $('#example1').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('admin.fashion_category_list') }}",
        type: "GET"
    },
    columns: [
        { data: "no" },
        { data: "name" },
        { data: "icon" },
        { data: "status" },
        { data: "action" }
    ],
    createdRow: function(row, data, dataIndex) {
        $(row).attr('data-id', data.id); // Make sure your server sends 'id'
    },
    drawCallback: function(settings) {
        makeRowsSortable();
    },
    ordering: false // Disable ordering if you want to manage rank manually
});


function makeRowsSortable() {
    $("#example1 tbody").sortable({
        cursor: 'move',
        placeholder: "ui-state-highlight",
        update: function(event, ui) {
            let order = [];
            $("#example1 tbody tr").each(function(index) {
                let id = $(this).data('id');
                if (id) {
                    order.push({ id: id, rank: index + 1 });
                }
            });

            // Send updated order to backend
            $.ajax({
                url: "{{ route('admin.fashion_category_reorder') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order: order
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Category order has been updated.',
                            timer: 1000,
                            showConfirmButton: false
                        });
                        $('#example1').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to update order.'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong.'
                    });
                }
            });
        }
    });
}

function changestatus(id) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ route('admin.fashion_category_status_change') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            id: id,
        },
        success: function(response) {
            if (response.status == 'success') {
                $('#example1').DataTable().ajax.reload();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
        }
    });
}

function deleteuser(id) {

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
                url: "{{ route('admin.fashion_category_delete') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#example1').DataTable().ajax.reload();
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