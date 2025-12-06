@extends('layouts.app')
@section('title', 'Home')

@section('styles')
<style>
    /* ==================== SIDEBAR BASE ==================== */
    /* Parent wrapper (row) */
    .responsive-wrapper {
        height: 100vh;
        overflow: hidden;
    }

    /* Right side tab content scroll */
    .tab-content {
        height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: none;
        -ms-overflow-style: none;
        border-radius: 0 !important;
    }

    /* Sidebar scroll */
    .sidebar {
        background: #ffffff;
        border-radius: 12px;
        width: 350px !important;
        height: 80vh;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .sidebar::-webkit-scrollbar {
        display: none;
    }

    .tab-content::-webkit-scrollbar {
        display: none;
    }

    /* Account / Address cards also scroll properly */
    .profile-card,
    .address-card {
        height: auto;
    }

    /* ==================== SIDEBAR ITEMS ==================== */
    .sidebar-item {
        padding: 11px 12px;
        border-radius: 10px;
        font-size: 15px;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        color: #555 !important;
        cursor: pointer;
        margin-bottom: 10px;
        overflow: auto !important;
        transition: 0.2s ease-in-out;
        width: 300px !important;
        margin: auto !important;
        margin-bottom: 10px !important;
    }

    .sidebar-item.active {
        background-color: #F4F4F4 !important;
        color: #000000ff !important;
        border-radius: 10px;
        font-weight: 600;
    }

    .sidebar-item.active i {
        color: #000000ff !important;
    }

    .sidebar-item:hover,
    .active-item {
        background: #f2f2f2;
    }

    .sidebar-item i.bi-chevron-right {
        margin-left: auto;
    }

    /* ==================== PROFILE CARD ==================== */
    .tab-content {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        height: 80vh !important;
    }

    .profile-photo {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
    }

    /* ==================== BUTTONS ==================== */
    .logout-btn {
        width: 100% !important;
        border: 1px solid red;
        color: red;
        background-color: white !important;
        border-radius: 8px;
        padding: 5px 10px;
        font-weight: 500;
        display: block;
        margin: 0 auto;
    }


    .save-btn {
        background: #ff7a00;
        color: #fff;
        padding: 12px 20px;
        border-radius: 8px;
        border: none;
        font-size: 16px;
        width: 200px;
    }

    .new-fav-btn {
        background: #fff;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .bootstrap-switch {
        position: relative;
        width: 48px;
        height: 24px;
    }

    .bootstrap-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .bootstrap-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #d1d5db;
        /* gray-300 */
        border-radius: 24px;
        transition: 0.4s;
    }

    .bootstrap-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        border-radius: 50%;
        transition: 0.4s;
    }

    /* Checked */
    .bootstrap-switch input:checked+.bootstrap-slider {
        background-color: #ff7a00;
    }

    .bootstrap-switch input:checked+.bootstrap-slider:before {
        transform: translateX(24px);
    }

    .btn-orange {
        background-color: #ea580c !important;
        color: white !important;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px;
        transition: 0.2s ease;
    }

    .btn-orange:hover {
        background-color: #c2410c !important;
    }

    .password {
        height: 70vh !important;
    }

    /* Steps container exactly like screenshot */
    .steps-list {
        list-style: none;
        margin-left: 35px !important;
        margin: 0;
        border-left: 4px dotted #d1d5db;
        height: 220px !important;
    }

    .steps-list li {
        position: relative;
        margin-bottom: 28px !important;
        margin-left: 20px !important;
    }

    .step-icon {
        position: absolute;
        left: -56px !important;
        top: -9px !important;
        width: 38px;
        height: 38px;
        background: #e8f1ff;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .step-num {
        font-weight: 600;
        color: #ef4444 !important;
    }

    .steps-list p {
        margin: 0;
        font-size: 15px;
        color: #374151;
    }

    /* No scroll inside wallet area */
    #wallet {
        overflow: hidden;
    }

    .wallet-header {
        position: relative;
        height: 140px;
        background-image: url('images/img.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    /* TOP-CENTER TITLE */
    .wallet-title {
        position: absolute;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        font-weight: 600;
        font-size: 1rem;
    }

    /* TOP-RIGHT ICON */
    .wallet-icon {
        position: absolute;
        top: 8px;
        right: 12px;
        color: white;
        font-size: 18px;
    }

    /* AMOUNT */
    .wallet-amount {
        color: white;
        font-weight: bold;
        font-size: 1rem;
        margin-top: 5px;
    }

    /* BUTTON */
    .wallet-btn {
        border: 1px solid #fff;
        background: transparent;
        color: white;
        padding: 4px 16px;
        font-weight: bold;
        border-radius: 6px;
        margin-top: 8px;
    }

    .brand-card {
        width: 150px;
        height: 150px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .brand-img {
        height: 52px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px;
    }

    .brand-img img {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }

    .tabs-container {
        display: flex !important;
        flex-wrap: nowrap !important;
        padding: 0 !important;
        gap: 0 !important;
        background-color: white !important;
    }

    .tabs-container .nav-item {
        flex: 1 !important;
        font-size: 13px !important;
    }

    .tabs-container .nav-link {
        width: 100%;
        border-radius: 0 !important;
        margin: 0 !important;
    }


    .tab {
        flex: 1;
        text-align: center;
        font-weight: 600;
        padding: 6px 12px;
        cursor: pointer;
        color: #333 !important;
        flex-shrink: 0;
        text-decoration: none;
        background: #FAECE1 !important;
    }

    .tab.active {
        background: #FF6A00 !important;
        color: #fff !important;
    }

    .tab:hover {
        background: #FF6A00 !important;
        color: #fff !important;
    }

    /* Hover effect – but override active only during hover */
    .tabs-container:hover .tab.active {
        background: transparent;
        color: #ffffffff !important;
    }

    .new-offer-card {
        background: #fff;
        overflow: hidden;
        width: 100%;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    /* Image should auto-fit width */
    .new-offer-image {
        width: 100%;
        object-fit: fill;
    }


    /* Image Box */
    .new-offer-img-box {
        position: relative;
    }

    /* Discount Tag */
    .new-offer-tag {
        position: absolute;
        top: 5px;
        right: 5px;
        left: auto;
        background: #ff6a00;
        color: #fff;
        padding: 4px 6px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 10px;
    }


    /* Rating */
    .new-offer-rating {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.65);
        color: #fff;
        padding: 4px !important;
        border-radius: 30px;
        font-size: 10px;
    }

    /* Favorite Button – Bottom Right */
    .new-fav-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: #fff;
        border: none;
        width: 20px;
        height: 20px;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    /* Content */
    .new-offer-content {
        padding: 6px !important;
        height: 55px !important;
    }

    .new-offer-price {
        font-size: 10px;
        font-weight: 600;
    }

    .old-price {
        text-decoration: line-through;
        color: #999;
        margin-right: 6px;
    }

    .new-price {
        color: #ff6a00;
        font-weight: 700;
    }

    .new-offer-title {
        font-size: 12px;
        font-weight: 600;
    }

    .new-offer-location {
        width: 100% !important;
        font-size: 12px;
        font-weight: 600 !important;
        color: #777;
    }

    .new-brand-img {
        width: 30px;
        height: 20px;
        margin-left: 5px;
        object-fit: contain;
        top: 0 !important;
    }

    .fa-heart {
        font-size: 12px;
    }

    .add-cart-full {
        width: 100%;
        background: #ffffff;
        color: #000;
        border: 1.5px solid gray;
        padding: 2px 0;
        border-radius: 6px;
        font-weight: 600;
        font-size: 11px;
        text-align: center;
    }

    .add-cart-full:hover {
        background: #f2f2f2;
    }

    .restaurant-card {
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .resto-img {
        width: 55px;
        height: 55px;
        object-fit: cover;
        border-radius: 8px;
    }

    .book-btn {
        background: #13202D;
        color: #fff;
        width: 100%;
        padding: 10px;
        text-align: center;
        font-weight: 600;
        cursor: pointer;
    }

    .veg-img-resto {
        bottom: 45px;
        width: 20px;
        height: 20px;
        margin: auto !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    .radio-btn input[type="radio"] {
        display: none;
    }

    .radio-btn label {
        padding: 8px 28px;
        border: 1px solid #ddd;
        background: #f8f9fa;
        border-radius: 6px;
        cursor: pointer;
        text-align: center;
        font-weight: 500;
        transition: 0.2s;
    }

    .radio-btn input[type="radio"]:checked+label {
        background: #FAECE1;
        color: #000000ff;
    }

    .order-box {
        padding: 0;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        overflow: hidden;
    }

    /* CONFIRMED HEADER BOX */
    .order-header {
        background: #F4F4F4;
        padding: 5px 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* CONFIRMED BADGE */
    .status-badge {
        background: #DFF6E3;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        color: #0A8A1F;
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .status-badge-cancle {
        background: #FFD6D6;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        color: #FF0000;
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    /* CONTENT BOX */
    .order-content {
        padding: 10px;
        background: #fff;
    }

    /* DELIVERY DATE */
    .delivery-text {
        color: #0A8A1F;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* PRODUCT ROW */
    .product-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-icon {
        background-color: #F4F4F4 !important;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    .arrow {
        font-size: 20px;
        color: #999;
    }

    .custom-btn {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 5px !important;
        background: transparent !important;
        color: #FF6B00 !important;
    }

    .custom-dropdown {
        min-width: 450px;
        border-radius: 15px;
    }

    .status-btn {
        padding: 6px 14px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        background: #f1f1f1;
        border: none;
    }

    .status-btn.active {
        background: #FF6B00;
        color: #fff;
    }

    .reset-btn {
        border: 1px solid #000;
        border-radius: 5px;
        width: 190px !important;
        padding: 6px 30px;
    }

    .reset-btn:hover {
        background: #ffd3b1ff !important;
    }

    .apply-btn {
        background: #FF6B00;
        color: white;
        border-radius: 5px;
        width: 190px !important;
        padding: 6px 30px;
    }

    .apply-btn:hover {
        background: #ffd3b1ff !important;
    }

    #filterDropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 60px;
        width: 100%;
        max-width: 440px;
        background: #fff;
        z-index: 1000;
        border-radius: 15px;
    }

    .order-card {
        background: #fff;
        margin: 0 auto;
        border-radius: 12px;
    }

    /* Product Row */
    .product-details {
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 8px;
        border-bottom: 1px solid #eee;
    }

    .product-details>div:last-child {
        border-bottom: none;
    }

    .product-img {
        width: 64px;
        height: 64px;
        border-radius: 8px;
        object-fit: cover;
    }

    /* Delivery + Price Box */
    .box {
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 8px;
        margin-top: 5px;
    }

    .divider-line {
        height: 1px;
        background: #e5e5e5;
        margin: 8px 0;
    }

    #progressbar {
        margin: 10px;
        padding: 0;
        display: flex;
        width: 500px;
        position: relative;
    }

    #progressbar li {
        list-style: none;
        width: 15.33%;
        text-align: center;
        font-size: 13px;
        font-weight: 500;
        color: #455A64;
        position: relative;
    }

    /* Circle */
    #progressbar li:before {
        content: "\F633" !important;
        font-family: "bootstrap-icons" !important;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #455A64;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 6px auto;
        z-index: 2;
        position: relative;
        font-size: 13px;
    }

    /* Step Numbers */
    #step1:before {
        content: "\F633" !important;
        font-family: "bootstrap-icons" !important;
    }

    #step2:before {
        content: "\F633" !important;
        font-family: "bootstrap-icons" !important;
    }

    #step3:before {
        content: "\F633" !important;
        font-family: "bootstrap-icons" !important;
    }

    /* Connecting Line */
    #progressbar:before {
        content: "\F633" !important;
        font-family: "bootstrap-icons" !important;
        position: absolute;
        top: 15px;
        left: 7%;
        width: 30%;
        height: 3px;
        background: #455A64;
        z-index: 0;
    }

    /* Active Line + Active Circle */
    #progressbar li.active:before {
        background: #0A8A1F !important;
    }

    #progressbar li.active~li:before {
        background: #455A64;
    }

    #progressbar li.active {
        color: #00000094 !important;
    }

    .change {
        background: transparent;
        border: none;
        font-weight: 600;
        cursor: pointer;
        color: #ff7a00 !important;
    }


    .card-custom {
        border-radius: 10px;
    }

    .reason-row {
        cursor: pointer;
    }

    .reason-row:hover {
        background: #f5f5f5;
    }

    .reason-input {
        width: 18px;
        height: 18px;
    }

    textarea {
        border-radius: 0;
        resize: none;
    }

    .btn-outline {
        border: 1px solid #000;
        border-radius: 6px;
        font-size: 14px !important;
    }

    .btn-outline:hover {
        background: #f2f2f2;
    }

    .btn-orange {
        background: #ff7a00;
        color: #fff;
        border-radius: 6px;
        font-size: 14px !important;
    }

    /* Parent ko relative banaya */
    #bookingListWrapper .position-relative {
        position: relative !important;
    }

    /* Filter dropdown right ya side me na jaye — button ke niche aaye */
    #filterDropdown2 {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        width: 440px;
        background: #fff;
        z-index: 9999;
        display: none;
    }

    /* Show class me display block */
    #filterDropdown2.show {
        display: block !important;
    }

    .details-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }

    .details-row:last-child {
        border-bottom: none;
    }


    @media (max-width: 576px) {
        .product-info {
            font-size: 12px !important;
        }

        .product-info img {
            margin-bottom: 10px;
        }

        .btn-outline {
            border: 1px solid #000;
            border-radius: 6px;
            padding: 5px 10px !important;
            font-size: 12px !important;
        }

        .btn-orange {
            background: #ff7a00;
            color: #fff;
            border-radius: 6px;
            padding: 5px 10px !important;
            font-size: 12px !important;
        }

        .details-row {
            flex-direction: row;
            font-size: 13px;
        }

        .details-row div:nth-child(2) {
            text-align: right;
        }
    }



    /* Active tab background + text color override */
    #mobileSidebar .list-group-item.active {
        background-color: #F4F4F4 !important;
        color: #000 !important;
        border-color: #ddd !important;
    }



    /* ==================== RESPONSIVE DESIGN ==================== */

    /* ===== TABLET (991px ↓) ===== */
    @media (max-width: 991px) {

        .sidebar {
            position: fixed;
            top: 0;
            left: -260px;
            width: 260px !important;
            height: 100vh !important;
            background: #ffffff;
            z-index: 9999;
            transition: 0.4s ease;
            overflow-y: auto;
            padding: 20px !important;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background: #ff7a00;
            color: #fff;
            border: none;
            font-size: 22px;
            padding: 6px 12px;
            border-radius: 6px;
            z-index: 10000;
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        .responsive-wrapper {
            width: 100% !important;
            padding: 0 !important;
        }

        .tab-content {
            background: #fff;
            /* padding: 30px; */
            border-radius: 12px;
            height: 100vh !important;
        }

        .brand-card {
            width: 150px;
            height: 150px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .brand-img {
            height: 52px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
        }

        .brand-img img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .day,
        .title,
        .date {
            font-size: 12px !important;
        }

        .price {
            font-size: 11px !important;
            margin-bottom: 15px !important;
        }

        .download {
            width: 14px !important;
            padding: 0 !important;
        }

        #filterDropdown {
            right: 0;
            left: 0;
            margin: auto;
            width: 95%;
        }

        #filterDropdown2 {
            right: 0;
            left: 0;
            margin: auto;
            width: 95%;
        }

        .status-options {
            justify-content: start;
        }

        .new-offer-content {
            padding: 5px !important;
            height: 60px !important;
        }

        .new-offer-title {
            font-size: 10px;
            font-weight: 600;
        }

        .new-offer-location {
            width: 100% !important;
            font-size: 10px;
            font-weight: 600 !important;
            color: #777;
            overflow: hidden !important;
            white-space: nowrap !important;
            text-overflow: ellipsis;
        }

    }

    /* Default stays same — only mobile fix below */

    @media (max-width: 576px) {
        #filterDropdown {
            right: 0;
            left: 0;
            margin: auto;
            width: 95%;
        }

        .new-offer-location {
            width: 100% !important;
            font-size: 10px;
            font-weight: 600 !important;
            color: #777;
            overflow: hidden !important;
            white-space: nowrap !important;
            text-overflow: ellipsis;
        }


        .new-offer-title {
            font-size: 10px;
            font-weight: 600;
        }

        .new-offer-content {
            padding: 5px !important;
            height: 60px !important;
        }

        .status-options {
            justify-content: start;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -260px;
            width: 260px !important;
            height: 100vh !important;
            background: #ffffff;
            z-index: 9999;
            transition: 0.4s ease;
            overflow-y: auto;
            padding: 20px !important;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
        }

        .sidebar.active {
            left: 0;
        }

        .day,
        .title,
        .date {
            font-size: 10px !important;
        }

        .sidebar-toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background: #ff7a00;
            color: #fff;
            border: none;
            font-size: 22px;
            padding: 6px 12px;
            border-radius: 6px;
            z-index: 10000;
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        .responsive-wrapper {
            width: 100% !important;
            background-color: none !important;
            padding: 0 !important;
        }

        .tab-content {
            background: #fff;
            /* padding: 30px; */
            border-radius: 12px;
            height: 100vh !important;
        }

        /* Heading small on mobile */
        .address-card h5 {
            font-size: 0.9rem !important;
            letter-spacing: 0.5px;
        }

        /* Add new address button compact */
        .address-card .btn {
            font-size: 0.75rem !important;
            padding: 4px 8px !important;
            white-space: nowrap;
        }

        /* Address item text compact */
        .address-card .list-group-item span {
            font-size: 0.85rem !important;
            line-height: 1.2;
        }

        /* Change button compact */
        .address-card .list-group-item .btn-sm {
            font-size: 0.75rem !important;
            padding: 2px 8px !important;
        }

        .brand-card {
            width: 130px;
            height: 130px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .brand-img {
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
        }

        .brand-img img {
            width: 40px;
            height: 40px;
            padding: 5px;
            object-fit: cover;
        }

        .price {
            font-size: 11px !important;
            margin-bottom: 15px !important;
        }

        .download {
            width: 14px !important;
            padding: 0 !important;
        }

        .d-flex.gap-3 {
            gap: 12px !important;
        }

        .track-box {
            padding: 12px;
        }

        .status-circle {
            width: 28px;
            height: 28px;
        }
    }
