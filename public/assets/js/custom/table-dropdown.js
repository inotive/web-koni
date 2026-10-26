/**
 * Menu aksi di dalam tabel sering terpotong oleh wadah tabel yang memakai overflow
 * (.table-responsive / overflow-x:auto). Script ini membuat menu aksi tampil di atas
 * semua komponen dengan posisi fixed terhadap layar.
 */
(function () {
    'use strict';

    // 1. Dropdown Bootstrap: pakai strategi "fixed" agar tidak terpotong wadah tabel
    if (window.bootstrap && bootstrap.Dropdown && bootstrap.Dropdown.Default) {
        bootstrap.Dropdown.Default.popperConfig = function (config) {
            return Object.assign({}, config, { strategy: 'fixed' });
        };
    }

    // 2. Dropdown aksi custom (.dropdown-menu-custom yang dibuka dengan class "show")
    var GAP = 5;
    var MARGIN = 8;

    function findToggle(menu) {
        var wrapper = menu.closest('.dropdown-action, .dropdown');
        return wrapper ? wrapper.querySelector('.dropdown-toggle-custom') : menu.previousElementSibling;
    }

    function setStyle(menu, prop, value) {
        menu.style.setProperty(prop, value, 'important');
    }

    function placeMenu(menu) {
        var toggle = findToggle(menu);
        if (!toggle) {
            return;
        }

        var rect = toggle.getBoundingClientRect();

        setStyle(menu, 'position', 'fixed');
        setStyle(menu, 'margin', '0');
        setStyle(menu, 'right', 'auto');
        setStyle(menu, 'bottom', 'auto');
        setStyle(menu, 'transform', 'none');
        setStyle(menu, 'z-index', '1060');

        var width = menu.offsetWidth;
        var height = menu.offsetHeight;

        // Rata kanan dengan tombol, tetapi tetap di dalam layar
        var left = Math.min(rect.right - width, window.innerWidth - width - MARGIN);
        left = Math.max(MARGIN, left);

        // Buka ke bawah, atau ke atas jika ruang di bawah tidak cukup
        var top = rect.bottom + GAP;
        if (top + height > window.innerHeight - MARGIN && rect.top - GAP - height > MARGIN) {
            top = rect.top - GAP - height;
        }

        setStyle(menu, 'left', left + 'px');
        setStyle(menu, 'top', top + 'px');
    }

    function resetMenu(menu) {
        ['position', 'margin', 'right', 'bottom', 'transform', 'z-index', 'left', 'top'].forEach(function (prop) {
            menu.style.removeProperty(prop);
        });
    }

    function openMenus() {
        return document.querySelectorAll('.dropdown-menu-custom.show');
    }

    new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            var menu = mutation.target;
            if (!menu.classList || !menu.classList.contains('dropdown-menu-custom')) {
                return;
            }
            if (menu.classList.contains('show')) {
                placeMenu(menu);
            } else {
                resetMenu(menu);
            }
        });
    }).observe(document.body, { attributes: true, attributeFilter: ['class'], subtree: true });

    function repositionAll() {
        openMenus().forEach(placeMenu);
    }

    window.addEventListener('resize', repositionAll);
    // capture: ikut menangkap scroll di dalam wadah tabel
    window.addEventListener('scroll', repositionAll, true);
})();
