@extends('admin.layouts.app')

@section('title', 'Edit Team')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Team</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Team</li>
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
                                <input type="hidden" class="form-control" name="id" value="{{ $team->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Image -->
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputFile">Image <span class="text-red">*</span></label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" id="exampleInputFile"
                                                        name="image">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <br>
                                            <img src="{{ asset('uploads/team/' . ($team->logo ?? 'logo.png')) }}"
                                                style="width:50px">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="team_name" class="form-label">Team Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="team_name"
                                                value="{{ $team->name }}" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="captain_name" class="form-label">Captain Name <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="captain_name"
                                                value="{{ $team->captain_name }}" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="phone_no" class="form-label">Phone No <span
                                                    class="text-red">*</span></label>
                                            <input type="number" class="form-control" name="phone_no"
                                                value="{{ $team->contact_no }}" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="city" class="form-label">City/Location <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ $team->city }}" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="city" class="form-label">Match/Timing <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="match_timing">
                                                <option value="">Select Match/Timing</option>
                                                <option value="Day"
                                                    {{ (isset($team->match_timing) && $team->match_timing == 'Day') ? 'selected' : '' }}>
                                                    Day</option>
                                                <option value="Night"
                                                    {{ (isset($team->match_timing) && $team->match_timing == 'Night') ? 'selected' : '' }}>
                                                    Night</option>
                                                <option value="Both"
                                                    {{ (isset($team->match_timing) && $team->match_timing == 'Both') ? 'selected' : '' }}>
                                                    Both</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="city" class="form-label">Match Type <span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="match_type">
                                                <option value="">Select Match Type</option>
                                                <option value="Limited Overs"
                                                    {{ (isset($team->type_of_cricket) && $team->type_of_cricket == 'Limited Overs') ? 'selected' : '' }}>
                                                    Limited Overs</option>
                                                <option value="Box/ Turf Cricket"
                                                    {{ (isset($team->type_of_cricket) && $team->type_of_cricket == 'Box/ Turf Cricket') ? 'selected' : '' }}>
                                                    Box/ Turf Cricket</option>
                                                <option value="Pair Cricket"
                                                    {{ (isset($team->type_of_cricket) && $team->type_of_cricket == 'Pair Cricket') ? 'selected' : '' }}>
                                                    Pair Cricket</option>
                                                <option value="Test Match"
                                                    {{ (isset($team->type_of_cricket) && $team->type_of_cricket == 'Test Match') ? 'selected' : '' }}>
                                                    Test Match</option>
                                                <option value="The Hundred"
                                                    {{ (isset($team->type_of_cricket) && $team->type_of_cricket == 'The Hundred') ? 'selected' : '' }}>
                                                    The Hundred</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="grounds" class="form-label">Grounds <span
                                                    class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="ground"
                                                value="{{ $team->ground }}" required>
                                        </div>


                                        <!-- Submit Button -->
                                        <div class="form-group col-md-12 text-right">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div> -->
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
<script src="{{asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}">
</script>

<script>
$(function() {
    bsCustomFileInput.init();
});
</script>

<script>
$('#registerForm').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission
    var formData = new FormData(this);
    $("#email-error").html('');

    // Send the AJAX request
    $.ajax({
        url: '{{route("admin.update_team")}}',
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