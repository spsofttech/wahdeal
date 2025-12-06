@extends('admin.layouts.app')

@section('title', 'Match')

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
</style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Match</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Match</li>
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
                                            <th>Team 1</th>
                                            <th>Team 2</th>
                                            <th>Name</th>
                                            <th>Match Type</th>
                                            <th>Overs</th>
                                            <th>Bowler Overs</th>
                                            <th>City</th>
                                            <th>Ground</th>
                                            <th>Date Time</th>
                                            <th>Match Status</th>
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
            "url": "{{ route('admin.match_list') }}", // Your AJAX URL
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
                "data": "team1"
            },
            {
                "data": "team2"
            },
            {
                "data": "name"
            },
            {
                "data": "match_type"
            },
            {
                "data": "overs"
            },
            {
                "data": "bowler_overs"
            },
            {
                "data": "city"
            },
            {
                "data": "ground"
            },
            {
                "data": "datetime"
            },
            {
                "data": "match_status"
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
                "targets": 9,
                "orderable": false
            },
            {
                "targets": 10,
                "orderable": false
            },
            {
                "targets": 11,
                "orderable": false
            }
        ]


    });
});
</script>
@endsection