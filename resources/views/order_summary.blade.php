<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('web/main.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        /* --- Main Layout Container --- */
.shopping-cart-container {
    display: flex;
    flex-wrap: wrap; 
    gap: 24px;
    max-width: 85%;
    margin: 3% auto;
}

/* --- Left Section: Cart Items --- */
.cart-items-list {
    flex: 1; 
    min-width: 300px; 
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.cart-item {
    background-color: #fff;
    border-radius: 8px;
    padding: 10px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 4px 2px 4px 2px rgba(0, 0, 0, 0.1);
}

.item-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 4px;
    flex-shrink: 0;
}

.item-details {
    flex-grow: 1;
}

.item-details h3 {
    margin: 0 0 4px 0;
    font-size: 1em;
    font-weight: 500;
}

.item-details p {
    margin: 4px 0;
    font-size: 0.875em;
    color: #555;
}

.item-details .price {
    color: #333;
    font-weight: 500;
}

.item-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.quantity-selector {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.quantity-btn {
    background-color: #fff;
    border: none;
    cursor: pointer;
    font-size: 1.1em;
    padding: 6px 12px;
    color: #888;
}

.quantity {
    padding: 0 10px;
    font-weight: 500;
    font-size: 0.9em;
    color: #555
}

.delete-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.2em;
    color: #e74c3c;
    padding: 5px;
}

/* --- Right Section: Order Summary --- */
.order-summary {
    width: 100%; 
    max-width: 360px; 
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.summary-card {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.address-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    font-size: 0.9em;
}

.address-header span {
    font-weight: 500;
    color: #888;
}

.change-link {
    color: #f39c12;
    text-decoration: none;
    font-weight: 500;
}

.delivery-address p {
    margin: 0;
    font-size: 0.9em;
    color: #666;
    line-height: 1.5;
}

.price-details h4 {
    margin: 0 0 15px 0;
    font-weight: 500;
    color: #000
}

.price-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 0.9em;
    color: #555
}

.price-details hr {
    border: none;
    border-top: 1px solid #eee;
    margin: 15px 0;
}

.total-row {
    font-weight: 700;
    font-size: 1em;
}

.total-amount-box {
    border: 1px solid #f39c12;
    background-color: #fff9f0;
    border-radius: 8px;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-amount-box span {
    font-weight: 500;
}

.final-amount {
    font-size: 1.1em;
    font-weight: 700 !important;
    color: #e67e22;
}

.checkout-button {
    background-color: #e67e22;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 15px;
    font-size: 1em;
    font-weight: 700;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.2s;
}

.checkout-button:hover {
    background-color: #d35400;
}

/* -------------- */
.price-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 15px;
            /* adjust spacing as needed */
        }

        .prices {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .old-price {
            text-decoration: line-through;
            color: #888;
            font-size: 14px;
            margin-right: 6px;
        }

        .new-price {
            font-size: 15px;
            font-weight: 600;
            color: #222;
        }

        .price-top {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .offer-percent {
            color: #00b050;
            font-size: 14px;
            font-weight: 600;
            margin-top: 4px;
        }

        .add-btn {
            background: #ff6600;
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
        }

         /* Location */
        .location {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #555;
            margin: 0 15px;
            margin-top: -10px;
        }

        .location i {
            margin-right: 6px;
            color: red;
        }

        /* --------------------- */

/* --- Responsive Design --- */
@media (min-width: 900px) {
    .order-summary {
        width: 360px; 
    }
}

/* For Mobile Phones */
@media (max-width: 500px) {
    .cart-item {
        flex-direction: column;
        align-items: flex-start;
        position: relative;
    }
    .item-image {
        align-self: center;
    }
    .item-actions {
        width: 100%;
        margin-top: 10px;
        justify-content: space-between;
    }
}
    </style>
</head>
<body>
    <!-- banner Section -->
    <section class="breadcrumb-section">
        <div class="breadcrumb-container">
            <span class="breadcrumb-home">HOME /</span>
            <span class="breadcrumb-home">FASHION APPAREL /</span>
            <span>ORDER SUMMARY</span>

        </div>
    </section>
    <!-- ----------------------------------------------------------------------------------------------- -->

    <!-- DETILS SECTION -->
    <div class="shopping-cart-container">
        <div class="cart-items-list">
            
            <div class="cart-item">
                <img src="{{ asset('images/jac1.png') }}" alt="Rust-colored patterned coat" class="item-image">
                <div class="item-details">
                    <h3>Fashion Top</h3>
                    <p class="offer">Flat ₹200 OFF on Buy Above ₹999</p>
                    <p class="delivery">Delivery By Mon, 23 Apr</p>
                    <p class="price">1X ₹1999</p>
                </div>
                <div class="item-actions">
                    <div class="quantity-selector">
                        <button class="quantity-btn">-</button>
                        <span class="quantity">01</span>
                        <button class="quantity-btn">+</button>
                    </div>
                    <button class="delete-btn">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>

            <div class="cart-item">
                <img src="{{ asset('images/fash9.png') }}" alt="Black leather jacket" class="item-image">
                <div class="item-details">
                    <h3>Fashion Top</h3>
                    <p class="offer">Flat ₹200 OFF on Buy Above ₹999</p>
                    <p class="delivery">Delivery By Mon, 23 Apr</p>
                    <p class="price">1X ₹1999</p>
                </div>
                <div class="item-actions">
                    <div class="quantity-selector">
                        <button class="quantity-btn">-</button>
                        <span class="quantity">01</span>
                        <button class="quantity-btn">+</button>
                    </div>
                    <button class="delete-btn">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>

            <div class="cart-item">
                <img src="{{ asset('images/fash8.png') }}" alt="Green top with striped pants" class="item-image">
                <div class="item-details">
                    <h3>Fashion Top</h3>
                    <p class="offer">Flat ₹200 OFF on Buy Above ₹999</p>
                    <p class="delivery">Delivery By Mon, 23 Apr</p>
                    <p class="price">1X ₹1999</p>
                </div>
                <div class="item-actions">
                    <div class="quantity-selector">
                        <button class="quantity-btn">-</button>
                        <span class="quantity">01</span>
                        <button class="quantity-btn">+</button>
                    </div>
                    <button class="delete-btn">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="order-summary">
            <div class="summary-card delivery-address">
                <div class="address-header">
                    <span>Deliver to:</span>
                    <a href="#" class="change-link">Change</a>
                </div>
                <p>Akshya Nagar 1st Block 1st Cross, Rammurthy nagar, Bangalore-560016</p>
            </div>

            <div class="summary-card price-details">
                <h4>Price Details</h4>
                <div class="price-row">
                    <span>Sub total</span>
                    <span>₹5,997.00</span>
                </div>
                <div class="price-row">
                    <span>Shipping</span>
                    <span>₹59.00</span>
                </div>
                <hr>
                <div class="price-row total-row">
                    <span>Total</span>
                    <span>₹6,056.00</span>
                </div>
            </div>

            <div class="total-amount-box">
                <span style="color: #000">Total amount</span>
                <span class="final-amount">₹6,056.00</span>
            </div>

            <button class="checkout-button">Checkout</button>
        </div>
    </div>
    <!-- ------------------------------------------------------------------------------------------------ -->

    <!-- Top Fashion Section -->
    <div class='cate' style="margin-top: 20px">
        <div class="banners2" style="margin-top: -20px;">
            <div class='brand1'
                style="display: flex; justify-content: space-between; align-items: center; margin-top: 2%;">
                <img src="{{ asset('images/heading22.png') }}" alt="Summer fashion"
                    style="width: auto; height: 40px;" />
                <p class='text' style="color: rgba(255, 107, 0, 1); font-weight: 600; cursor: pointer; margin: 0;">
                    VIEW ALL >>
                </p>
            </div>
            <div class="offers-grid " style="margin-top: 2%">
                <!-- Offer Card Example -->
                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash1.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash2.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>

                <div class="offer-card">
                    <div class="card-image-container">
                        <img src="{{ asset('images/fash3.png') }}" alt="La Pino'z Pizza Offer">
                        <div class="heart-box">
                            <i class="far fa-heart"></i>
                        </div>
                        <div>
                            <div class="rat"
                                style="position: absolute; bottom: 5px; left: 10px; background-color: rgba(0, 0, 0, 0.6); color: white; padding: 3px 8px; border-radius: 5px; font-size: 14px;">
                                <span class="star">★</span>4.5
                            </div>
                            <div class="discount-badge">-50% OFF</div>
                        </div>
                    </div>
                    <div class="offer-content">
                        <div class="offer-desc">Flat ₹200 OFF on Buy Above ₹999</div>
                        <div>
                            <img src="./svg/gucci.svg" alt="">
                        </div>
                    </div>
                    <div class="location">
                        <i class="fa-solid fa-location-dot"></i> Mota Varachha
                    </div>

                    <div class="price-section">
                        <div class="prices">
                            <div class="price-top">
                                <span class="old-price">₹3999</span>
                                <span class="new-price">₹1999</span>
                            </div>
                            <span class="offer-percent">30% OFF</span>
                        </div>
                        <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                    </div>
                </div>
                <!-- Repeat cards as needed... -->
            </div>
        </div>
    </div>
    <!-- --------------------------------------------------------------------------------------------------- -->


    <!-- SCRIPT SECTION -->
     <script>
  document.querySelectorAll('.quantity-selector').forEach(selector => {
    const quantityEl = selector.querySelector('.quantity');
    const minusBtn = selector.querySelectorAll('.quantity-btn')[0];
    const plusBtn = selector.querySelectorAll('.quantity-btn')[1];
    
    let quantity = parseInt(quantityEl.textContent);

    plusBtn.addEventListener('click', () => {
      quantity++;
      quantityEl.textContent = quantity.toString().padStart(2, '0');
    });

    minusBtn.addEventListener('click', () => {
      if (quantity > 0) {
        quantity--;
        quantityEl.textContent = quantity.toString().padStart(2, '0');
      }
    });
  });
</script>

<!-- When trash icon is clicked Remove Product-->
<script>
$(document).ready(function() {
    $(document).on('click', '.fa-trash-can', function() {
        $(this).closest('.cart-item').remove();
    });
});
</script>

</body>
</html>