<footer>
    <div class="footer-container" style="max-width: 85%;">
        <div class="row gy-4">

            <!-- Logo and Description -->
            <div class="col-md-4 text-center text-md-start">
                <a class="navbar-brand footer-logo" href="#">
                    <img src="{{ asset('images/logo.png') }}" alt="Wahdeal Logo" />
                </a>
                <p class="footer-description">
                    We have clothes that suit your style and which you’re proud to wear. From women to men.
                </p>
                <div class="social-icons mt-3">
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                </div>
            </div>

            <!-- Company Links -->
            <div class="col-md-4 text-center text-md-start">
                <h6 class="fw-bold mb-3">COMPANY</h6>
                <div class="row justify-content-center justify-content-md-start">
                    <div class="col-6 col-sm-5 footer-links">
                        <a href="#">Home</a>
                        <a href="#">Brands</a>
                        <a href="#">Events</a>
                    </div>
                    <div class="col-6 col-sm-5 footer-links">
                        <a href="#">Categories</a>
                        <a href="#">About Us</a>
                        <a href="#">Contact Us</a>
                    </div>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="col-md-4 text-center text-md-start">
                <h6 class="fw-bold mb-3 text-center text-md-center">SUBSCRIBE TO NEWSLETTER</h6>
                <form class="position-relative newsletter mx-auto">
                    <input type="email" placeholder="Enter your email address" required>
                    <button type="submit"><i class="bi bi-send"></i></button>
                </form>
            </div>
        </div>

        <!-- Payment + Copyright -->
        <div class="footer-bottom mt-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center text-center text-md-start">
                <!-- Left -->
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    © 2025 Wahdeal. All Rights Reserved
                </div>

                <!-- Right -->
                <div class="d-inline-flex align-items-center justify-content-center justify-content-md-end flex-wrap">
                    <img src="{{ asset('images/Badge.png') }}" alt="Wahdeal Logo" class="img-fluid"
                        style="height: 40px;">
                    <img src="{{ asset('images/Badge1.png') }}" alt="Wahdeal Logo" class="img-fluid"
                        style="height: 40px;">
                    <img src="{{ asset('images/Badge2.png') }}" alt="Wahdeal Logo" class="img-fluid"
                        style="height: 40px;">
                    <img src="{{ asset('images/Badge3.png') }}" alt="Wahdeal Logo" class="img-fluid"
                        style="height: 40px;">
                    <img src="{{ asset('images/Badge4.png') }}" alt="Wahdeal Logo" class="img-fluid"
                        style="height: 40px;">
                </div>
            </div>
        </div>

    </div>
</footer>





<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="{{asset('web/slick/slick.min.js')}}"></script>

@yield('scripts')

<script>
    $('.multiple-items').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
</script>

{{-- <script>
    // Dropdown toggle
        document.addEventListener("click", (e) => {
            const toggle = e.target.closest(".dropdown-toggle");
            const dropdown = toggle ? toggle.closest(".dropdown") : null;
            document.querySelectorAll('.dropdown[aria-expanded="true"]').forEach(el => {
                if (el !== dropdown) el.setAttribute("aria-expanded", "false");
            });
            if (dropdown) {
                dropdown.setAttribute("aria-expanded", dropdown.getAttribute("aria-expanded") !== "true");
            }
        });

        // Drawer Logic
        const hamburger = document.getElementById("hamburger");
        const drawer = document.getElementById("mobile-drawer");
        const overlay = document.getElementById("overlay");
        const closeDrawer = document.getElementById("closeDrawer");

        function openDrawer() {
            drawer.classList.add("open");
            overlay.classList.add("show");
        }

        function closeDrawerFn() {
            drawer.classList.remove("open");
            overlay.classList.remove("show");
        }

        hamburger.addEventListener("click", openDrawer);
        closeDrawer.addEventListener("click", closeDrawerFn);
        overlay.addEventListener("click", closeDrawerFn);
</script> --}}

</body>

</html>