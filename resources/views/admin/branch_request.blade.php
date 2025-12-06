@extends('admin.layouts.app')

@section('title', 'Branch')

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
                        <h1 class="m-0">Branch</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Branch</li>
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
                                            <th>Brand</th>
                                            <th>Address</th>
                                            <th>Area</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Pincode</th>
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
            "url": "{{ route('admin.branch_request_list') }}", // Your AJAX URL
            "type": "GET",
            "data": function(d) {
                // Add the order data (column index and direction) to the request
                d.order_column = d.order[0] ? d.order[0].column : null; // The column being sorted
                d.order_dir = d.order[0] ? d.order[0].dir :
                    null; // The sorting direction (asc/desc)
            }
        },
        "columns": [
            {
                "data": "no"
            },
            {
                "data": "brand"
            },
            {
                "data": "address"
            },
            {
                "data": "area"
            },
            {
                "data": "state"
            },
            {
                "data": "city"
            },
            {
                "data": "pincode"
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
        "columnDefs": [
            {
                "targets": 1,
                "orderable": false
            },
            {
            "targets": 2,
            "orderable": false
            },
            {
            "targets": 3,
            "orderable": false
            },
            {
            "targets": 4,
            "orderable": false
            },
            {
            "targets": 5,
            "orderable": false
            },
            {
            "targets": 6,
            "orderable": false
            },
            {
            "targets": 7,
            "orderable": false
            },
            {
            "targets": 8,
            "orderable": false
            }
        ]
    });
});



</script>
@endsection