<?php
/**
 * Layout Footer
 * Closing tags, Bootstrap JS, Chart.js, and common scripts.
 */
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
?>

    </main><!-- /.prvts-main -->

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js (loaded on all pages, lightweight) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script>
    // Global flatpickr init for all date inputs.
    // altInput shows dd/mm/yyyy; name attribute submits yyyy-mm-dd to server.
    function initFlatpickr(scope) {
        var root = scope || document;
        root.querySelectorAll('input[type="date"]:not(.flatpickr-input)').forEach(function(el) {
            flatpickr(el, {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd/m/Y',
                allowInput: true,
                altInputClass: 'form-control flatpickr-input',
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.altInput) {
                        instance.altInput.setAttribute('placeholder', 'dd/mm/yyyy');
                    }
                }
            });
        });
    }
    document.addEventListener('DOMContentLoaded', function() { initFlatpickr(); });
    </script>
    <script src="<?= $baseUrl ?>/assets/js/searchable-select.js?v=<?= time() ?>"></script>


    <!-- Sidebar Toggle Script -->
    <script>
    (function() {
        const toggle   = document.getElementById('sidebarToggle');
        const sidebar  = document.getElementById('sidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        const main     = document.querySelector('.prvts-main');

        // Restore sidebar state from localStorage on page load
        if (sidebar && main && window.innerWidth >= 992) {
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('collapsed');
                main.classList.add('expanded');
            }
        }

        if (toggle && sidebar) {
            toggle.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    sidebar.classList.toggle('show');
                    if (overlay) overlay.classList.toggle('show');
                } else {
                    const isCollapsed = sidebar.classList.toggle('collapsed');
                    main.classList.toggle('expanded');
                    localStorage.setItem('sidebarCollapsed', isCollapsed);
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

        // Sidebar nav links: on desktop, collapse sidebar before navigating
        if (sidebar) {
            sidebar.querySelectorAll('.nav-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth >= 992) {
                        localStorage.setItem('sidebarCollapsed', 'true');
                    }
                    // On mobile, close the overlay
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('show');
                        if (overlay) overlay.classList.remove('show');
                    }
                });
            });
        }

        // Auto-dismiss flash alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 5000);
        });
    })();
    </script>

    <?php if (isset($extraScripts)): ?>
        <?php foreach ((array)$extraScripts as $script): ?>
            <script src="<?= $baseUrl ?>/assets/js/<?= $script ?>?v=<?= time() ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>
