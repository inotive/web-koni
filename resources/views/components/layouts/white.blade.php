<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <link rel="icon" type="image/png" href="{{ asset('landing-assets/img/logo-white.png') }}">

    <title>Varia Niaga &mdash; Samarinda</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="{{ asset('landing-assets/css/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing-assets/css/style.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="{{ asset('landing-assets/js/script.js') }}"></script>

    @livewireStyles

    @stack('styles')
</head>

<body class="font-jakarta-sans scroll-smooth">
    @livewire('components.layouts.navbar', ['isWhite' => true])

    <main class="text-Gray-Primary">
        @yield('content')
    </main>

    @livewire('components.layouts.footer')

    @livewireScripts()

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        function openModal(selector) {
            const modal = document.getElementById(selector);

            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function setupDropdown(triggerSelector, dropdownSelector) {
            const trigger = document.querySelector(triggerSelector);
            const dropdown = document.querySelector(dropdownSelector);

            if (trigger && dropdown) {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!trigger.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupDropdown('.service-dropdown', '#service-dropdown');
            setupDropdown('.media-dropdown', '#media-dropdown');
            setupDropdown('.language-dropdown', '#language-dropdown');

            setupDropdown('.service-dropdown-mobile', '#service-dropdown-mobile');
            setupDropdown('.media-dropdown-mobile', '#media-dropdown-mobile');
            setupDropdown('.language-dropdown-mobile', '#language-dropdown-mobile');
        });

        new Swiper('#projects', {
            loop: true,
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 16,
                },
                992: {
                    slidesPerView: 3.5,
                    spaceBetween: 24,
                },
                1440: {
                    slidesPerView: 4.8,
                    spaceBetween: 24,
                },
            },
        });

        new Swiper('#news', {
            loop: true,
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 16,
                },
                992: {
                    slidesPerView: 3.5,
                    spaceBetween: 24,
                },
                1440: {
                    slidesPerView: 4.8,
                    spaceBetween: 24,
                },
            },
        });

        new Swiper('#news-mobile', {
            loop: true,
            slidesPerView: 2.2,
            spaceBetween: 16,
        });

        new Swiper('#images', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 16,
            pagination: {
                el: ".swiper-pagination",
            },
        });
    </script>

    <script>
        window.addEventListener('refreshPage', event => {
            window.location.reload(false);
        })
    </script>

    @stack('scripts')
</body>

</html>
