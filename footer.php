            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("sidebarToggle");

            if (toggleBtn) {
                toggleBtn.addEventListener("click", function() {
                    sidebar.classList.toggle("active");
                });
            }
        });
    </script>
</body>
</html>
