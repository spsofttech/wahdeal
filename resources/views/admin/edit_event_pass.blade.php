@extends('admin.layouts.app')

@section('title', 'Edit Event Pass')

@section('styles')
<style>
    .cke_notification_warning {
        display: none !important;
    }

    .celebrity-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        margin-left: 20px !important;
    }

    .celebrity-row img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
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
                        <h1 class="m-0">Edit Event Pass</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Event Pass</li>
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
                                <input type="hidden" class="form-control" name="id" value="{{ $id }}">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <label for="page" class="form-label">Event <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="event_id" id="event_id" required
                                                disabled>
                                                <option value="" selected>Select Event</option>
                                                @foreach($event as $val)
                                                <option value="{{$val->id}}" {{ $val->id == $id ?
                                                    'selected' : '' }}>{{$val->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <button type="button" class="btn btn-primary btn-sm" id="addPass">
                                                <i class="fas fa-plus"></i> Add Pass
                                            </button>
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover mb-0 align-middle">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="15%">Day</th>
                                                            <th width="20%">Start Date</th>
                                                            <th width="15%">Time</th>
                                                            <th width="15%">Price</th>
                                                            <th width="10%" class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($passes as $key => $pass)
                                                        <tr id="remove_pass_{{ $pass->id }}">
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $pass->day }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($pass->start_date)->format('d
                                                                M, Y') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($pass->time)->format('h:i A')
                                                                }}</td>
                                                            <td>₹{{ number_format($pass->price, 2) }}</td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="deletepass({{ $pass->id }})">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">
                                                                No passes added yet.
                                                            </td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div id="passesContainer"></div>


                                        <!-- Submit Button -->
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
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

<script src="{{asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#event_id').select2({
        allowClear: true
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Add new pass row
        $('#addPass').on('click', function() {
            let passRow = `
            <div class="row align-items-end pass-row mb-3 border-bottom pb-2 mt-3" style="margin-left: 10px !important;">
                <div class="form-group col-md-3">
                    <label class="form-label">Day<span class="text-red">*</span></label>
                    <input type="text" name="passes[day][]" class="form-control" placeholder="Day 1" required>
                </div>

                <div class="form-group col-md-3">
                    <label class="form-label">Start Date<span class="text-red">*</span></label>
                    <input type="date" name="passes[start_date][]" class="form-control" required>
                </div>

                <div class="form-group col-md-3">
                    <label class="form-label">Time<span class="text-red">*</span></label>
                    <input type="time" name="passes[time][]" class="form-control" required>
                </div>

                <div class="form-group col-md-2">
                    <label class="form-label">Price<span class="text-red">*</span></label>
                    <input type="number" name="passes[price][]" class="form-control" required step="any">
                </div>

                <div class="form-group col-md-1 text-center">
                    <button type="button" class="btn btn-danger btn-sm removePass mt-4">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>`;
            $('#passesContainer').append(passRow);
        });

        // Remove pass row
        $(document).on('click', '.removePass', function() {
            $(this).closest('.pass-row').remove();
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Initialize CKEditor
    CKEDITOR.replace('description');

    // Ensure CKEditor updates the textarea before submitting
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            Object.keys(CKEDITOR.instances).forEach(instance => {
                CKEDITOR.instances[instance].updateElement();
            });

            // Debug: Check if CKEditor values are being updated
            console.log("Disclaimer:", document.getElementById('description').value);
        });
    });
});
</script>

<script>
    $('#registerForm').submit(function(e) {
    e.preventDefault();

    for (var instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }

    var formData = new FormData(this);
   $(".fa-spinner").removeClass("d-none");
    $.ajax({
        url: '{{route("admin.update_event_pass")}}',
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
            }else{
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

function deletepass(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "This pass will be permanently deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('admin.delete_event_pass') }}", // create this route
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    if (response.status == "success") {
                        $("#remove_pass_" + id).fadeOut(500, function() {
                            $(this).remove();
                        });
                        Swal.fire("Deleted!", response.message, "success");
                    } else {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    }
                }
            });
        }
    });
}
</script>

@endsection