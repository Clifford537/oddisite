    <!-- Footer -->
    <div class="footer text-center">
        <p>&copy; 2024 Design Team weavex WebDesigns: 
            <span>
                <i class="fas fa-phone-alt text-success"></i> <!-- Call icon -->
                Text or Call <!-- Phone number -->
            </span>
            <a href="https://wa.me/254706000786" target="_blank">
                <span>
                    <i class="fab fa-whatsapp text-success" style="margin-left: 5px;"></i> <!-- WhatsApp icon -->
                    Chat via WhatsApp <!-- Phone number -->
                </span>
            </a>
        </p>
        <p class="text-info">Your Local time <span id="currentTime"></span></p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript to display current time -->
    <script>
        function updateTime() {
            const now = new Date();
            const formattedTime = now.toLocaleTimeString();
            document.getElementById('currentTime').textContent = formattedTime;
        }

        // Update the time every second
        setInterval(updateTime, 1000);

        // Set initial time
        updateTime();
    </script>
</body>
</html>
