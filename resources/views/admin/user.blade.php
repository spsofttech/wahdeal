@extends('admin.layouts.app')

@section('title', 'User')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
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

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Image</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Wallet Balance</th>
                                            <th>Date</th>
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

<script>
    $(document).ready(function() {
    $('#example1').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('admin.user_list') }}", // Your AJAX URL
            "type": "GET",
            "data": function(d) {
                // Add the order data (column index and direction) to the request
                d.order_column = d.order[0] ? d.order[0].column : null; // The column being sorted
                d.order_dir = d.order[0] ? d.order[0].dir :
                    null; // The sorting direction (asc/desc)
            }
        },
        "columns": [{
                "data": "no"
            },
            {
                "data": "image"
            },
            {
                "data": "first_name"
            },
            {
                "data": "last_name"
            },
            {
                "data": "mobile"
            },
            {
                "data": "email"
            },
            {
                "data": "gender"
            },
            {
                "data": "state"
            },
            {
                "data": "city"
            },
            {
                "data": "wallet_balance"
            },
            {
                "data": "created_at"
            },
            {
                "data": "status"
            },
            {
                "data": "action"
            },
        ],
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "order": [
            [0, 'desc']
        ],
        "columnDefs": [{
                "targets": 1, // Index of the 'status' column (0-based, so 6 refers to the 7th column)
                "orderable": false // Disable sorting for this column
            },
            {
            "targets": 11, // Index of the 'status' column (0-based, so 6 refers to the 7th column)
            "orderable": false // Disable sorting for this column
            },
            {
            "targets": 12, // Index of the 'status' column (0-based, so 6 refers to the 7th column)
            "orderable": false // Disable sorting for this column
            }
        ]
    });
});


function changestatus(id) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ route('admin.user_status_change') }}",
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
                url: "{{ route('admin.user_delete') }}",
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