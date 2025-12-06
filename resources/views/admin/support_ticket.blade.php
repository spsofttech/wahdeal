@extends('admin.layouts.app')

@section('title', 'Support Ticket')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Support Ticket</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Support Ticket</li>
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

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Ticket No</th>
                                            <th>Category</th>
                                            <th>User</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Media</th>
                                            <th>Audio</th>
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
            "url": "{{ route('admin.support_ticket_list') }}", // Your AJAX URL
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
                "data": "ticket_no"
            },
            {
                "data": "category"
            },
            {
                "data": "user"
            },
            {
                "data": "title"
            },
            {
                "data": "description"
            },
            {
                "data": "media"
            },
            {
                "data": "audio"
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
                "targets": 6, // Index of the 'status' column (0-based, so 6 refers to the 7th column)
                "orderable": false // Disable sorting for this column
            },
            {
                "targets": 7, // Index of the 'status' column (0-based, so 6 refers to the 7th column)
                "orderable": false // Disable sorting for this column
            },
            {
                "targets": 8, // Index of the 'status' column (0-based, so 6 refers to the 7th column)
                "orderable": false // Disable sorting for this column
            }
        ]


    });
});
</script>
@endsection