</style>
@endsection



@section('content')
<div class="cate py-2" style="background-color: var(--nav-bg);">
    <div class="cate py-1" style="background-color: var(--nav-bg);">
        <div class="category mx-auto p-2 event">

            <div class="d-flex justify-content-center align-items-center text-white gap-2 flex-wrap" style="font-size: 15px; letter-spacing: 1px;">

                <a href="#" class="text-white text-decoration-none">HOME</a>
                <span>/</span>
                <a href="#" class="text-white text-decoration-none">Profile</a>
                <span>/</span>
                <a href="#" class="text-white text-decoration-none">Account</a>

            </div>

        </div>
    </div>
</div>


<div class="container-fluid py-2 p-0" style="background-color: var(--light-bg);">
    <div class="row container mx-auto">
        <!-- MOBILE TOGGLE BUTTON -->
        <div class="d-flex justify-content-between mb-2 align-items-center">
            <strong class="fs-5">Profile</strong>
            <button class="btn btn-orange d-lg-none" style="width: 40px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Responsive Row -->
        <div class="d-flex gap-3 align-items-start responsive-wrapper">

            <!-- ================= SIDEBAR ================= -->
            <div class="nav sidebar col-lg-4 col-md-4 p-3 nav-pill" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                <div class="nav-link sidebar-item active" data-bs-toggle="pill" data-bs-target="#v-pills-home">
                    <span><i class="bi bi-person"></i> &nbsp; Account</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="nav-link sidebar-item" data-bs-toggle="pill" data-bs-target="#v-pills-profile">
                    <span><i class="bi bi-geo-alt"></i> &nbsp; Address</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="nav-link sidebar-item" id="v-pills-fav-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-fav"
                    role="tab">
                    <span><i class="bi bi-heart"></i> &nbsp; Favorite</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="nav-link sidebar-item" data-bs-toggle="pill" data-bs-target="#v-pills-settings" role="tab">
                    <span><i class="bi bi-gear"></i> &nbsp; Settings</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="nav-link sidebar-item" data-bs-toggle="pill" data-bs-target="#v-pills-password">
                    <span><i class="bi bi-key"></i> &nbsp; Set Password</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="nav-link sidebar-item" data-bs-toggle="pill" data-bs-target="#v-pills-ticket">
                    <span><i class="bi bi-clock"></i> &nbsp; Event Ticket History</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="nav-link sidebar-item" data-bs-toggle="pill" data-bs-target="#v-pills-order">
                    <span><i class="bi bi-clock"></i> &nbsp; Order History</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="nav-link sidebar-item" data-bs-toggle="pill" data-bs-target="#v-pills-booking">
                    <span><i class="bi bi-clock"></i> &nbsp; Booking History</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="nav-link sidebar-item" data-bs-toggle="pill" data-bs-target="#v-pills-wallet">
                    <span><img src="{{ asset('images/wallet.png') }}" width="18"> &nbsp; Refer & Wallet</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

                <!-- Promo Code -->
                <div class="promo-box mt-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <img src="{{ asset('images/promo.png') }}" width="25">
                        </span>
                        <input type="text" class="form-control p-2" placeholder="Enter Refer Code">
                        <button class="btn text-light" style="background-color:#ff7a00;">Submit</button>
                    </div>
                </div>

                <!-- Logout -->
                <button class="logout-btn mt-3" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <span class="d-flex align-items-center justify-content-center gap-1 mx-auto">
                        <img src="{{ asset('images/logout.png') }}" width="15"> Log Out
                    </span>
                </button>

            </div>

            <!-- ================= TAB CONTENT ================= -->
            <div class="tab-content container p-0">

                <!-- ACCOUNT TAB -->
                <div class="tab-pane fade show active p-2" id="v-pills-home">
                    <div class="profile-card d-flex flex-column">

                        <div class="text-start d-flex flex-column align-items-start mb-4">
                            <img src="{{ asset('images/profile.jpg') }}" class="profile-photo mb-2">

                            <label class="text-danger fw-bold mt-1" style="cursor:pointer; font-size:13px;">
                                <span class="d-flex flex-column align-items-center" style="padding: 5px 12px;">EDIT PHOTO</span>
                                <input type="file" class="d-none">
                            </label>
                        </div>


                        <div class="flex-grow-1">
                            <div class="row g-3">
                                <div class="col-12">
                                    <input type="text" class="form-control" placeholder="User Name">
                                </div>

                                <div class="col-12">
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" placeholder="Phone Number">
                                </div>

                                <div class="col-12">
                                    <select class="form-select">
                                        <option selected disabled>Gender</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-start">
                            <button class="save-btn">Save Account</button>
                        </div>

                    </div>
                </div>

                <!-- Address TABS -->
                <div class="tab-pane fade p-2" id="v-pills-profile">
                    <!-- ADDRESS SECTION -->
                    <div class="card address-card border-0 mb-4">

                        <!-- Header + Add Button -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-semibold mb-0 text-muted">SAVED ADDRESSES</h5>
                            <button type="button" class="btn text-light" data-bs-toggle="modal" data-bs-target="#addressModal" style="background-color:#ff7a00;"><i class="bi bi-plus-circle text-light"></i> Add new address</button>
                        </div>

                        <!-- Address List -->
                        <div class="list-group">

                            <div class="list-group-item d-flex justify-content-between align-items-center mb-2 border-0 p-3 rounded" style="background-color: #F4F4F4;">
                                <span>201, Shreeji Heights, Adajan Road, Surat, Gujarat – 395009</span>
                                <button class="btn btn-sm" style="color:#ff7a00; border-color:#ff7a00;">Change</button>
                            </div>

                            <div class="list-group-item d-flex justify-content-between align-items-center mb-2 border-0 p-3 rounded" style="background-color: #F4F4F4;">
                                <span>201, Shreeji Heights, Adajan Road, Surat, Gujarat – 395009</span>
                                <button class="btn btn-sm" style="color:#ff7a00; border-color:#ff7a00;">Change</button>
                            </div>

                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 p-3 rounded" style="background-color: #F4F4F4;">
                                <span>201, Shreeji Heights, Adajan Road, Surat, Gujarat – 395009</span>
                                <button class="btn btn-sm" style="color:#ff7a00; border-color:#ff7a00;">Change</button>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Favorite Section -->
                <div class="tab-pane fade p-2" id="v-pills-fav" role="tabpanel">
                    <h6 class="fw-semibold mb-2 text-muted">BRANDS</h6>
                    <div class="brand-container">
                        <div class="brand-scroll d-flex gap-3">

                            <!-- CARD 1 -->
                            <div class="brand-card">
                                <div class="brand-top">
                                    <span><i class="fa-regular fa-eye"></i> 20K</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('images/veg-non.png') }}" width="18">
                                        <span class="brand-heart text-danger"><i class="fa-solid fa-heart"></i></span>
                                    </div>
                                </div>

                                <div class="brand-img">
                                    <img src="{{ asset('images/lapinoz.png') }}">
                                </div>

                                <div class="brand-name">Lapino’z</div>
                                <div class="offer-strip">UP TO 60% OFF</div>
                            </div>

                            <!-- CARD 2 -->
                            <div class="brand-card">
                                <div class="brand-top">
                                    <span><i class="fa-regular fa-eye"></i> 20K</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('images/veg-non.png') }}" width="18">
                                        <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
                                    </div>
                                </div>

                                <div class="brand-img">
                                    <img src="{{ asset('images/subway.png') }}">
                                </div>

                                <div class="brand-name">Subway</div>
                                <div class="offer-strip">UP TO 60% OFF</div>
                            </div>

                            <!-- CARD 3 -->
                            <div class="brand-card">
                                <div class="brand-top">
                                    <span><i class="fa-regular fa-eye"></i> 20K</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('images/veg-non.png') }}" width="18">
                                        <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
                                    </div>
                                </div>

                                <div class="brand-img">
                                    <img src="{{ asset('images/brnd.png') }}">
                                </div>

                                <div class="brand-name">Burger King</div>
                                <div class="offer-strip">UP TO 60% OFF</div>
                            </div>

                            <!-- CARD 4 -->
                            <div class="brand-card">
                                <div class="brand-top">
                                    <span><i class="fa-regular fa-eye"></i> 20K</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('images/veg-non.png') }}" width="18">
                                        <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
                                    </div>
                                </div>

                                <div class="brand-img">
                                    <img src="{{ asset('images/mcd.png') }}">
                                </div>

                                <div class="brand-name">McDonald’s</div>
                                <div class="offer-strip">UP TO 60% OFF</div>
                            </div>

                            <!-- CARD 5 -->
                            <div class="brand-card">
                                <div class="brand-top">
                                    <span><i class="fa-regular fa-eye"></i> 20K</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('images/veg-non.png') }}" width="18">
                                        <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
                                    </div>
                                </div>

                                <div class="brand-img">
                                    <img src="{{ asset('images/brnd3.png') }}">
                                </div>

                                <div class="brand-name">KFC</div>
                                <div class="offer-strip">UP TO 60% OFF</div>
                            </div>

                            <!-- CARD 6 -->
                            <div class="brand-card">
                                <div class="brand-top">
                                    <span><i class="fa-regular fa-eye"></i> 20K</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('images/veg-non.png') }}" width="18">
                                        <span class="brand-heart text-secondary"><i class="fa-regular fa-heart"></i></span>
                                    </div>
                                </div>

                                <div class="brand-img">
                                    <img src="{{ asset('images/marti-noze.png') }}">
                                </div>

                                <div class="brand-name">Martino’z</div>
                                <div class="offer-strip">UP TO 60% OFF</div>
                            </div>

                        </div>

                        <!-- tabs section -->
                        <ul class="nav nav-pill container tabs-container" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Products</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Shopping</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab" id="pills-gallery-tab" data-bs-toggle="pill" data-bs-target="#pills-booking" type="button" role="tab" aria-controls="pills-booking" aria-selected="false">Booking</button>
                            </li>
                        </ul>

                        <div class="tab-content container p-0 mt-2" id="pills-tabContent">
                            <!-- Products -->
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
                                <div class="fav-brand row g-2">
                                    <div class="col-6 col-sm-4 col-lg-3">
                                        <div class="new-offer-card">
                                            <div class="new-offer-img-box">

                                                <span class="new-offer-tag">-50% OFF</span>
                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="new-offer-title mb-0">Flat ₹200 OFF on Buy Above ₹999</h5>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- card 2 -->
                                    <div class="col-6 col-sm-4 col-lg-3">
                                        <div class="new-offer-card">
                                            <div class="new-offer-img-box">

                                                <span class="new-offer-tag">-50% OFF</span>
                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="new-offer-title mb-0">Flat ₹200 OFF on Buy Above ₹999</h5>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- card 3 -->
                                    <div class="col-6 col-sm-4 col-lg-3">
                                        <div class="new-offer-card">
                                            <div class="new-offer-img-box">

                                                <span class="new-offer-tag">-50% OFF</span>
                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="new-offer-title mb-0">Flat ₹200 OFF on Buy Above ₹999</h5>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- card 4 -->
                                    <div class="col-6 col-sm-4 col-lg-3">
                                        <div class="new-offer-card">
                                            <div class="new-offer-img-box">

                                                <span class="new-offer-tag">-50% OFF</span>
                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="new-offer-title mb-0">Flat ₹200 OFF on Buy Above ₹999</h5>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- card 5 -->
                                    <div class="col-6 col-sm-4 col-lg-3">
                                        <div class="new-offer-card">
                                            <div class="new-offer-img-box">

                                                <span class="new-offer-tag">-50% OFF</span>
                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="new-offer-title mb-0">Flat ₹200 OFF on Buy Above ₹999</h5>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- card 6 -->
                                    <div class="col-6 col-sm-4 col-lg-3">
                                        <div class="new-offer-card">
                                            <div class="new-offer-img-box">

                                                <span class="new-offer-tag">-50% OFF</span>
                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 • 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="new-offer-title mb-0">Flat ₹200 OFF on Buy Above ₹999</h5>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Shopping -->
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                                <div class="fav-brand row g-2">
                                    <!-- CARD 1 -->
                                    <div class="col-6 col-lg-3">
                                        <div class="new-offer-card">

                                            <div class="new-offer-img-box">
                                                <span class="new-offer-tag">-30% OFF</span>

                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="mb-0 d-flex justify-content-between">
                                                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location mb-0">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <div class="new-offer-price">
                                                    <span class="old-price">₹3999</span>
                                                    <span class="new-price">₹1999</span>
                                                </div>
                                            </div>

                                            <!-- Full Width Add to Cart -->
                                            <div class="p-1">
                                                <button class="add-cart-full">Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- card 2 -->
                                    <div class="col-6 col-lg-3">
                                        <div class="new-offer-card">

                                            <div class="new-offer-img-box">
                                                <span class="new-offer-tag">-30% OFF</span>

                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="mb-0 d-flex justify-content-between">
                                                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location mb-0">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <div class="new-offer-price">
                                                    <span class="old-price">₹3999</span>
                                                    <span class="new-price">₹1999</span>
                                                </div>
                                            </div>

                                            <!-- Full Width Add to Cart -->
                                            <div class="p-1">
                                                <button class="add-cart-full">Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- card 3 -->
                                    <div class="col-6 col-lg-3">
                                        <div class="new-offer-card">

                                            <div class="new-offer-img-box">
                                                <span class="new-offer-tag">-30% OFF</span>

                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="mb-0 d-flex justify-content-between">
                                                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location mb-0">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <div class="new-offer-price">
                                                    <span class="old-price">₹3999</span>
                                                    <span class="new-price">₹1999</span>
                                                </div>
                                            </div>

                                            <!-- Full Width Add to Cart -->
                                            <div class="p-1">
                                                <button class="add-cart-full">Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- card 4 -->
                                    <div class="col-6 col-lg-3">
                                        <div class="new-offer-card">

                                            <div class="new-offer-img-box">
                                                <span class="new-offer-tag">-30% OFF</span>

                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="mb-0 d-flex justify-content-between">
                                                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location mb-0">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <div class="new-offer-price">
                                                    <span class="old-price">₹3999</span>
                                                    <span class="new-price">₹1999</span>
                                                </div>
                                            </div>

                                            <!-- Full Width Add to Cart -->
                                            <div class="p-1">
                                                <button class="add-cart-full">Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- card 5 -->
                                    <div class="col-6 col-lg-3">
                                        <div class="new-offer-card">

                                            <div class="new-offer-img-box">
                                                <span class="new-offer-tag">-30% OFF</span>

                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="mb-0 d-flex justify-content-between">
                                                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location mb-0">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <div class="new-offer-price">
                                                    <span class="old-price">₹3999</span>
                                                    <span class="new-price">₹1999</span>
                                                </div>
                                            </div>

                                            <!-- Full Width Add to Cart -->
                                            <div class="p-1">
                                                <button class="add-cart-full">Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- card 6 -->
                                    <div class="col-6 col-lg-3">
                                        <div class="new-offer-card">

                                            <div class="new-offer-img-box">
                                                <span class="new-offer-tag">-30% OFF</span>

                                                <img src="{{ asset('images/ab1.png') }}" class="new-offer-image">

                                                <div class="new-offer-rating">⭐ 4.5 | 20K</div>

                                                <button class="new-fav-btn">
                                                    <span class="text-danger"><i class="fa-solid fa-heart"></i></span>
                                                </button>
                                            </div>

                                            <div class="new-offer-content">
                                                <div class="mb-0 d-flex justify-content-between">
                                                    <h6 class="new-offer-title">Modern Classics, Now on Sale</h6>
                                                    <img src="{{ asset('images/zara_logo.png') }}" class="new-brand-img">
                                                </div>
                                                <div class="new-offer-location mb-0">
                                                    <i class="fa-solid fa-location-dot"></i> Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <div class="new-offer-price">
                                                    <span class="old-price">₹3999</span>
                                                    <span class="new-price">₹1999</span>
                                                </div>
                                            </div>

                                            <!-- Full Width Add to Cart -->
                                            <div class="p-1">
                                                <button class="add-cart-full">Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking -->
                            <div class="tab-pane fade" id="pills-booking" role="tabpanel">
                                <div class="py-2">
                                    <div class="row booking g-4">
                                        <!-- CARD 1 -->
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="restaurant-card">

                                                <!-- TOP CONTENT -->
                                                <div class="card-content p-3 d-flex justify-content-between align-items-start">

                                                    <!-- LEFT SIDE -->
                                                    <div class="d-flex gap-2">
                                                        <img class="resto-img" src="{{ asset('images/resto1.png') }}">

                                                        <div>
                                                            <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="text-muted fw-semibold" style="font-size:14px;">
                                                                    <i class="bi bi-eye-fill fs-6 text-muted"></i> 20K
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- RIGHT SIDE -->
                                                    <div class="d-flex flex-column align-items-end gap-2">
                                                        <button class="border-0 bg-white">
                                                            <span class="text-danger"><i class="fa-solid fa-heart fs-5"></i></span>
                                                        </button>

                                                        <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto">
                                                    </div>

                                                </div>

                                                <!-- ADDRESS -->
                                                <div class="px-3 pb-2 d-flex align-items-center gap-2 text-muted" style="font-size:14px;">
                                                    <i class="fa-solid fa-location-dot text-danger"></i>
                                                    Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <!-- BOOK NOW BUTTON -->
                                                <div class="book-btn">BOOK NOW ➜</div>
                                            </div>
                                        </div>

                                        <!-- CARD 2 -->
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="restaurant-card">

                                                <!-- TOP CONTENT -->
                                                <div class="card-content p-3 d-flex justify-content-between align-items-start">

                                                    <!-- LEFT SIDE -->
                                                    <div class="d-flex gap-2">
                                                        <img class="resto-img" src="{{ asset('images/resto1.png') }}">

                                                        <div>
                                                            <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="text-muted fw-semibold" style="font-size:14px;">
                                                                    <i class="bi bi-eye-fill fs-6 text-muted"></i> 20K
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- RIGHT SIDE -->
                                                    <div class="d-flex flex-column align-items-end gap-2">
                                                        <button class="border-0 bg-white">
                                                            <span class="text-danger"><i class="fa-solid fa-heart fs-5"></i></span>
                                                        </button>

                                                        <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto">
                                                    </div>

                                                </div>

                                                <!-- ADDRESS -->
                                                <div class="px-3 pb-2 d-flex align-items-center gap-2 text-muted" style="font-size:14px;">
                                                    <i class="fa-solid fa-location-dot text-danger"></i>
                                                    Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <!-- BOOK NOW BUTTON -->
                                                <div class="book-btn">BOOK NOW ➜</div>
                                            </div>
                                        </div>

                                        <!-- CARD 3 -->
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="restaurant-card">

                                                <!-- TOP CONTENT -->
                                                <div class="card-content p-3 d-flex justify-content-between align-items-start">

                                                    <!-- LEFT SIDE -->
                                                    <div class="d-flex gap-2">
                                                        <img class="resto-img" src="{{ asset('images/resto1.png') }}">

                                                        <div>
                                                            <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="text-muted fw-semibold" style="font-size:14px;">
                                                                    <i class="bi bi-eye-fill fs-6 text-muted"></i> 20K
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- RIGHT SIDE -->
                                                    <div class="d-flex flex-column align-items-end gap-2">
                                                        <button class="border-0 bg-white">
                                                            <span class="text-danger"><i class="fa-solid fa-heart fs-5"></i></span>
                                                        </button>

                                                        <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto">
                                                    </div>

                                                </div>

                                                <!-- ADDRESS -->
                                                <div class="px-3 pb-2 d-flex align-items-center gap-2 text-muted" style="font-size:14px;">
                                                    <i class="fa-solid fa-location-dot text-danger"></i>
                                                    Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <!-- BOOK NOW BUTTON -->
                                                <div class="book-btn">BOOK NOW ➜</div>
                                            </div>
                                        </div>

                                        <!-- CARD 4 -->
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="restaurant-card">

                                                <!-- TOP CONTENT -->
                                                <div class="card-content p-3 d-flex justify-content-between align-items-start">

                                                    <!-- LEFT SIDE -->
                                                    <div class="d-flex gap-2">
                                                        <img class="resto-img" src="{{ asset('images/resto1.png') }}">

                                                        <div>
                                                            <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="text-muted fw-semibold" style="font-size:14px;">
                                                                    <i class="bi bi-eye-fill fs-6 text-muted"></i> 20K
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- RIGHT SIDE -->
                                                    <div class="d-flex flex-column align-items-end gap-2">
                                                        <button class="border-0 bg-white">
                                                            <span class="text-danger"><i class="fa-solid fa-heart fs-5"></i></span>
                                                        </button>

                                                        <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto">
                                                    </div>

                                                </div>

                                                <!-- ADDRESS -->
                                                <div class="px-3 pb-2 d-flex align-items-center gap-2 text-muted" style="font-size:14px;">
                                                    <i class="fa-solid fa-location-dot text-danger"></i>
                                                    Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <!-- BOOK NOW BUTTON -->
                                                <div class="book-btn">BOOK NOW ➜</div>
                                            </div>
                                        </div>

                                        <!-- CARD 5 -->
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="restaurant-card">

                                                <!-- TOP CONTENT -->
                                                <div class="card-content p-3 d-flex justify-content-between align-items-start">

                                                    <!-- LEFT SIDE -->
                                                    <div class="d-flex gap-2">
                                                        <img class="resto-img" src="{{ asset('images/resto1.png') }}">

                                                        <div>
                                                            <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="text-muted fw-semibold" style="font-size:14px;">
                                                                    <i class="bi bi-eye-fill fs-6 text-muted"></i> 20K
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- RIGHT SIDE -->
                                                    <div class="d-flex flex-column align-items-end gap-2">
                                                        <button class="border-0 bg-white">
                                                            <span class="text-danger"><i class="fa-solid fa-heart fs-5"></i></span>
                                                        </button>

                                                        <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto">
                                                    </div>

                                                </div>

                                                <!-- ADDRESS -->
                                                <div class="px-3 pb-2 d-flex align-items-center gap-2 text-muted" style="font-size:14px;">
                                                    <i class="fa-solid fa-location-dot text-danger"></i>
                                                    Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <!-- BOOK NOW BUTTON -->
                                                <div class="book-btn">BOOK NOW ➜</div>
                                            </div>
                                        </div>

                                        <!-- CARD 6 -->
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="restaurant-card">

                                                <!-- TOP CONTENT -->
                                                <div class="card-content p-3 d-flex justify-content-between align-items-start">

                                                    <!-- LEFT SIDE -->
                                                    <div class="d-flex gap-2">
                                                        <img class="resto-img" src="{{ asset('images/resto1.png') }}">

                                                        <div>
                                                            <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="text-muted fw-semibold" style="font-size:14px;">
                                                                    <i class="bi bi-eye-fill fs-6 text-muted"></i> 20K
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- RIGHT SIDE -->
                                                    <div class="d-flex flex-column align-items-end gap-2">
                                                        <button class="border-0 bg-white">
                                                            <span class="text-danger"><i class="fa-solid fa-heart fs-5"></i></span>
                                                        </button>

                                                        <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto">
                                                    </div>

                                                </div>

                                                <!-- ADDRESS -->
                                                <div class="px-3 pb-2 d-flex align-items-center gap-2 text-muted" style="font-size:14px;">
                                                    <i class="fa-solid fa-location-dot text-danger"></i>
                                                    Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <!-- BOOK NOW BUTTON -->
                                                <div class="book-btn">BOOK NOW ➜</div>
                                            </div>
                                        </div>

                                        <!-- card 7 -->
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="restaurant-card">

                                                <!-- TOP CONTENT -->
                                                <div class="card-content p-3 d-flex justify-content-between align-items-start">

                                                    <!-- LEFT SIDE -->
                                                    <div class="d-flex gap-2">
                                                        <img class="resto-img" src="{{ asset('images/resto1.png') }}">

                                                        <div>
                                                            <h6 class="fw-semibold mb-1" style="font-size: 15px;">Restaurant name</h6>

                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="text-muted fw-semibold" style="font-size:14px;">
                                                                    <i class="bi bi-eye-fill fs-6 text-muted"></i> 20K
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- RIGHT SIDE -->
                                                    <div class="d-flex flex-column align-items-end gap-2">
                                                        <button class="border-0 bg-white">
                                                            <span class="text-danger"><i class="fa-solid fa-heart fs-5"></i></span>
                                                        </button>

                                                        <img src="{{ asset('/images/veg.png') }}" class="veg-img-resto">
                                                    </div>

                                                </div>

                                                <!-- ADDRESS -->
                                                <div class="px-3 pb-2 d-flex align-items-center gap-2 text-muted" style="font-size:14px;">
                                                    <i class="fa-solid fa-location-dot text-danger"></i>
                                                    Sun Arcade, Surat, Gujarat 395007
                                                </div>

                                                <!-- BOOK NOW BUTTON -->
                                                <div class="book-btn">BOOK NOW ➜</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SETTINGS SECTION -->
                <div class="tab-pane fade p-2" id="v-pills-settings" role="tabpanel">
                    <section id=" settings" class="content-section" style="color:#000;">
                        <div class="d-flex flex-column gap-4">

                            <!-- Email Notifications Toggle -->
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-dark fw-semibold">Email Notifications</span>

                                <label class="bootstrap-switch">
                                    <input type="checkbox" checked>
                                    <span class="bootstrap-slider"></span>
                                </label>
                            </div>

                            <!-- FAQ / Terms / Privacy -->
                            <div class="d-flex flex-column gap-3 mt-3">
                                <span class="text-dark mb-2" style="cursor:pointer;">FAQs</span>
                                <span class="text-dark mb-2" style="cursor:pointer;">Terms & Conditions</span>
                                <span class="text-dark" style="cursor:pointer;">Privacy Policy</span>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Password Section -->
                <div class="tab-pane fade p-2" id="v-pills-password">
                    <section id="password" class="content-section" style="color: #000;">
                        <div class="password d-flex flex-column justify-content-between">

                            <!-- INPUT FIELDS -->
                            <div class="d-flex flex-column gap-4">

                                <div>
                                    <label for="newPassword" class="form-label mb-1">New Password</label>
                                    <input type="password" id="newPassword"
                                        class="form-control p-2 shadow-sm"
                                        placeholder="New Password" style="background-color: #F4F4F4;">
                                </div>

                                <div>
                                    <label for="confirmPassword" class="form-label mb-1">Confirm New Password</label>
                                    <input type="password" id="confirmPassword"
                                        class="form-control p-2 shadow-sm"
                                        placeholder="Confirm New Password" style="background-color: #F4F4F4;">
                                </div>

                            </div>

                            <!-- BUTTON (BOTTOM LEFT) -->
                            <button class="btn text-light w-50 mt-4 align-self-start" style="background-color:#ff7a00;">
                                Set Password
                            </button>

                        </div>
                    </section>
                </div>

                <!-- Purchase History Section -->
                <div class="tab-pane fade p-2" id="v-pills-ticket">
                    <div id="sectionGroup">
                        <div class="collapse show" id="purchaseList" data-bs-parent="#sectionGroup">
                            <h6 class="fw-semibold mb-3 text-start text-muted">Purchase History</h6>
                            <div id="purchaseList">
                                <div class="d-flex flex-column gap-2">

                                    <!-- Purchase Item -->
                                    <div class="d-flex align-items-center p-1 rounded shadow-sm"
                                        style="background:#F4F4F4; flex-wrap:nowrap; width:100%;">

                                        <img src="{{ asset('images/evn.png') }}" class="rounded me-2"
                                            style="width:60px;height:60px;object-fit:cover;flex-shrink:0;">

                                        <div class="flex-grow-1" style="min-width:0;">
                                            <h6 class="fw-semibold text-dark mb-1 title" style="font-size: 14px;">
                                                Ras Ramzat 2025
                                            </h6>

                                            <p class="small text-muted mb-1 day">Day 2 3x, Day 3 2x</p>

                                            <div class="d-flex align-items-center text-muted small" style="white-space:nowrap;">
                                                <svg class="me-1 text-dark" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="fw-semibold text-dark date" style="font-size: 11px;">22 Sep - 01 Oct 2025, Sat @10:00 PM</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-center mb-2 text-end" style="flex-shrink:0;">
                                            <a class="text-secondary" data-bs-toggle="collapse" href="#perticularPage">
                                                <img class="download" src="./svg/arrow.svg" width="18">
                                            </a>
                                            <span class="fw-bold text-warning price">₹1,250</span>
                                        </div>
                                    </div>


                                    <!-- Copy this block for more items -->
                                    <div class="d-flex align-items-center p-1 rounded shadow-sm"
                                        style="background:#F4F4F4; flex-wrap:nowrap; width:100%;">

                                        <img src="{{ asset('images/evn.png') }}" class="rounded me-2"
                                            style="width:60px;height:60px;object-fit:cover;flex-shrink:0;">

                                        <div class="flex-grow-1" style="min-width:0;">
                                            <h6 class="fw-semibold text-dark mb-1 title" style="font-size: 14px;">
                                                Ras Ramzat 2025
                                            </h6>

                                            <p class="small text-muted mb-1 day">Day 2 3x, Day 3 2x</p>

                                            <div class="d-flex align-items-center text-muted small" style="white-space:nowrap;">
                                                <svg class="me-1 text-dark" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="fw-semibold text-dark date" style="font-size: 11px;">22 Sep - 01 Oct 2025, Sat @10:00 PM</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-center mb-2 text-end" style="flex-shrink:0;">
                                            <a class="text-secondary" data-bs-toggle="collapse" href="#perticularPage">
                                                <img class="download" src="./svg/arrow.svg" width="18">
                                            </a>
                                            <span class="fw-bold text-warning price">₹1,250</span>
                                        </div>
                                    </div>


                                    <!-- card 3 -->
                                    <div class="d-flex align-items-center p-1 rounded shadow-sm"
                                        style="background:#F4F4F4; flex-wrap:nowrap; width:100%;">

                                        <img src="{{ asset('images/evn.png') }}" class="rounded me-2"
                                            style="width:60px;height:60px;object-fit:cover;flex-shrink:0;">

                                        <div class="flex-grow-1" style="min-width:0;">
                                            <h6 class="fw-semibold text-dark mb-1 title" style="font-size: 14px;">
                                                Ras Ramzat 2025
                                            </h6>

                                            <p class="small text-muted mb-1 day">Day 2 3x, Day 3 2x</p>

                                            <div class="d-flex align-items-center text-muted small" style="white-space:nowrap;">
                                                <svg class="me-1 text-dark" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="fw-semibold text-dark date" style="font-size: 11px;">22 Sep - 01 Oct 2025, Sat @10:00 PM</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-center mb-2 text-end" style="flex-shrink:0;">
                                            <a class="text-secondary" data-bs-toggle="collapse" href="#perticularPage">
                                                <img class="download" src="./svg/arrow.svg" width="18">
                                            </a>
                                            <span class="fw-bold text-warning price">₹1,250</span>
                                        </div>
                                    </div>

                                    <!-- card 4 -->
                                    <div class="d-flex align-items-center p-1 rounded shadow-sm"
                                        style="background:#F4F4F4; flex-wrap:nowrap; width:100%;">

                                        <img src="{{ asset('images/evn.png') }}" class="rounded me-2"
                                            style="width:60px;height:60px;object-fit:cover;flex-shrink:0;">

                                        <div class="flex-grow-1" style="min-width:0;">
                                            <h6 class="fw-semibold text-dark mb-1 title" style="font-size: 14px;">
                                                Ras Ramzat 2025
                                            </h6>

                                            <p class="small text-muted mb-1 day">Day 2 3x, Day 3 2x</p>

                                            <div class="d-flex align-items-center text-muted small" style="white-space:nowrap;">
                                                <svg class="me-1 text-dark" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="fw-semibold text-dark date" style="font-size: 11px;">22 Sep - 01 Oct 2025, Sat @10:00 PM</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-center mb-2 text-end" style="flex-shrink:0;">
                                            <a class="text-secondary" data-bs-toggle="collapse" href="#perticularPage">
                                                <img class="download" src="./svg/arrow.svg" width="18">
                                            </a>
                                            <span class="fw-bold text-warning price">₹1,250</span>
                                        </div>
                                    </div>

                                    <!-- card 5 -->
                                    <div class="d-flex align-items-center p-1 rounded shadow-sm"
                                        style="background:#F4F4F4; flex-wrap:nowrap; width:100%;">

                                        <img src="{{ asset('images/evn.png') }}" class="rounded me-2"
                                            style="width:60px;height:60px;object-fit:cover;flex-shrink:0;">

                                        <div class="flex-grow-1" style="min-width:0;">
                                            <h6 class="fw-semibold text-dark mb-1 title" style="font-size: 14px;">
                                                Ras Ramzat 2025
                                            </h6>

                                            <p class="small text-muted mb-1 day">Day 2 3x, Day 3 2x</p>

                                            <div class="d-flex align-items-center text-muted small" style="white-space:nowrap;">
                                                <svg class="me-1 text-dark" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="fw-semibold text-dark date" style="font-size: 11px;">22 Sep - 01 Oct 2025, Sat @10:00 PM</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-center mb-2 text-end" style="flex-shrink:0;">
                                            <a class="text-secondary" data-bs-toggle="collapse" href="#perticularPage">
                                                <img class="download" src="./svg/arrow.svg" width="18">
                                            </a>
                                            <span class="fw-bold text-warning price">₹1,250</span>
                                        </div>
                                    </div>

                                    <!-- card 6 -->
                                    <div class="d-flex align-items-center p-1 rounded shadow-sm"
                                        style="background:#F4F4F4; flex-wrap:nowrap; width:100%;">

                                        <img src="{{ asset('images/evn.png') }}" class="rounded me-2"
                                            style="width:60px;height:60px;object-fit:cover;flex-shrink:0;">

                                        <div class="flex-grow-1" style="min-width:0;">
                                            <h6 class="fw-semibold text-dark mb-1 title" style="font-size: 14px;">
                                                Ras Ramzat 2025
                                            </h6>

                                            <p class="small text-muted mb-1 day">Day 2 3x, Day 3 2x</p>

                                            <div class="d-flex align-items-center text-muted small" style="white-space:nowrap;">
                                                <svg class="me-1 text-dark" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="fw-semibold text-dark date" style="font-size: 11px;">22 Sep - 01 Oct 2025, Sat @10:00 PM</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-center mb-2 text-end" style="flex-shrink:0;">
                                            <a class="text-secondary" data-bs-toggle="collapse" href="#perticularPage">
                                                <img class="download" src="./svg/arrow.svg" width="18">
                                            </a>
                                            <span class="fw-bold text-warning price">₹1,250</span>
                                        </div>
                                    </div>

                                    <!-- card 7 -->
                                    <div class="d-flex align-items-center p-1 rounded shadow-sm"
                                        style="background:#F4F4F4; flex-wrap:nowrap; width:100%;">

                                        <img src="{{ asset('images/evn.png') }}" class="rounded me-2"
                                            style="width:60px;height:60px;object-fit:cover;flex-shrink:0;">

                                        <div class="flex-grow-1" style="min-width:0;">
                                            <h6 class="fw-semibold text-dark mb-1 title" style="font-size: 14px;">
                                                Ras Ramzat 2025
                                            </h6>

                                            <p class="small text-muted mb-1 day">Day 2 3x, Day 3 2x</p>

                                            <div class="d-flex align-items-center text-muted small" style="white-space:nowrap;">
                                                <svg class="me-1 text-dark" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="fw-semibold text-dark date" style="font-size: 11px;">22 Sep - 01 Oct 2025, Sat @10:00 PM</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-center mb-2 text-end" style="flex-shrink:0;">
                                            <a class="text-secondary" data-bs-toggle="collapse" href="#perticularPage">
                                                <img class="download" src="./svg/arrow.svg" width="18">
                                            </a>
                                            <span class="fw-bold text-warning price">₹1,250</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- perticular -->
                        <div class="collapse" id="perticularPage" data-bs-parent="#sectionGroup">
                            <!-- <div class="container"> -->

                            <!-- PURCHASE HISTORY TITLE -->
                            <h5 class="fw-semibold mb-2">Purchase History</h5>

                            <!-- EVENT CARD -->
                            <div class="d-flex align-items-center p-1 rounded shadow-sm"
                                style="background:#F4F4F4; flex-wrap:nowrap; width:100%;">

                                <img src="{{ asset('images/evn.png') }}" class="rounded me-2"
                                    style="width:60px;height:60px;object-fit:cover;flex-shrink:0;">

                                <div class="flex-grow-1" style="margin-right:20px; min-width:0;">
                                    <h6 class="fw-semibold text-dark mb-1 title" style="font-size: 14px;">
                                        Ras Ramzat 2025
                                    </h6>

                                    <p class="small text-muted mb-1 day">Day 2 3x, Day 3 2x</p>

                                    <div class="d-flex align-items-center text-muted small" style="white-space:nowrap;">
                                        <svg class="me-1 text-dark" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="fw-semibold text-dark date" style="font-size: 11px;">22 Sep - 01 Oct 2025, Sat @10:00 PM</span>
                                    </div>
                                </div>

                                <div class="d-flex flex-column align-items-center mb-2 text-end" style="flex-shrink:0;">
                                    <a class="text-secondary" data-bs-toggle="collapse" href="#perticularPage">
                                        <img class="download" src="./svg/arrow.svg" width="18">
                                    </a>
                                    <span class="fw-bold text-warning price">₹1,250</span>
                                </div>
                            </div>

                            <!-- ATTENDEE INFO -->
                            <h6 class="fw-semibold small mt-3">Attendee Info</h6>
                            <div class="mt-1 p-2 rounded" style="background-color: #F4F4F4;">

                                <div class="d-flex flex-column flex-md-row justify-content-between small">
                                    <span class="fw-semibold d-flex align-items-center mb-2 mb-md-0">Aarav Sharma</span>

                                    <div class="text-md-end">
                                        <div>aravsharma@gmail.com</div>
                                        <div>+91 12345 67890</div>
                                    </div>
                                </div>
                            </div>

                            <!-- TICKET INFO -->
                            <h6 class="fw-semibold small pb-1 mt-3">Ticket Info</h6>
                            <div class="mt-1 p-2 rounded" style="background-color: #F4F4F4;">
                                <div class="p-2 d-flex justify-content-between small">
                                    <div>
                                        <span class="fw-semibold">Day 2 | 3x</span><br>
                                        <span class="text-muted date">22 Sep 2025, Saturday @ 10:00 PM</span>
                                    </div>
                                    <span class="fw-semibold">₹250</span>
                                </div>

                                <div class="border-top p-2 d-flex justify-content-between small">
                                    <div>
                                        <span class="fw-semibold">Day 3 | 2x</span><br>
                                        <span class="text-muted date">22 Sep 2025, Saturday @ 10:00 PM</span>
                                    </div>
                                    <span class="fw-semibold">₹250</span>
                                </div>

                                <div class="border-top p-2 d-flex justify-content-between small">
                                    <span class="fw-semibold">Total Price</span>
                                    <span class="fw-bold text-warning price">₹1,250</span>
                                </div>
                            </div>

                            <!-- DOWNLOAD PDF BUTTON -->
                            <div class="text-center mt-3">
                                <button class="btn btn-outline-dark px-4 py-2 w-100">
                                    <i class="fa-solid fa-download me-2"></i>Download PDF
                                </button>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>

                <!-- Order History Section -->
                <div class="tab-pane fade p-2" id="v-pills-order">
                    <div id="orderSection">
                        <div id="orderListWrapper" class="collapse show" data-bs-parent="#orderSection">
                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                                <h5 class="fw-bold">Order History</h5>
                                <button id="filterBtn" class="btn custom-btn border-0">
                                    <i class="bi bi-filter fs-5"></i> Filter
                                </button>

                                <!-- FILTER DROPDOWN -->
                                <div id="filterDropdown" class="filter-box shadow-sm rounded-4 p-4">
                                    <p class="fw-semibold mb-2">Order Status</p>
                                    <div class="status-options mb-4 d-flex flex-wrap gap-2">
                                        <button class="status-btn">On the way</button>
                                        <button class="status-btn active">Delivered</button>
                                        <button class="status-btn">Cancelled</button>
                                        <button class="status-btn">Returned</button>
                                    </div>

                                    <p class="fw-semibold mb-2">Select Date</p>

                                    <div class="row g-3 mb-4">
                                        <div class="col-6 col-md-6">
                                            <label class="text-muted small mb-1">Start Date</label>
                                            <input type="date" class="form-control date-input">
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <label class="text-muted small mb-1">End Date</label>
                                            <input type="date" class="form-control date-input">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between gap-2 flex-wrap">
                                        <button class="btn reset-btn flex-grow-1">Reset</button>
                                        <button class="btn apply-btn flex-grow-1">Filter</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Order List -->
                            <div class="d-flex justify-content-between mb-1 px-1">
                                <div>
                                    <div class="fw-semibold text-muted" style="font-size:13px;">Order ID</div>
                                    <div class="text-dark" style="font-size:14px;">#1234567890987654321</div>
                                </div>
                                <div class="text-muted" style="font-size:12px;">Tue, 11 Nov</div>
                            </div>

                            <!-- MAIN BOX (CLICKABLE) -->
                            <div class="order-box orderItem" data-target="#orderDetailsPage">
                                <div class="order-header">
                                    <span class="status-badge">
                                        <img src="{{ asset('images/confirm.png') }}" width="16" class="me-1"> Confirmed
                                    </span>
                                    <span style="font-size:18px; cursor:pointer;"><i class="bi bi-question-circle"></i></span>
                                </div>

                                <div class="order-content">
                                    <div class="delivery-text">Arriving by Sun, 16 Nov</div>

                                    <div class="product-row">
                                        <div class="product-left">
                                            <div class="product-icon rounded">
                                                <img src="{{ asset('images/box.png') }}" width="25" class="img-fluid" alt="">
                                            </div>
                                            <div>
                                                <div style="font-size:14px; font-weight:600;">
                                                    3 products <span class="text-muted fw-600">Product Name, Product Nam...</span>
                                                </div>
                                                <div class="text-muted" style="font-size:14px; font-weight:600; margin-top:4px;">
                                                    ₹5,997.00
                                                </div>
                                            </div>
                                        </div>
                                        <div class="arrow"><i class="bi bi-chevron-right text-dark"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order 2 -->
                            <div class="d-flex justify-content-between mt-2 mb-1 px-1">
                                <div>
                                    <div class="fw-semibold text-muted" style="font-size:13px;">Order ID</div>
                                    <div class="text-dark" style="font-size:14px;">#1234567890987654321</div>
                                </div>
                                <div class="text-muted" style="font-size:12px;">Tue, 11 Nov</div>
                            </div>

                            <div class="order-box orderItem" data-target="#orderDetailsPage">
                                <div class="order-header">
                                    <span class="status-badge-cancle">
                                        <img src="{{ asset('images/cancle.png') }}" width="16" class="me-1"> Cancelled
                                    </span>
                                    <span style="font-size:18px; cursor:pointer;"><i class="bi bi-question-circle"></i></span>
                                </div>

                                <div class="order-content">
                                    <div class="product-row">
                                        <div class="product-left">
                                            <div class="product-icon rounded">
                                                <img src="{{ asset('images/box.png') }}" width="25" class="img-fluid" alt="">
                                            </div>
                                            <div>
                                                <div style="font-size:14px; font-weight:600;">
                                                    3 products <span class="text-muted fw-600">Product Name, Product Nam...</span>
                                                </div>
                                                <div class="text-muted" style="font-size:14px; font-weight:600; margin-top:4px;">
                                                    ₹5,997.00
                                                </div>
                                            </div>
                                        </div>

                                        <div class="arrow"><i class="bi bi-chevron-right text-dark"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- perticular order -->
                        <div class="collapse" id="orderDetailsPage" data-bs-parent="#orderSection">
                            <div class="d-flex justify-content-between align-items-center position-relative">
                                <!-- <h5 class="fw-bold">Order History</h5>
                                <button id="filterBtn" class="btn custom-btn border-0">
                                    <i class="bi bi-filter fs-5"></i> Filter
                                </button> -->

                                <!-- FILTER DROPDOWN -->
                                <div id="filterDropdown" class="filter-box shadow-sm rounded-4 p-4">
                                    <p class="fw-semibold mb-2">Order Status</p>
                                    <div class="status-options mb-4 d-flex flex-wrap gap-2">
                                        <button class="status-btn">On the way</button>
                                        <button class="status-btn active">Delivered</button>
                                        <button class="status-btn">Cancelled</button>
                                        <button class="status-btn">Returned</button>
                                    </div>

                                    <p class="fw-semibold mb-2">Select Date</p>

                                    <div class="row g-3 mb-4">
                                        <div class="col-6 col-md-6">
                                            <label class="text-muted small mb-1">Start Date</label>
                                            <input type="date" class="form-control date-input">
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <label class="text-muted small mb-1">End Date</label>
                                            <input type="date" class="form-control date-input">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between gap-2 flex-wrap">
                                        <button class="btn reset-btn flex-grow-1">Reset</button>
                                        <button class="btn apply-btn flex-grow-1">Filter</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Order cancle Details Section -->
                            <div id="ordercancleSection">
                                <div id="orderCancelWrapper" class="collapse show" data-bs-parent="#ordercancleSection">
                                    <div class="order-card">
                                        <div class="product-details">
                                            <div class="d-flex align-items-start gap-3 p-">
                                                <img src="{{ asset('images/product-card.png') }}" class="product-img">
                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold">Product Name</div>
                                                    <div class="text-muted small">Size : L | Color : Yellow</div>
                                                    <div class="text-muted small">Qty : 1</div>
                                                </div>
                                                <button class="btn border-0 text-danger small ordercancleItem" data-target="#ordercanclePage">Cancel item</button>
                                            </div>

                                            <div class="divider-line"></div>

                                            <div class="d-flex align-items-start gap-3 p-">
                                                <img src="{{ asset('images/product-card.png') }}" class="product-img">
                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold">Product Name</div>
                                                    <div class="text-muted small">Size : L | Color : Yellow</div>
                                                    <div class="text-muted small">Qty : 1</div>
                                                </div>
                                                <button class="btn border-0 text-danger small ordercancleItem" data-target="#ordercanclePage">Cancel item</button>
                                            </div>

                                            <!-- TRACKING (Joined like screenshot) -->
                                            <div class="row tracking-row align-items-center">

                                                <!-- LEFT SIDE — Progress Bar -->
                                                <div class="col-12 col-md-7 p-0">
                                                    <ul id="progressbar">
                                                        <li class="active" id="step1">
                                                            Confirmed
                                                            <span class="text-muted d-block" style="font-size:12px;">07 Feb</span>
                                                        </li>

                                                        <li id="step2" class="text-center">
                                                            Shipped
                                                        </li>

                                                        <li id="step3" class="text-right">
                                                            Delivered
                                                        </li>
                                                    </ul>
                                                </div>

                                                <!-- RIGHT SIDE — Delivery Info -->
                                                <div class="col-12 col-md-5 delivery-info text-start">
                                                    <h6 class="text-success m-0">Delivered, Feb 10, 2026</h6>
                                                    <span class="text-muted" style="font-size:13px;">
                                                        Your item has been delivered
                                                    </span>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- DELIVERY DETAILS -->
                                        <div class="box">
                                            <div class="d-flex justify-content-between fw-semibold">
                                                Delivery Details
                                                <button class="text-warning change">Change</button>
                                            </div>

                                            <div class="mt-1">
                                                <div class="d-flex align-items-start">
                                                    <i class="bi bi-house-door me-2 fs-5"></i>
                                                    <div>
                                                        <div class="fw-semibold">Home</div>
                                                        <div class="text-muted small">
                                                            Akshya Nagar 1st Block 1st Cross, Rammurthy nagar, Bangalore–560016
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="divider-line"></div>

                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-telephone me-2 fs-5"></i>
                                                    <div class="text-dark small">+91 12345 67890</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- PRICE DETAILS -->
                                        <div class="box">
                                            <div class="fw-semibold">Price Details</div>

                                            <div class="mt-2 small">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Sub total</span>
                                                    <span>₹5,997.00</span>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Shipping</span>
                                                    <span>₹59.00</span>
                                                </div>

                                                <div class="divider-line"></div>

                                                <div class="d-flex justify-content-between fw-bold">
                                                    <span>Total</span>
                                                    <span>₹6,056.00</span>
                                                </div>

                                                <div class="divider-line"></div>

                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Payment Method</span>
                                                    <span>Cash On Delivery</span>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-outline-dark w-100 mt-1 py-1 fw-semibold">
                                            Shop More Items
                                        </button>
                                    </div>
                                </div>

                                <div class="collapse" id="ordercanclePage" data-bs-parent="#ordercancleSection">
                                    <div class="container p-0">
                                        <div class="car2 p-2 card-custom shadow-sm">
                                            <!-- PRODUCT SECTION -->
                                            <div class="d-flex product-info align-items-center gap-2">
                                                <img src="{{ asset('images/product-card.png') }}" class="rounded d-flex mx-auto" alt="Product" />
                                                <div class="flex-grow-1">
                                                    <strong>Product Name</strong><br />
                                                    <small>Size: L &nbsp; Color: Yellow</small><br />
                                                    <small>Qty: 1</small>
                                                </div>
                                                <strong>₹1,000</strong>
                                            </div>
                                        </div>


                                        <!-- REASONS SECTION -->
                                        <div class="card mt-2 p-2 card-custom shadow-sm">
                                            <p class="fw-semibold">Why do you want to cancel?</p>

                                            <div class="reason-row d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <span>Wrong item selected</span>
                                                <input type="radio" name="reason" class="reason-input" />
                                            </div>


                                            <div class="reason-row d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <span>Ordered by mistake</span>
                                                <input type="radio" name="reason" class="reason-input" />
                                            </div>


                                            <div class="reason-row d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <span>Found cheaper</span>
                                                <input type="radio" name="reason" class="reason-input" />
                                            </div>


                                            <div class="reason-row d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <span>Changed mind</span>
                                                <input type="radio" name="reason" class="reason-input" />
                                            </div>


                                            <div class="reason-row d-flex justify-content-between align-items-center py-2">
                                                <span>Other</span>
                                                <input type="radio" name="reason" class="reason-input" />
                                            </div>
                                        </div>
                                        <textarea class="form-control card-custom mt-2" placeholder="Other Reason" rows="3"></textarea>


                                        <!-- BUTTONS -->
                                        <div class="d-flex gap-3 mt-2">
                                            <button class="btn flex-grow-1 btn-outline border py-2">Don't Cancel</button>
                                            <button class="btn flex-grow-1 btn-orange py-2">Confirm Cancellation</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Section -->
                <div class="tab-pane fade p-2" id="v-pills-booking">
                    <div id="bookingSection">
                        <div id="bookingListWrapper" class="collapse show" data-bs-parent="#bookingSection">
                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                                <h5 class="fw-bold">Order History</h5>
                                <button id="filterBtn2" class="btn custom-btn border-0">
                                    <i class="bi bi-filter fs-5"></i> Filter
                                </button>

                                <!-- FILTER DROPDOWN -->
                                <div id="filterDropdown2" class="filter-box shadow-sm rounded-4 p-4">
                                    <p class="fw-semibold mb-2">Order Status</p>
                                    <div class="status-options mb-4 d-flex flex-wrap gap-2">
                                        <button class="status-btn">On the way</button>
                                        <button class="status-btn active">Delivered</button>
                                        <button class="status-btn">Cancelled</button>
                                        <button class="status-btn">Returned</button>
                                    </div>

                                    <p class="fw-semibold mb-2">Select Date</p>

                                    <div class="row g-3 mb-4">
                                        <div class="col-6 col-md-6">
                                            <label class="text-muted small mb-1">Start Date</label>
                                            <input type="date" class="form-control date-input">
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <label class="text-muted small mb-1">End Date</label>
                                            <input type="date" class="form-control date-input">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between gap-2 flex-wrap">
                                        <button class="btn reset-btn flex-grow-1">Reset</button>
                                        <button class="btn apply-btn flex-grow-1">Filter</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Order List 1 -->
                            <div class="d-flex justify-content-between mb-1 px-1">
                                <div class="fw-semibold text-muted" style="font-size:13px;">Book A Table</div>
                            </div>

                            <!-- MAIN BOX (CLICKABLE) -->
                            <div class="order-box orderItem bookingItem" data-target="#bookingDetailsPage">
                                <div class="order-header">
                                    <span class="status-badge">
                                        <img src="{{ asset('images/confirm.png') }}" width="16" class="me-1"> Confirmed
                                    </span>
                                    <span style="font-size:18px; cursor:pointer;"><i class="bi bi-question-circle"></i></span>
                                </div>

                                <div class="order-content">
                                    <div class="delivery-text text-dark">Booking by sun, 16 Nov at 7:30PM</div>

                                    <div class="product-row">
                                        <div class="product-left">
                                            <div class="product-icon rounded">
                                                <img src="{{ asset('images/mcd.png') }}" width="35" class="img-fluid" alt="">
                                            </div>
                                            <div>
                                                <div style="font-size:14px; font-weight:600;">
                                                    <span class="text-dark fw-600">Brand Name</span>
                                                </div>
                                                <div class="text-muted" style="font-size:14px; font-weight:600; margin-top:4px;">
                                                    <i class="bi bi-geo-alt-fill text-danger"></i> Mota Varachha
                                                </div>
                                            </div>
                                        </div>
                                        <div class="arrow"><i class="bi bi-chevron-right text-dark"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order List 2 -->
                            <div class="d-flex justify-content-between mb-1 mt-2 px-1">
                                <div class="fw-semibold text-muted" style="font-size:13px;">Appointment</div>
                            </div>

                            <!-- MAIN BOX (CLICKABLE) -->
                            <div class="order-box orderItem bookingItem" data-target="#bookingDetailsPage">
                                <div class="order-header">
                                    <span class="status-badge-cancle">
                                        <img src="{{ asset('images/cancle.png') }}" width="16" class="me-1"> Cancelled
                                    </span>
                                    <span style="font-size:18px; cursor:pointer;"><i class="bi bi-question-circle"></i></span>
                                </div>

                                <div class="order-content">
                                    <div class="product-row">
                                        <div class="product-left">
                                            <div class="product-icon rounded">
                                                <img src="{{ asset('images/cmd1.png') }}" width="35" class="img-fluid" alt="">
                                            </div>
                                            <div>
                                                <div style="font-size:14px; font-weight:600;">
                                                    <span class="text-dark fw-600">Classes Name</span>
                                                </div>
                                                <div class="text-muted" style="font-size:14px; font-weight:600; margin-top:4px;">
                                                    <i class="bi bi-geo-alt-fill text-danger"></i> Mota Varachha
                                                </div>
                                            </div>
                                        </div>

                                        <div class="arrow"><i class="bi bi-chevron-right text-dark"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- perticular booking -->
                        <div class="collapse" id="bookingDetailsPage" data-bs-parent="#bookingSection">
                            <div class="booking-details-wrapper container p-0">

                                <!-- TOP CARD -->
                                <div class="card card-custom mb-2 p-2 shadow-sm">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="text-success fw-semibold" style="font-size:14px;">
                                                Booking by Sun, 16 Nov at 7:30PM
                                            </div>

                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <div class="product-icon rounded">
                                                    <img src="{{ asset('images/mcd.png') }}" width="35" class="img-fluid" alt="">
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">Brand Name</div>
                                                    <div class="text-muted small"><i class="bi bi-geo-alt-fill text-danger"></i> Mota Varachha</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- USER DETAILS -->
                                <div class="card card-custom p-2 shadow-sm mb-2">
                                    <h6 class="fw-semibold">User Details</h6>

                                    <div class="details-row">
                                        <div>User name</div>
                                        <div class="text-end fw-semibold">ABC User</div>
                                    </div>

                                    <div class="details-row">
                                        <div>Mo. number</div>
                                        <div class="text-end fw-semibold">+91 1234567890</div>
                                    </div>

                                    <div class="details-row">
                                        <div>Email ID</div>
                                        <div class="text-end fw-semibold">abc@gmail.com</div>
                                    </div>
                                </div>

                                <!-- BOOKING DETAILS -->
                                <div class="card card-custom p-2 shadow-sm mb-2">
                                    <h6 class="fw-semibold">Booking Details</h6>

                                    <div class="details-row">
                                        <div>Booking Date</div>
                                        <div class="text-end fw-semibold">16 Nov</div>
                                    </div>

                                    <div class="details-row">
                                        <div>Booking Time</div>
                                        <div class="text-end fw-semibold">07:30 AM</div>
                                    </div>

                                    <div class="details-row">
                                        <div>Number of Guest</div>
                                        <div class="text-end fw-semibold">4 people</div>
                                    </div>

                                    <div class="details-row">
                                        <div>Number of table</div>
                                        <div class="text-end fw-semibold">Table 3</div>
                                    </div>

                                    <div class="details-row">
                                        <div>Occasion</div>
                                        <div class="text-end fw-semibold">Birthday</div>
                                    </div>

                                    <div class="details-row">
                                        <div>Seating Preference</div>
                                        <div class="text-end fw-semibold">Indoor</div>
                                    </div>

                                    <div class="details-row">
                                        <div>Special Requests</div>
                                        <div class="text-end fw-semibold text-wrap" style="max-width:200px;">
                                            Cake cutting, decoration, music
                                        </div>
                                    </div>

                                </div>

                                <!-- BUTTONS -->
                                <div class="d-flex gap-3 mt-2">
                                    <button class="btn border flex-grow-1 py-2">Cancel Booking</button>
                                    <button class="btn btn-orange flex-grow-1 py-2">New Booking</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Wallet -->
                <div class="tab-pane fade" id="v-pills-wallet">

                    <!-- TOTAL BALANCE CARD -->
                    <div class="wallet-header">

                        <!-- TOP CENTER TITLE -->
                        <div class="wallet-title">Total Balance</div>

                        <!-- TOP RIGHT ICON -->
                        <div class="wallet-icon">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>

                        <!-- AMOUNT CENTER -->
                        <div class="wallet-amount">₹1000.00</div>

                        <!-- BUTTON CENTER BELOW AMOUNT -->
                        <button class="wallet-btn">Send Money</button>
                    </div>


                    <!-- REFERRAL CARD -->
                    <div class="rounded w p-3 mt-2 position-relative d-flex mx-auto justify-content-between align-items-center" style="width: 95%; background-color:#F4F4F4">
                        <div class="flex-grow-1 me-2">
                            <div class="text-dark fw-semibold mb-1">Referral Code</div>

                            <div class="d-flex justify-content-between align-items-center text-white px-2 py-1"
                                style="background:#1f2937; border-radius:6px; width:160px;">
                                <span class="fw-monospace">GYU9R7F3</span>
                                <button class="btn p-0 text-white">
                                    <i class="fa-solid fa-clone"></i>
                                </button>
                            </div>
                        </div>

                        <div class="position-absolute top-0 end-0 mt-2 me-2 text-dark" style="cursor:pointer;">
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>

                        <div class="position-absolute bottom-0 end-0 overflow-hidden" style="width:50px;">
                            <img src="{{ asset('images/gift.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>

                    <!-- Refer & Earn -->
                    <div class="d-flex align-items-center text-secondary mx-3 p-2 small">
                        <div class="bg-danger-subtle p-1 rounded-circle me-2">
                            <img src="./svg/ref.svg" width="22" alt="">
                        </div>

                        <h6 class="fw-bold text-orange" style="color: #ff7a00;">Refer & Earn</h6>

                        <button class="btn btn-orange ms-auto fw-bold px-3 py-1">
                            Invite Friend
                        </button>
                    </div>

                    <!-- Info -->
                    <div class="d-flex align-items-center text-secondary mx-3 p-2 small">
                        <i class="fa-solid fa-circle-info"></i>
                        <span class="ms-1">How it Work</span>
                    </div>

                    <!-- STEP LIST -->
                    <ul class="steps-list p-3">
                        <li class="mb-2">
                            <span class="step-icon me-2"><img src="./svg/link.svg" width="20" alt=""></span>
                            <p class="mb-0 small"><span class="fw-semibold step-num">Step 1:</span> Share your referral link.</p>
                        </li>

                        <li class="mb-2">
                            <span class="step-icon me-2"><img src="./svg/downs.svg" width="20" alt=""></span>
                            <p class="mb-0 small"><span class="fw-semibold step-num">Step 2:</span> Friend installs & logs in.</p>
                        </li>

                        <li class="mb-2">
                            <span class="step-icon me-2"><img src="./svg/frd.svg" width="20" alt=""></span>
                            <p class="mb-0 small"><span class="fw-semibold step-num">Step 3:</span> Friend subscribes.</p>
                        </li>

                        <li class="mb-2">
                            <span class="step-icon me-2"><img src="./svg/walt.svg" width="20" alt=""></span>
                            <p class="mb-0 small"><span class="fw-semibold step-num">Step 4:</span> Earn cashback.</p>
                        </li>

                        <li class="mb-1">
                            <span class="step-icon me-2"><img src="./svg/hand.svg" width="20" alt=""></span>
                            <p class="mb-0 small"><span class="fw-semibold step-num">Step 5:</span> Use cashback.</p>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <!-- MOBILE SIDEBAR MODAL -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0">
                <div class="list-group list-group-flush">
                    <button class="list-group-item list-group-item-action active" data-bs-toggle="pill" data-bs-target="#v-pills-home">
                        <i class="bi bi-person"></i> Account
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="pill" data-bs-target="#v-pills-profile">
                        <i class="bi bi-geo-alt"></i> Address
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="pill" data-bs-target="#v-pills-fav">
                        <i class="bi bi-heart"></i> Favorite
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="pill" data-bs-target="#v-pills-settings">
                        <i class="bi bi-gear"></i> Settings
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="pill" data-bs-target="#v-pills-password">
                        <i class="bi bi-key"></i> Set Password
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="pill" data-bs-target="#v-pills-ticket">
                        <i class="bi bi-clock"></i> Event Ticket History
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="pill" data-bs-target="#v-pills-order">
                        <i class="bi bi-clock"></i> Order History
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="pill" data-bs-target="#v-pills-booking">
                        <i class="bi bi-clock"></i> Booking History
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="pill" data-bs-target="#v-pills-wallet">
                        <img src="{{ asset('images/wallet.png') }}" width="18"> Refer & Wallet
                    </button>
                    <button class="list-group-item list-group-item-action text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <img src="{{ asset('images/logout.png') }}" width="15"> Log Out
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Modal -->
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3" style="background-color: #F4F4F4;">

                <!-- Modal Header -->
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="addressModalLabel">Enter address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <!-- Address Type Buttons -->
                    <div class="d-grid gap-2 mb-3" style="grid-template-columns: repeat(4, 1fr);">

                        <div class="radio-btn">
                            <input type="radio" name="location" id="home">
                            <label for="home">Home</label>
                        </div>

                        <div class="radio-btn">
                            <input type="radio" name="location" id="work">
                            <label for="work">Work</label>
                        </div>

                        <div class="radio-btn">
                            <input type="radio" name="location" id="hotel">
                            <label for="hotel">Hotel</label>
                        </div>

                        <div class="radio-btn">
                            <input type="radio" name="location" id="other">
                            <label for="other">Other</label>
                        </div>
                    </div>

                    <!-- Input Fields -->
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Flat / House no / Building name">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Floor (optional)">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" value="Uttran, Surat" readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Nearby Landmark (optional)">
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer p-2 border-0 justify-content-center">
                    <button type="button" class="btn text-light" style="background-color: #ff7a00; width: 75%;">Save Address</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">

                <!-- Modal Header (User Icon) -->
                <div class="modal-header justify-content-center bg-dark">
                    <img src="./svg/lgo.svg" alt="User Icon" style="height: 80px;">
                </div>

                <!-- Modal Body -->
                <div class="modal-body text-center">
                    <h5 class="modal-title fw-bold mb-2" id="logoutModalLabel">Log Out</h5>
                    <p class="mb-0">Are you sure you want to logout the account?</p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" id="confirmLogoutButton">Log Out</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelLogoutButton">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection



