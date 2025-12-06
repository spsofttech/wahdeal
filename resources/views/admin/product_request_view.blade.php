@extends('admin.layouts.app')

@section('title', 'View Product Request')

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
                        <h1 class="m-0">View Product Request</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>
                    </div>
                </div>

                @if($data->status == 'pending')
                <div class="form-group col-md-4">
                    <label for="page" class="form-label">Approve/Reject</label>
                    <select class="form-control" onchange="changestatus(this.value)">
                        <option value="">Select Status</option>
                        <option value="approved">Approve</option>
                        <option value="rejected">Reject</option>
                    </select>
                </div>
                @endif



            </div>
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
                                        <div class="form-group col-md-3">
                                            <label @if($oldproduct)
                                                class="{{ $category->name != $oldproduct->category_name ? 'text-danger font-weight-bold' : '' }}"
                                                @endif>Category:</label>
                                            {{$category->name ?? ''}}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label @if($oldproduct)
                                                class="{{ $subcategory->name != $oldproduct->subcategory_name ? 'text-danger font-weight-bold' : '' }}"
                                                @endif>SubCategory:</label>
                                            {{$subcategory->name ?? ''}}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label @if($oldproduct)
                                                class="{{ $brand->name != $oldproduct->brand_name ? 'text-danger font-weight-bold' : '' }}"
                                                @endif>Brand:</label>
                                            {{$brand->name ?? ''}}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label @if($oldproduct)
                                                class="{{ $product['name'] != $oldproduct->name ? 'text-danger font-weight-bold' : '' }}"
                                                @endif>Name:</label>
                                            {{$product['name'] ?? ''}}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label @if($oldproduct)
                                                class="{{ $product['price'] != $oldproduct->price ? 'text-danger font-weight-bold' : '' }}"
                                                @endif>Price:</label>
                                            {{$product['price'] ?? ''}}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label @if($oldproduct)
                                                class="{{ $product['veg_nonveg'] != $oldproduct->veg_nonveg ? 'text-danger font-weight-bold' : '' }}"
                                                @endif>Veg/Non Veg:</label>
                                            @if($product['veg_nonveg'] == '1')
                                            Veg
                                            @elseif($product['veg_nonveg'] == '2')
                                            Non Veg
                                            @elseif($product['veg_nonveg'] == '3')
                                            All
                                            @else
                                            -
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label @if($oldproduct)
                                                class="{{ $product['is_fashion'] != $oldproduct->is_fashion ? 'text-danger font-weight-bold' : '' }}"
                                                @endif>Is Fashion:</label>
                                            @if($product['is_fashion'] == '0')
                                            Offline
                                            @elseif($product['is_fashion'] == '1')
                                            Online
                                            @else
                                            Both
                                            @endif
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label @if($oldproduct)
                                                class="{{ $product['is_cart_cancel_product'] != $oldproduct->is_cart_cancel_product ? 'text-danger font-weight-bold' : '' }}"
                                                @endif>Cart Cancel Product :</label>
                                            @if($product['is_cart_cancel_product'] == '0')
                                            No
                                            @else
                                            Yes
                                            @endif
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label>Image:</label>
                                            <img @if($oldproduct)
                                                class="{{ $product['image'] != $oldproduct->image ? 'border border-danger' : '' }}"
                                                @endif
                                                src="{{ asset('uploads/product/' . ($product['image'] ?? 'logo.png')) }}"
                                                style="width:50px">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label @if($oldproduct)
                                                class="{{ $data->about != $oldproduct->description ? 'text-danger font-weight-bold' : '' }}"
                                                @endif>Description:</label>
                                            {{ strip_tags($data->about) }}
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label @if($oldproduct)
                                                class="{{ $product['disclaimer'] != $oldproduct->disclaimer ? 'text-danger font-weight-bold' : '' }}"
                                                @endif>Disclaimer:</label>
                                            {{$product['disclaimer']}}
                                        </div>
                                        <div class="form-group col-md-12">
                                            @php
                                            $productImages = json_decode($data->product_images, true);
                                            $newGalleryImages = $productImages['images'] ?? [];
                                            @endphp
                                            <label>Product Images:</label>
                                            @if (!empty($newGalleryImages))
                                            @foreach ($newGalleryImages as $img)

                                            @php
                                            $isNew = !in_array($img, $oldproductimages);
                                            @endphp


                                            <a href="{{ asset('uploads/product/'.$img) }}" target="_blank">
                                                <img src="{{ asset('uploads/product/'.$img) }}"
                                                    class="img-thumbnail mb-2 {{ $isNew ? 'border border-danger' : '' }}"
                                                    style="width:50px; height:50px; object-fit:cover;">
                                            </a>
                                            @endforeach
                                            @else
                                            <p>No images available.</p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Size:</label>

                                            @if (!empty($sizeNames))
                                            @foreach ($sizeNames as $sizeval)

                                            @php
                                            $existssize = in_array((string)$sizeval, array_map('strval', $oldproductsize
                                            ?? []));
                                            @endphp

                                            <span style="color: {{ $existssize ? 'black' : 'red' }};">
                                                {{ $sizeval }},
                                            </span>

                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Color:</label>
                                            @if (!empty($colorNames))
                                            @foreach ($colorNames as $colorval)
                                            @php
                                            $exists = in_array((string)$colorval, array_map('strval', $oldproductcolor
                                            ?? []));
                                            @endphp

                                            <span style="color: {{ $exists ? 'black' : 'red' }};">
                                                {{ $colorval }},
                                            </span>
                                            @endforeach
                                            @endif
                                        </div>

                                    </div>
                                    <div class="row mt-3">
                                        <h5 style="font-weight: bold">Size & Color Price List</h5>
                                    </div>
                                    <div class="row mt-3">
                                        @foreach ($sizecolorresult as $index => $variant)
                                        <div class="form-group col-md-4">
                                            <label>Size:</label>
                                            {{$variant['size']}}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Color:</label>
                                            {{$variant['color']}}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Price:</label>
                                            {{$variant['price']}}
                                        </div>
                                        @endforeach
                                    </div>

                                    @if(!empty($offer['offer']) && $data->product_id == '')
                                    <div class="row mt-3">
                                        <h5 style="font-weight: bold">Offer</h5>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="form-group col-md-4">
                                            <label for="title" class="form-label">Offer Type :</label>
                                            {{ $offertypename }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="title" class="form-label">Title :</label>
                                            {{ $offer['offer']['title'] }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="description" class="form-label">Description :</label>
                                            {{ $offer['offer']['description'] }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="discount_type" class="form-label">Discount Type :</label>
                                            {{ $offer['offer']['discount_type'] }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="discount_value" class="form-label">Discount Value :</label>
                                            {{ $offer['offer']['discount_value'] }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="start_date" class="form-label">Start Date :</label>
                                            {{ \Carbon\Carbon::parse($offer['offer']['start_date'])->format('d, M Y') }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="end_date" class="form-label">End Date :</label>
                                            {{ \Carbon\Carbon::parse($offer['offer']['end_date'])->format('d, M Y') }}
                                        </div>
                                    </div>
                                    @endif
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


<script>
    function changestatus(status) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "{{ route('admin.product_request_change_status') }}",
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
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
</script>
@endsection