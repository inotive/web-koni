<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <link rel="icon" type="image/png" href="<?php echo e(asset('landing-assets/img/logo-white.png')); ?>">

    <title>Varia Niaga &mdash; Samarinda</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="<?php echo e(asset('landing-assets/css/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing-assets/css/style.css')); ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="<?php echo e(asset('landing-assets/js/script.js')); ?>"></script>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="font-jakarta-sans scroll-smooth">
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.layouts.navbar', ['isWhite' => true]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3922635410-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <main class="text-Gray-Primary">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.layouts.footer');

$__html = app('livewire')->mount($__name, $__params, 'lw-3922635410-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


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

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/components/layouts/white.blade.php ENDPATH**/ ?>