@extends('brand.layouts.app')

@section('title', 'View Order')

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
                        <h1 class="m-0">View Order</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Order</li>
                        </ol>
                    </div>
                </div>


                <div class="form-group col-md-4">
                    <label for="page" class="form-label">Status</label>
                    <select class="form-control" onchange="changestatus(this.value)">
                        <option value="">Select Status</option>

                        @if($order->order_status != '5')
                        @if($order->order_status != '4')
                        <option value="2" @if($order->order_status == '2') selected @endif>Shipped</option>
                        <option value="3" @if($order->order_status == '3') selected @endif>On the Way</option>
                        @endif
                        <option value="4" @if($order->order_status == '4') selected @endif>Delivered</option>
                        @if($order->order_status != '4')
                        <option value="6" @if($order->order_status == '6') selected @endif>Return</option>
                        <option value="7" @if($order->order_status == '7') selected @endif>Complete</option>
                        @endif
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
                                        {{$order->first_name ?? ''}} {{$order->last_name ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Mobile:</label>
                                        {{$order->mobile ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Email:</label>
                                        {{$order->email ?? ''}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>order_number:</label>
                                        {{$order->order_number ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Product:</label>
                                        {{$product->name ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Brand:</label>
                                        {{$brand->name ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Image:</label>
                                        <img class="status-img"
                                            src="{{ asset('uploads/product/' . ($product->image ?? 'logo.png')) }}"
                                            style="width:40px;">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Offer:</label>
                                        {{$order->offer_title ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Size:</label>
                                        {{$order->size_name ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Color:</label>
                                        {{$order->color_name ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Quantity:</label>
                                        {{$order->quantity ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Price:</label>
                                        {{$order->price ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>GST:</label>
                                        {{$order->gst.'%' ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>GST Price:</label>
                                        {{$order->gst_price ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Discount:</label>
                                        {{$order->discount ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Final Price:</label>
                                        {{$order->final_price ?? ''}}
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Status:</label>
                                        {{$order->cart_status_text ?? ''}}
                                    </div>
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
        url: "{{ route('brand.order_change_status') }}",
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