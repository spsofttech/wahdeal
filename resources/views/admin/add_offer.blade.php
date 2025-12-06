@extends('admin.layouts.app')

@section('title', 'Add Offer')


@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Offer</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Offer</li>
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
                                            <label for="offer_type" class="form-label">Offer Type <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="offer_type" id="offer_type" required>
                                                <option value="" selected>Select Offer Type</option>
                                                @foreach($ot as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="product" class="form-label">Product <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="product_id" id="product" required
                                                onchange="get_branch(this.value)">
                                                <option value="" selected>Select Product</option>
                                                @foreach($product as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="title" class="form-label">Title <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Enter Title" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="title" class="form-label">Description <span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control" id="description" name="description"
                                                placeholder="Enter Description" required></textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="discount_type" class="form-label">Discount Type</label>
                                            <select class="form-control" name="discount_type" id="discount_type">
                                                <option value="" selected>Select Discount Type</option>
                                                <option value="percentage">Percentage</option>
                                                <option value="fixed">Fixed</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="discount_value" class="form-label">Discount Value </label>
                                            <input type="number" step="any" class="form-control" name="discount_value"
                                                placeholder="Enter Discount Value">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="start_date" class="form-label">Start Date <span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control" name="start_date"
                                                placeholder="Enter Start Date" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="end_date" class="form-label">End Date <span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control" name="end_date"
                                                placeholder="Enter End Date" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="branch" class="form-label">Branch <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="branch[]" id="branch" required multiple>


                                            </select>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#branch').select2({
        placeholder: "Select Branch",
        allowClear: true
        });

        $('#product').select2({
        allowClear: true
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
        url: '{{route("admin.insert_offer")}}',
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

function get_branch(id) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "{{ route('admin.get_branch_using_product') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            id: id,
        },
        success: function(response) {
            if (response.status === 'success') {
                $('#branch').empty();
                $('#branch').append('<option value="">Select Branch</option>');
                $.each(response.data, function(index, subcat) {
                    $('#branch').append(
                        `<option value="${subcat.id}">${subcat.address}, ${subcat.city}, ${subcat.state}</option>`
                    );
                });
                fetchbrand();
            } else {
                $('#branch').empty().append('<option value="">No Branch Found</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

</script>

@endsection