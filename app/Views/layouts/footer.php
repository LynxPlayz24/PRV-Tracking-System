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
    // altInput shows dd/mm/yyyy; hidden original input submits yyyy-mm-dd to server.
    function parseDateStr(str) {
        if (!str) return null;
        str = str.trim();
        // yyyy-mm-dd or yyyy/mm/dd
        var m = str.match(/^(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})$/);
        if (m) return new Date(+m[1], +m[2] - 1, +m[3]);
        // dd/mm/yyyy or dd-mm-yyyy
        m = str.match(/^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})$/);
        if (m) return new Date(+m[3], +m[2] - 1, +m[1]);
        return null;
    }
    function padZ(n) { return n < 10 ? '0' + n : '' + n; }

    function initFlatpickr(scope) {
        var root = scope || document;
        root.querySelectorAll('input[type="date"]:not(.flatpickr-input)').forEach(function(el) {
            flatpickr(el, {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd/m/Y',
                allowInput: true,
                altInputClass: 'form-control flatpickr-input',
                parseDate: function(dateStr, format) {
                    return parseDateStr(dateStr);
                },
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.altInput) {
                        instance.altInput.setAttribute('placeholder', 'dd/mm/yyyy');
                    }
                }
            });
        });
    }

    // Before any form submits, sync manually-typed altInput values back to the
    // hidden original input (Y-m-d) so the server always receives a valid date.
    document.addEventListener('DOMContentLoaded', function() {
        initFlatpickr();

        document.addEventListener('submit', function(e) {
            var form = e.target;
            if (!form || form.tagName !== 'FORM') return;
            form.querySelectorAll('input[type="date"].flatpickr-input').forEach(function(hiddenEl) {
                var fp = hiddenEl._flatpickr;
                if (!fp) return;
                var altEl = fp.altInput;
                if (!altEl) return;
                var typed = altEl.value.trim();
                if (!typed) {
                    hiddenEl.value = '';
                    return;
                }
                // If flatpickr already parsed it, selectedDates[0] is reliable
                if (fp.selectedDates && fp.selectedDates.length > 0) {
                    var d = fp.selectedDates[0];
                    hiddenEl.value = d.getFullYear() + '-' + padZ(d.getMonth() + 1) + '-' + padZ(d.getDate());
                } else {
                    // Try manual parse (covers typed dd/mm/yyyy)
                    var parsed = parseDateStr(typed);
                    if (parsed && !isNaN(parsed.getTime())) {
                        hiddenEl.value = parsed.getFullYear() + '-' + padZ(parsed.getMonth() + 1) + '-' + padZ(parsed.getDate());
                        fp.setDate(parsed, false);
                    } else {
                        hiddenEl.value = '';
                    }
                }
            });
        }, true); // capture phase so it runs before form submission
    });
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
