@extends('admin.layouts.app')

@section('title', 'Edit Event')

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
                        <h1 class="m-0">Edit Event</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Event</li>
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
                                <input type="hidden" class="form-control" name="id" value="{{ $event->id }}">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label for="page" class="form-label">Category <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="category_id" id="category_id" required>
                                                <option value="" selected>Select Category</option>
                                                @foreach($category as $val)
                                                <option value="{{$val->id}}" {{ $val->id == $event->category_id ?
                                                    'selected' : '' }}>{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="title" class="form-label">Title <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Enter Title" required value="{{$event->title}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="title" class="form-label">Address <span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control" name="address" placeholder="Enter Address"
                                                required>{{$event->address}}</textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="start_date" class="form-label">Start Date <span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control" name="start_date"
                                                placeholder="Enter Start Date" required value="{{$event->start_date}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="end_date" class="form-label">End Date <span
                                                    class="text-red">*</span></label>
                                            <input type="date" class="form-control" name="end_date"
                                                placeholder="Enter End Date" required value="{{$event->end_date}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="time" class="form-label">Time<span
                                                    class="text-red">*</span></label>
                                            <input type="time" class="form-control" name="time" placeholder="Enter Time"
                                                required value={{ \Carbon\Carbon::createFromFormat('h:i A', $event->time
                                            )->format('H:i') }}>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile2">Organizer Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="organizer_image"
                                                        id="exampleInputFile2">
                                                    <label class="custom-file-label" for="exampleInputFile2">Choose
                                                        file</label>
                                                </div>
                                            </div><br>
                                            <img src="{{ asset('uploads/event/' . ($event->organizer_image ?? 'logo.png')) }}"
                                                style="width:50px">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="organizer_name" class="form-label">Organizer Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="organizer_name"
                                                placeholder="Enter Organizer Name" required
                                                value="{{$event->organizer_name}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="contact_no" class="form-label">Contact No <span
                                                    class="text-red">*</span></label>
                                            <input type="number" class="form-control" name="contact_no"
                                                placeholder="Enter Organizer Contact No" required
                                                value="{{$event->contact_no}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile1">Pass PDF</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="pass_pdf"
                                                        id="exampleInputFile1">
                                                    <label class="custom-file-label" for="exampleInputFile1">Choose
                                                        file</label>
                                                </div>
                                            </div><br>
                                            <a href="{{ asset('uploads/event/' . ($event->pass_pdf )) }}">
                                                {{$event->pass_pdf}}</a>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="latitude" class="form-label">Latitude<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="latitude"
                                                placeholder="Enter Latitude" required value="{{$event->latitude}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="longitude" class="form-label">Longitude<span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="longitude"
                                                placeholder="Enter Longitude" required value="{{$event->longitude}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile3">Event Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="event_image"
                                                        id="exampleInputFile3">
                                                    <label class="custom-file-label" for="exampleInputFile3">Choose
                                                        Image
                                                        file</label>
                                                </div>
                                            </div><br>
                                            <img src="{{ asset('uploads/event/' . ($event->event_image ?? 'logo.png')) }}"
                                                style="width:50px">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="title" class="form-label">Description <span
                                                    class="text-red">*</span></label>
                                            <textarea class="form-control" id="description" name="description"
                                                placeholder="Enter Description"
                                                required>{{$event->description}}</textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <button type="button" class="btn btn-primary btn-sm" id="addCelebrityBtn">
                                                <i class="fas fa-plus"></i> Add Celebrity
                                            </button>
                                        </div>

                                        <br>

                                        <div class="col-md-12 mt-4">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover mb-0 align-middle">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Name</th>
                                                            <th>Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($celebrities as $key => $celebrity)
                                                        <tr id="remove_cel_{{$celebrity->id}}">
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>
                                                                {{ $celebrity->name }}
                                                            </td>
                                                            <td>
                                                                <img src="{{ asset('uploads/event/' . $celebrity->image) }}"
                                                                    class="img-thumbnail" width="50" height="30"
                                                                    alt="Celebrity Image">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="deletecelebrity({{$celebrity->id}})">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted">No
                                                                celebrities added yet.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- ✅ Celebrities Section --}}
                                        <div class="row" id="celebrityContainer">

                                        </div>




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
        $('#category_id').select2({
        allowClear: true
        });
    });
</script>


<script>
    $(function() {
    bsCustomFileInput.init();

$('#addCelebrityBtn').on('click', function() {
let html = `<div class="celebrity-row mt-2">
    <div class="form-group col-md-4">
        <label for="cname" class="form-label">Name<span class="text-red">*</span></label>
        <input type="text" class="form-control" name="celebrities[name][]" placeholder="Enter Celebrity Name" required>
    </div>

    <div class="form-group col-md-4">
        <label for="cname" class="form-label">Image<span class="text-red">*</span></label>
        <input type="file" class="form-control" name="celebrities[image][]" required>
    </div>
    <div class="form-group col-md-4">
        <button type="button" class="btn btn-danger btn-sm removeRow" style="margin-top: 35px !important;"><i
                class="fas fa-trash"></i></button>
    </div>
</div>`;
$('#celebrityContainer').append(html);
});

// ✅ Remove celebrity row
$(document).on('click', '.removeRow', function() {
$(this).closest('.celebrity-row').remove();
});


});

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
        url: '{{route("admin.update_event")}}',
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
            }else {
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


function deletecelebrity(id){
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
                url: "{{ route('admin.celebrity_delete') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                },
                success: function(response) {
                    if (response.status == 'success') {
                       $("#remove_cel_"+id).hide();
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