@section('scripts')
<script>
    document.querySelectorAll(".sidebar-item").forEach(item => {
        item.addEventListener("click", function() {
            document.querySelectorAll(".sidebar-item").forEach(i => i.classList.remove("active"));
            this.classList.add("active");
        });
    });
</script>

<script>
    const sidebar = document.querySelector(".sidebar");
    const toggleBtn = document.querySelector(".sidebar-toggle-btn");

    const overlay = document.createElement("div");
    overlay.classList.add("sidebar-overlay");
    document.body.appendChild(overlay);

    toggleBtn.addEventListener("click", () => {
        sidebar.classList.toggle("active");
        overlay.classList.toggle("show");
    });

    overlay.addEventListener("click", () => {
        sidebar.classList.remove("active");
        overlay.classList.remove("show");
    });
</script>

<script>
    const filterBtn = document.getElementById("filterBtn");
    const filterDropdown = document.getElementById("filterDropdown");

    filterBtn.addEventListener("click", () => {
        filterDropdown.style.display =
            filterDropdown.style.display === "block" ? "none" : "block";
    });

    // Close when clicking outside
    document.addEventListener("click", (e) => {
        if (!filterBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
            filterDropdown.style.display = "none";
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const filterBtn2 = document.getElementById("filterBtn2");
        const filterDropdown2 = document.getElementById("filterDropdown2");

        filterBtn2.addEventListener("click", function(e) {
            e.stopPropagation();
            filterDropdown2.classList.toggle("show");
        });

        // Outside click → close
        document.addEventListener("click", function(e) {
            if (!filterDropdown2.contains(e.target) && !filterBtn2.contains(e.target)) {
                filterDropdown2.classList.remove("show");
            }
        });

    });
</script>



<script>
    const statusBtns = document.querySelectorAll(".status-btn");

    statusBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            // remove active from all
            statusBtns.forEach(b => b.classList.remove("active"));

            // add active to clicked one
            btn.classList.add("active");
        });
    });
