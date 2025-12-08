@extends('brand.layouts.app')

@section('title', 'View Booking Appointment')

@section('styles')
<style>
    .cke_notification_warning {
        display: none !important;
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
                        <h1 class="m-0">View Booking Appointment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">View Booking Appointment</li>
                        </ol>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <label for="page" class="form-label">Status</label>
                    <select class="form-control" onchange="changestatus(this.value)">
                        <option value="">Select Status</option>
                        @if($booking->book_status == '0')
                        <option value="0" @if($booking->book_status == '0') selected @endif>Pending</option>
                        @endif

                        <option value="1" @if($booking->book_status == '1') selected @endif>Complete</option>
                        <option value="2" @if($booking->book_status == '2') selected @endif>Confirmed</option>

                        @if($booking->book_status != '1' && $booking->book_status != '2')
                        <option value="3" @if($booking->book_status == '3') selected @endif>Cancelled</option>
                        <option value="4" @if($booking->book_status == '4') selected @endif>Rejected</option>
                        @endif
                    </select>
                </div>



            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>User:</label>
                                        {{$booking->first_name ?? ''}} {{$booking->last_name ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Mobile:</label>
                                        {{$booking->mobile ?? ''}}
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Email:</label>
                                        {{$booking->email ?? ''}}
                                    </div>

                                </div>

                                @if($booking->book_status == '3')
                                <h4 style="margin-top:20px;">Cancel Reason</h4>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Reason:</label>
                                        {{$booking->cancel_reason}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Other Cancel Reason:</label>
                                        {{$booking->booking_cancel_reason_other}}
                                    </div>
                                </div>
                                @endif

                                <h4 style="margin-top:20px;">Form Info</h4>

                                <div class="row" style="margin-top:20px;">
                                    @foreach($bookdata as $fd)
                                    <div class="form-group col-md-3">
                                        <label>{{ $fd['label'] }}:</label>
                                        @php
                                        $value = $fd['value'];
                                        $isDate = strtotime($value) && preg_match('/\d{4}-\d{2}-\d{2}/', $value);
                                        $isTime = preg_match('/^\d{1,2}:\d{2}\s?(AM|PM)$/i', $value);
                                        @endphp

                                        @if($isDate)
                                        {{ \Carbon\Carbon::parse($value)->format('d, M Y') }}
                                        @else
                                        {{ $value }}
                                        @endif
                                    </div>
                                    @endforeach
                                </div>

                                <div class="row" style="margin-top:20px;">
                                    @foreach($image as $imageval)
                                    <div class="form-group col-md-3">
                                        <label>{{ $imageval['label'] }}:</label>
                                        <a target="_blank" style="cursor: pointer;"
                                            href="{{ asset('uploads/booking/' . ($imageval['image'])) }}"><img
                                                src="{{ asset('uploads/booking/' . ($imageval['image'] ?? 'logo.png')) }}"
                                                style="height:100px; width:200px;"></a>
                                    </div>
                                    @endforeach
                                </div>



                            </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    function changestatus(status) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "{{ route('brand.booking_change_status') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            id: '{{ $id }}',
            status:status
        },
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
               location.reload();
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
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
</script>
@endsection