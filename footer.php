<footer class="bg-dark text-white py-4">
    <div class="container">
    <div class="row">
            <div class="col-lg-4 mb-4">
                <h5>Contact Us</h5>
                <p>Phone: +6012-4567890</p>
                <p>Email: PawHaven@company.com</p>
                <p>Address: 123 Pet Street, Pertaling Jaya, Selangor.</p>
            </div>
            <div class="col-lg-4 mb-4">
                <h5>Membership Packages</h5>
                <p>Unlock exclusive offers, discounts, and benefits!</p>
                <p>Join our membership program today.</p>
                <a href="#" class="btn btn-outline-light btn-sm">Explore Memberships</a>
            </div>
            <div class="col-lg-4 mb-4">
                <h5>Follow Us</h5>
                <p>Stay updated with our latest news and products.</p>
                <div class="social-icons">
                    <a href="#" class="text-white mr-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white mr-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white mr-2"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
    <!-- Bootstrap JS and jQuery -->
    <script src="https://kit.fontawesome.com/0994c13037.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    


    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.querySelectorAll('.slide');
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            slides[slideIndex - 1].style.display = 'block';
            setTimeout(showSlides, 2000); // Change image every 2 seconds
        }
        // Function to logout (for the logout button)
        function logout() {
            window.location.href = 'logout.php'; // Redirect to logout page
        }
    </script>

    <script>
    // Add a script to handle the sticky effect on scroll
    window.onscroll = function () {
        stickyHeader();
    };

    // Get the header
    var header = document.querySelector("header");

    // Get the offset position of the navbar
    var sticky = header.offsetTop;

    // Add the sticky class to the header when you reach its scroll position
    function stickyHeader() {
        if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    }
</script>


</body>

</html>