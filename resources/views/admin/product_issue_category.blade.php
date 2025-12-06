@extends('admin.layouts.app')

@section('title', 'Product Issue Category')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Issue Category</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product Issue Category</li>
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
                            <div class="col-sm-12" style="text-align: right; margin-top:10px;">
                                <a href="{{ route('admin.add_product_issue_category') }}"><button
                                        class="btn btn-primary right-align">Add
                                    </button></a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Title</th>
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
            "url": "{{ route('admin.product_issue_category_list') }}", // Your AJAX URL
            "type": "GET",
            "data": function(d) {
                d.order_column = d.order[0] ? d.order[0].column : null;
                d.order_dir = d.order[0] ? d.order[0].dir :
                    null; // The sorting direction (asc/desc)
            }
        },
        "columns": [{
                "data": "no"
            },
            {
                "data": "title"
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
                "targets": 2, // Index of the 'status' column (0-based, so 6 refers to the 7th column)
                "orderable": false // Disable sorting for this column
            },
            {
            "targets": 3, // Index of the 'status' column (0-based, so 6 refers to the 7th column)
            "orderable": false // Disable sorting for this column
            }
        ]
    });
});


function changestatus(id) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ route('admin.product_issue_category_status_change') }}",
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
                url: "{{ route('admin.product_issue_category_delete') }}",
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