</script>

<script>
    // Order click → show details page
    document.querySelectorAll('.orderItem').forEach(item => {
        item.addEventListener('click', function() {

            // Order list hide
            document.getElementById('orderListWrapper').style.display = "none";

            // Get target collapse
            const target = document.querySelector(this.dataset.target);

            // Show collapse using Bootstrap 5 JS
            const collapse = new bootstrap.Collapse(target, {
                show: true
            });
        });
    });

    // Back button → show order list + hide details
    document.getElementById("backToOrders").addEventListener("click", () => {

        const target = document.getElementById('orderDetailsPage');

        const collapse = new bootstrap.Collapse(target, {
            hide: true
        });

        document.getElementById('orderListWrapper').style.display = "block";
    });
</script>


<script>
    // Order click → show details page
    document.querySelectorAll('.ordercancleItem').forEach(item => {
        item.addEventListener('click', function() {

            // Order list hide
            document.getElementById('orderCancelWrapper').style.display = "none";

            // Get target collapse
            const target = document.querySelector(this.dataset.target);

            // Show collapse using Bootstrap 5 JS
            const collapse = new bootstrap.Collapse(target, {
                show: true
            });
        });
    });

    // Back button → show order list + hide details
    document.getElementById("backToOrders").addEventListener("click", () => {

        const target = document.getElementById('ordercanclePage');

        const collapse = new bootstrap.Collapse(target, {
            hide: true
        });

        document.getElementById('orderCancelWrapper').style.display = "block";
    });
</script>


<script>
    // Order click → show details page
    document.querySelectorAll('.bookingItem').forEach(item => {
        item.addEventListener('click', function() {

            // Order list hide
            document.getElementById('bookingListWrapper').style.display = "none";

            // Get target collapse
            const target = document.querySelector(this.dataset.target);

            // Show collapse using Bootstrap 5 JS
            const collapse = new bootstrap.Collapse(target, {
                show: true
            });
        });
    });

    // Back button → show order list + hide details
    document.getElementById("backToOrders").addEventListener("click", () => {

        const target = document.getElementById('bookingPage');

        const collapse = new bootstrap.Collapse(target, {
            hide: true
        });

        document.getElementById('bookingDetailsPage').style.display = "block";
    });
</script>
@endsection