<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Deals</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('web/main.css') }}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        /* ================== GENERAL STYLES ================== */
/* General Body Styles */
.container {
    display: flex;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    max-width: 85%;
    min-height: 300px; 
    overflow: hidden; 
    margin: 30px auto;
    gap: 30px;
}

/* Sidebar Styles */
.sidebar {
    width: 250px; /
    padding: 20px;
    border-right: 1px solid #eee;
    background-color: #fff;
    flex-shrink: 0;
}

.sidebar-item {
    display: flex;
    align-items: center;
    padding: 15px 10px;
    margin-bottom: 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.2s ease;
    color: #333;
    font-size: 16px;
}

.sidebar-item:hover {
    background-color: #f0f0f0;
}

.sidebar-item.active {
    background-color: #e6f7ff; 
    color: #000; 
    font-weight: bold;
}

.sidebar-item i {
    margin-right: 15px;
    color: #666; 
}

.sidebar-item.active i {
    color: #000; 
}

.sidebar-item span {
    flex-grow: 1;
}

/* Main Content Styles */
.main-content {
    flex-grow: 1; 
    padding: 20px;
    position: relative; 
    overflow: hidden;
}

.transaction-list, .transaction-list1 {
    max-height: calc(100vh - 80px); 
    overflow-y: auto; 
    padding-right: 15px; 
    box-sizing: border-box; 
}

/* Custom Scrollbar for Webkit browsers (Chrome, Safari) */
.transaction-list::-webkit-scrollbar {
    display: none; 
}

.transaction-list1::-webkit-scrollbar {
    display: none; 
}

.transaction-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.transaction-item:last-child {
    border-bottom: none;
}

.profile-pic {
    width: 60px;
    height: 60px;
    border-radius: 20%;
    margin-right: 15px;
    object-fit: cover;
    background-color: #f0f0f0; 
}

.transaction-details {
    display: flex;
    flex-direction: column;
    flex-grow: 1; 
}

.transaction-details .name {
    font-weight: bold;
    color: #333;
    font-size: 15px;
}

.transaction-details .date {
    font-size: 13px;
    color: #888;
    margin-top: 2px;
}

.amount {
    font-weight: bold;
    font-size: 16px;
    margin-left: 15px; 
    flex-shrink: 0; 
    margin-top: 3px
}

.amount.negative {
    color: #ff4d4f; 
}

.amount.positive {
    color: #52c41a; 
}

.date1 {
    color: rgba(255, 107, 0, 1);
    margin-top: 3px;
}

.amount1{
    color: #555
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        flex-direction: column; 
        width: 100%;
        border-radius: 0;
        box-shadow: none;
        min-height: auto; 
    }

    .sidebar {
        width: 100%; 
        border-right: none;
        border-bottom: 1px solid #eee;
        padding: 15px;
        display: flex; 
        overflow-x: auto; 
        -webkit-overflow-scrolling: touch; 
        white-space: nowrap; 
        box-sizing: border-box;
    }

    .sidebar-item {
        margin-bottom: 0;
        margin-right: 10px; 
        flex-shrink: 0; 
        font-size: 14px;
        padding: 10px 12px;
    }

    .sidebar-item i {
        margin-right: 8px;
    }

    .sidebar-item:last-child {
        margin-right: 0;
    }

    .main-content {
        padding: 15px;
    }

    .transaction-list {
        max-height: calc(100vh - 120px); 
        padding-right: 8px; 
    }

    .transaction-item {
        padding: 12px 0;
    }

    .profile-pic {
        width: 35px;
        height: 35px;
        margin-right: 10px;
    }

    .transaction-details .name {
        font-size: 14px;
    }

    .transaction-details .date {
        font-size: 12px;
    }

    .amount {
        font-size: 14px;
        margin-left: 10px;
    }
}

@media (max-width: 480px) {
    .sidebar {
        padding: 10px;
    }
    .sidebar-item {
        font-size: 13px;
        padding: 8px 10px;
    }
    .sidebar-item i {
        margin-right: 5px;
    }
    .main-content {
        padding: 10px;
    }
    .transaction-list {
         max-height: calc(100vh - 100px);
    }
}
     
    </style>
</head>

<body>
    <!-- banner Section -->
    <section class="breadcrumb-section">
        <div class="breadcrumb-container">
            <span class="breadcrumb-home">HOME /</span>
            <span class="breadcrumb-home">PROFILE /</span>
            <span class="breadcrumb-home">REFER & WALLET /</span>
            <span>HISTORY</span>
        </div>
    </section>
    <!-- ---------------------------------------------------------------------------- -->

