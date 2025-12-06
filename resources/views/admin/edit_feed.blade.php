@extends('admin.layouts.app')

@section('title', 'Add Feed')

@section('styles')
<style>
.cke_notification_warning {
    display: none !important;
}

.file-upload {
    position: relative;
    display: inline-block;
}

#imageInput {
    display: none;
}

.custom-upload-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    font-family: 'Segoe UI', sans-serif;
    transition: background-color 0.3s ease;
}

.custom-upload-btn:hover {
    background-color: #218838;
}

.preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 20px;
}

.image-wrapper {
    position: relative;
    width: 120px;
    height: 120px;
}

.image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.remove-icon {
    position: absolute;
    top: -8px;
    right: -8px;
    background: red;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 14px;
    line-height: 20px;
    text-align: center;
    cursor: pointer;
    font-weight: bold;
    z-index: 10;
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
                        <h1 class="m-0">Feed</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Feed</li>
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
                                <h3 class="card-title">Add Feed</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="registerForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" class="form-control" name="id" value="{{ $feed->id }}">

                                    <div class="form-group">
                                        <div class="file-upload">
                                            <label for="imageInput" class="custom-upload-btn">Select Images</label>
                                            <input type="file" id="imageInput" name="image[]" multiple
                                                accept="image/*" />
                                        </div>

                                        <div class="preview-container" id="previewContainer">

                                            @foreach($feed_images as $val)
                                            <div class="image-wrapper" id="feed_image_{{$val->id}}">
                                                <span class="remove-icon" onclick="removeimage('{{$val->id}}')">×</span>
                                                <img src="{{ asset('uploads/feed/' . ($val->image ?? 'logo.png')) }}"
                                                    style="width:120px">
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="buttontext" class="form-label">Button Text <span
                                                class="text-red">*</span></label>
                                        <input type="text" class="form-control" id="buttontext" name="buttontext"
                                            placeholder="Enter Button Text" value="{{ $feed->button_text }}" required>
                                    </div>


                                    <div class="form-group">
                                        <label for="title" class="form-label">Title Text <span
                                                class="text-red">*</span></label>
                                        <textarea class="form-control" id="description" name="description"
                                            placeholder="Enter Title Text" required>{{ $feed->description }}</textarea>
                                    </div>


                                </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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



<script>
$(function() {
    bsCustomFileInput.init();
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

    // Send the AJAX request
    $.ajax({
        url: '{{route("admin.update_feed")}}',
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
                window.location.href = response.redirect;
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
const imageInput = document.getElementById('imageInput');
const previewContainer = document.getElementById('previewContainer');
let dt = new DataTransfer(); // For managing the actual file list

imageInput.addEventListener('change', function() {
    for (const file of this.files) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = 'image-wrapper';

            const img = document.createElement('img');
            img.src = e.target.result;

            const removeBtn = document.createElement('span');
            removeBtn.className = 'remove-icon';
            removeBtn.textContent = '×';

            // Store the file name so we can identify it later
            wrapper.dataset.filename = file.name;

            removeBtn.onclick = function() {
                // Remove from DataTransfer
                for (let i = 0; i < dt.items.length; i++) {
                    if (dt.items[i].getAsFile().name === file.name) {
                        dt.items.remove(i);
                        break;
                    }
                }

                // Update input files and remove the preview
                imageInput.files = dt.files;
                wrapper.remove();
            };

            wrapper.appendChild(removeBtn);
            wrapper.appendChild(img);
            previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);

        // Add to DataTransfer
        dt.items.add(file);
    }

    // Update input files with managed list
    this.files = dt.files;
});
</script>

<script>
function removeimage(id) {
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
                url: "{{ route('admin.feed_image_delete') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    id: id,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#feed_image_' + id).remove();
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