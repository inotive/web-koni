<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>KONI Tabalong - <?php echo $__env->yieldContent('title'); ?></title>

    <link rel="shortcut icon" href="<?php echo e(asset('assets/img/logo-koni-simplified.png')); ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    <link href="<?php echo e(asset('assets/plugins/global/plugins.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/custom-sidebar.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?php echo e(asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')); ?>" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo e(asset('assets/plugins/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">


    <?php echo $__env->yieldContent('style'); ?>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .bg-red {
            background-color: #ffcad7ff !important;
            font-weight: bold;
        }

        .bg-red-strong {
            background-color: #F8285A !important;
            font-weight: bold;
        }

        /* .justify {
            text-align: justify;
            line-height: 2rem;
        }

        .border-red {
            border-color: #F8285A !important;
        }

        .truncate {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }

        .text-orange {
            color: #F8285A !important;
        }

        .muted-hover:hover {
            color: #F8285A !important;
        }

        .percentage-option {
            transition: background-color 0.3s ease;
        }

        .percentage-option:hover {
            background-color: #FEF9EC;
        }

        .percentage-option.selected {
            background-color: #F8285A;
            color: white;
        }

        button:focus,
        button:active {
            box-shadow: none !important;
            outline: none !important;
        }

        .bootstrap-select .dropdown-toggle:focus,
        .bootstrap-select .dropdown-toggle:active,
        .bootstrap-select .dropdown-toggle {
            box-shadow: none !important;
            outline: none !important;
        }

        .container-fluid-limited {
            width: 100%;
            padding-right: var(--bs-gutter-x, 0.75rem);
            padding-left: var(--bs-gutter-x, 0.75rem);
            margin-right: auto;
            margin-left: auto;
            max-width: 1150px;
        }

        .ck.ck-content.ck-editor__editable {
            white-space: pre-wrap !important;
            word-break: break-word !important;
            min-width: 0 !important;
        }

        .col-12.w-100.mb-4 {
            max-width: 100%;
            overflow: hidden;
        } */
    </style>
    <?php echo $__env->yieldPushContent('stack-css'); ?>




</head>

<body id="kt_body" class="aside-enabled">
    <!--begin::Theme mode setup on page load-->
    
    <!--end::Theme mode setup on page load-->

    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div id="kt_wrapper" class="wrapper d-flex flex-column min-vh-100">
        <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <main class="flex-grow-1 overflow-auto py-4">
            <div class="container-fluid-limited mt-5">
                <div class="mb-5">
                    <h1 class="text-2xl font-semibold text-gray-800"><?php echo $__env->yieldContent('breadcrumb-title'); ?></h1>
                    <nav class="mt-1 text-sm" aria-label="Breadcrumb">
                        <ol class="flex space-x-2 text-gray-600">
                            <?php echo $__env->yieldContent('breadcrumb-items'); ?>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="px-10">
                <?php echo $__env->yieldContent('content'); ?>
            </div>

            <div id="scrolltop" class="scrolltop" data-kt-scrolltop="true">
                <i class="ki-duotone ki-arrow-up">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </main>

        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <!--begin::Scrolltop-->
    <!--end::Scrolltop-->
    <?php echo $__env->make('layouts.js-file', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php echo $__env->yieldPushContent('modal'); ?>
    <?php echo $__env->yieldContent('script'); ?>
    <?php echo $__env->yieldPushContent('stack-script'); ?>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();

            const content = document.querySelector('main');
            const scrollTopBtn = document.getElementById('scrolltop');

            content.addEventListener('scroll', () => {
                if (content.scrollTop > 300) {
                    scrollTopBtn.classList.add('show');
                } else {
                    scrollTopBtn.classList.remove('show');
                }
            });

            scrollTopBtn.addEventListener('click', () => {
                content.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
<?php /**PATH /Users/gustibagus/Documents/GitHub/web-koni/resources/views/layouts/app.blade.php ENDPATH**/ ?>