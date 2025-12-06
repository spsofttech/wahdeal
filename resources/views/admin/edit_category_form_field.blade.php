@extends('admin.layouts.app')

@section('title', 'Update Form Field')

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
        <h4>Update Category Form Fields</h4>
    </div>

    <div class="card-body">

        <form id="registerForm" method="post">
            @csrf
            <input type="hidden" name="category_id" value="{{$editcategoryformfield[0]->category_id}}">

            <div class="form-group mb-3">
                <label>Select Category <span class="text-red">*</span></label>
                <select class="form-control" disabled>
                    <option value="">Select</option>
                    @foreach($category as $cat)
                    <option value="{{ $cat->id }}" @if($editcategoryformfield[0]->category_id == $cat->id) selected
                        @endif>{{
                        $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <hr>

            <div id="fieldRows">

                @foreach($editcategoryformfield as $index => $val)
                <div class="row single-row mb-3">

                    <div class="col-md-2">
                        <label>Label <span class="text-red">*</span></label>
                        <input type="text" class="form-control" required value="{{$val->label}}">
                    </div>

                    <div class="col-md-2">
                        <label>Name <span class="text-red">*</span></label>
                        <input type="text" class="form-control" required value="{{$val->name}}">
                    </div>

                    <div class="col-md-2">
                        <label>Type <span class="text-red">*</span></label>
                        <select class="form-control" required>
                            <option value="text" @if($val->type == 'text') selected @endif>Text</option>
                            <option value="number" @if($val->type == 'number') selected @endif>Number</option>
                            <option value="email" @if($val->type == 'email') selected @endif>Email</option>
                            <option value="date" @if($val->type == 'date') selected @endif>Date</option>
                            <option value="time" @if($val->type == 'time') selected @endif>Time</option>
                            <option value="select" @if($val->type == 'select') selected @endif>Select</option>
                            <option value="upload" @if($val->type == 'upload') selected @endif>Upload</option>
                            <option value="daterange" @if($val->type == 'daterange') selected @endif>Daterange</option>
                            <option value="textarea" @if($val->type == 'textarea') selected @endif>Textarea</option>
                            <option value="radio" @if($val->type == 'radio') selected @endif>Radio</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Options (For select)</label>
                        @php
                        $options = json_decode($val->options, true) ?? [];
                        @endphp

                        <select class="form-control options-select" multiple>
                            @foreach($selectoption as $opt)
                            <option value="{{ $opt->name }}" {{ in_array($opt->name, $options) ? 'selected' : '' }}>
                                {{ $opt->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label>Selection</label>
                        <select class="form-control">
                            <option value="">None</option>
                            <option value="single" @if($val->options_selection == 'single') selected @endif>Single
                            </option>
                            <option value="multiple" @if($val->options_selection == 'multiple') selected @endif>Multiple
                            </option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label>Required<span class="text-red">*</span></label>
                        <select class="form-control" required>
                            <option value="1" @if($val->is_required == '1') selected @endif>Yes</option>
                            <option value="0" @if($val->is_required == '0') selected @endif>No</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label>Status</label>
                        <label class="switch"><input type="checkbox" @if($val->status == '1') checked @endif
                            onchange="changestatus({{$val->id}})"><span class="slider"></span></label>
                    </div>


                </div>
                @endforeach

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

        rowIndex++;
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
        url: '{{route("admin.update_category_form_field")}}',
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


function changestatus(id) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ route('admin.category_form_field_status_change') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            id: id,
        },
        success: function(response) {
            
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
        }
    });
}

</script>
@endsection