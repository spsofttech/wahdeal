@extends('admin.layouts.app')

@section('title', 'Add Form Field')

@section('styles')
<style>
    .cke_notification_warning {
        display: none !important;
    }
</style>
@endsection


@section('content')

<div class="card">
    <div class="card-header">
        <h4>Add Category Form Fields</h4>
    </div>

    <div class="card-body">
        <div
            style="background:#e7f3ff; padding:10px 15px; border-left:4px solid #2196F3; border-radius:4px; margin-bottom:15px;">
            <strong>Info:</strong> The following default fields will be created automatically:
            User Full Name, Phone Number, Email, Gender.
        </div>

        <form id="registerForm" method="post">
            @csrf

            <div class="form-group mb-3">
                <label>Select Category <span class="text-red">*</span></label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select</option>
                    @foreach($category as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <hr>

            <div id="fieldRows">

                <!-- ---------- ONE FIELD ROW ------------- -->
                <div class="row single-row mb-3">

                    <div class="col-md-2">
                        <label>Label <span class="text-red">*</span></label>
                        <input type="text" name="label[]" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label>Name <span class="text-red">*</span></label>
                        <input type="text" name="name[]" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label>Type <span class="text-red">*</span></label>
                        <select name="type[]" class="form-control" required>
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="date">Date</option>
                            <option value="time">Time</option>
                            <option value="select">Select</option>
                            <option value="upload">Upload</option>
                            <option value="daterange">Daterange</option>
                            <option value="textarea">Textarea</option>
                            <option value="radio">Radio</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Options (For select)</label>
                        <select name="options[0][]" class="form-control options-select" multiple>
                            <option value="">Select Option</option>
                            @foreach($selectoption as $opt)
                            <option value="{{ $opt->name }}">{{ $opt->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label>Selection</label>
                        <select name="options_selection[]" class="form-control">
                            <option value="">None</option>
                            <option value="single">Single</option>
                            <option value="multiple">Multiple</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label>Required<span class="text-red">*</span></label>
                        <select name="is_required[]" class="form-control" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>


                </div>
                <!-- ---------- END FIELD ROW ------------- -->

            </div>

            <button type="button" id="addMore" class="btn btn-primary">+ Add More Field</button>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary"><i
                        class="fa fa-spinner fa-spin d-none"></i>Submit</button>
            </div>

        </form>

    </div>
</div>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.options-select').select2({
        allowClear: true,
        });

    });
</script>

<script>
    $(document).ready(function(){

    let rowIndex = 0;

    // Add more field rows
    $('#addMore').click(function() {
        rowIndex++;
        let newRow = `
        <div class="row single-row mb-3">

            <div class="col-md-2">
                <input type="text" name="label[]" class="form-control" placeholder="Label" required>
            </div>

            <div class="col-md-2">
                <input type="text" name="name[]" class="form-control" placeholder="Name" required>
            </div>

            <div class="col-md-2">
                <select name="type[]" class="form-control" required>
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="email">Email</option>
                    <option value="date">Date</option>
                    <option value="time">Time</option>
                    <option value="select">Select</option>
                    <option value="upload">Upload</option>
                    <option value="daterange">Daterange</option>
                    <option value="textarea">Textarea</option>
                    <option value="radio">Radio</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="options[`+rowIndex+`][]"
                        class="form-control options-select"
                        multiple>
                    @foreach($selectoption as $opt)
                        <option value="{{ $opt->name }}">{{ $opt->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-1">
                <select name="options_selection[]" class="form-control">
                    <option value="">None</option>
                    <option value="single">Single</option>
                    <option value="multiple">Multiple</option>
                </select>
            </div>

            <div class="col-md-1">
                <select name="is_required[]" class="form-control" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="col-md-1">
                <button type="button" class="btn btn-danger remove-row">X</button>
            </div>

        </div>
        `;

        $('#fieldRows').append(newRow);

        $('.options-select').select2({
        allowClear: true
        });


    });


    // Remove Row
    $(document).on('click','.remove-row',function(){
        $(this).closest('.single-row').remove();
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
        url: '{{route("admin.insert_category_form_field")}}',
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
</script>
@endsection