<!-- Main Content -->
       <div class="container">
        <div class="sidebar">
            <div class="sidebar-item active">
                <i class="fas fa-history"></i>
                <span>Transaction history</span>
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="sidebar-item">
                <i class="fas fa-users"></i>
                <span>Referral history</span>
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
        <div class="main-content">
            <div class="transaction-list">
                <!-- Transaction Item 1 (Negative) -->
                <div class="transaction-item">
                    <img src="{{ asset('images/evn.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Ras Ramzat 2025</span>
                        <span class="date">22 sep 2025</span>
                    </div>
                    <span class="amount negative">-₹1,250</span>
                </div>

                <!-- Transaction Item 2 (Positive) -->
                <div class="transaction-item">
                    <img src="{{ asset('images/prof.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Rohan Mali</span>
                        <span class="date">22 sep 2025</span>
                    </div>
                    <span class="amount positive">+₹1,250</span>
                </div>

                <!-- Repeat for more items (copy-paste as needed) -->
                <div class="transaction-item">
                    <img src="{{ asset('images/evn.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Ras Ramzat 2025</span>
                        <span class="date">22 sep 2025</span>
                    </div>
                    <span class="amount negative">-₹1,250</span>
                </div>

                <div class="transaction-item">
                    <img src="{{ asset('images/prof.png') }}"" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Rohan Mali</span>
                        <span class="date">22 sep 2025</span>
                    </div>
                    <span class="amount positive">+₹1,250</span>
                </div>

                <div class="transaction-item">
                    <img src="{{ asset('images/evn.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Ras Ramzat 2025</span>
                        <span class="date">22 sep 2025</span>
                    </div>
                    <span class="amount negative">-₹1,250</span>
                </div>

                <div class="transaction-item">
                    <img src="{{ asset('images/prof.png') }}"" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Rohan Mali</span>
                        <span class="date">22 sep 2025</span>
                    </div>
                    <span class="amount positive">+₹1,250</span>
                </div>

                <div class="transaction-item">
                    <img src="{{ asset('images/evn.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Ras Ramzat 2025</span>
                        <span class="date">22 sep 2025</span>
                    </div>
                    <span class="amount negative">-₹1,250</span>
                </div>

                 <div class="transaction-item">
                    <img src="{{ asset('images/prof.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Rohan Mali</span>
                        <span class="date">22 sep 2025</span>
                    </div>
                    <span class="amount positive">+₹1,250</span>
                </div>

                <div class="transaction-item">
                    <img src="{{ asset('images/evn.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Ras Ramzat 2025</span>
                        <span class="date">22 sep 2025</span>
                    </div>
                    <span class="amount negative">-₹1,250</span>
                </div>
                <!-- End of repeated items -->
            </div>

            <div class="transaction-list1">
                <!-- Transaction Item 1 (Negative) -->
                <div class="transaction-item">
                    <img src="{{ asset('images/prof1.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Ras Ramzat 2025</span>
                        <span class="date1">6 Months Plan ₹599</span>
                    </div>
                    <span class="amount1">22 sep 2025</span>
                </div>

                <!-- Transaction Item 2 (Positive) -->
                <div class="transaction-item">
                    <img src="{{ asset('images/prof.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Rohan Mali</span>
                        <span class="date1">6 Months Plan ₹599</span>
                    </div>
                    <span class="amount1">22 sep 2025</span>
                </div>

                <!-- Repeat for more items (copy-paste as needed) -->
                <div class="transaction-item">
                    <img src="{{ asset('images/prof1.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Ras Ramzat 2025</span>
                        <span class="date1">6 Months Plan ₹599</span>
                    </div>
                    <span class="amount1">22 sep 2025</span>
                </div>

                <div class="transaction-item">
                    <img src="{{ asset('images/prof.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Rohan Mali</span>
                       <span class="date1">6 Months Plan ₹599</span>
                    </div>
                    <span class="amount1">22 sep 2025</span>
                </div>

                <div class="transaction-item">
                    <img src="{{ asset('images/prof1.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Ras Ramzat 2025</span>
                        <span class="date1">6 Months Plan ₹599</span>
                    </div>
                    <span class="amount1">22 sep 2025</span>
                </div>

                <div class="transaction-item">
                    <img src="{{ asset('images/prof.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Rohan Mali</span>
                        <span class="date1">6 Months Plan ₹599</span>
                    </div>
                    <span class="amount1">22 sep 2025</span>
                </div>

                <div class="transaction-item">
                    <img src="{{ asset('images/prof1.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Ras Ramzat 2025</span>
                        <span class="date1">6 Months Plan ₹599</span>
                    </div>
                    <span class="amount1">22 sep 2025</span>
                </div>

                 <div class="transaction-item">
                    <img src="{{ asset('images/prof.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Rohan Mali</span>
                        <span class="date1">6 Months Plan ₹599</span>
                    </div>
                    <span class="amount1">22 sep 2025</span>
                </div>

                <div class="transaction-item">
                    <img src="{{ asset('images/prof1.png') }}" alt="Profile" class="profile-pic">
                    <div class="transaction-details">
                        <span class="name">Ras Ramzat 2025</span>
                        <span class="date1">6 Months Plan ₹599</span>
                    </div>
                    <span class="amount1">22 sep 2025</span>
                </div>
                <!-- End of repeated items -->
            </div>
        </div>
    </div>
    <!-- ------------------------------------------------------------------------------------------ -->

    <!-- SCRIPT SECTION -->
     <script>
$(document).ready(function() {

    // Initially show transaction list and hide referral list
    $(".transaction-list").show();
    $(".transaction-list1").hide();

    // On sidebar item click
    $(".sidebar-item").click(function() {
        // Remove active class from all, add to clicked one
        $(".sidebar-item").removeClass("active");
        $(this).addClass("active");

        // Check which sidebar item was clicked
        let text = $(this).find("span").text().trim();

        if (text === "Transaction history") {
            $(".transaction-list").show();
            $(".transaction-list1").hide();
        } 
        else if (text === "Referral history") {
            $(".transaction-list1").show();
            $(".transaction-list").hide();
        }
    });

});
</script>
</body>

</html>