
<div id="kt_header" class="header align-items-stretch">
    <!--begin::Brand-->
    <div class="d-flex justify-content-between bg-white px-5 py-2">
        <!--begin::Logo-->
        <div class="d-flex align-items-center gap-3 px-4" style="width:220px; min-width:180px">
            <a href="/" class="d-flex align-items-center">
                <img alt="Logo" src="<?php echo e(asset('assets/img/koni.png')); ?>" class="h-60px" />
            </a>
        </div>
        <!--end::Logo-->
        <!--begin::Aside toggle-->
        <div class="d-flex align-items-center d-lg-none me-n2" title="Show aside menu">
            <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <!--end::Aside toggle-->
    </div>
    <!--end::Brand-->
    <!--begin::Toolbar-->
    <div class="toolbar d-flex align-items-stretch position-relative">
        <!--begin::Toolbar container-->
        <div class="app-container container-fluid d-flex align-items-stretch justify-content-between">
            <!--begin::Page title-->
            <div class="page-title d-flex align-items-center justify-content-start me-5">
                <!--begin::Text Content-->
                <div class="d-flex flex-column mx-2">
                    <!--begin::Title-->
                    <h1 class="fw-bold fs-3 mb-0" style="color: #F8285A;">
                        <?php echo $__env->yieldContent('pageTitle'); ?>
                    </h1>

                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-separatorless fs-7 fw-semibold">
                            
                            <li class="breadcrumb-item mx-0 px-0">
                                <?php if(View::hasSection('mainSectionUrl')): ?>
                                    <a href="<?php echo $__env->yieldContent('mainSectionUrl'); ?>" class="text-muted text-hover-primary">
                                        <?php echo $__env->yieldContent('mainSection'); ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo $__env->yieldContent('mainSection'); ?></span>
                                <?php endif; ?>
                            </li>

                            
                            <i class="ki-duotone ki-right text-muted mx-1 px-0"></i>

                            
                            <?php if (! empty(trim($__env->yieldContent('subSection')))): ?>
                                <li class="breadcrumb-item mx-0 px-0">
                                    <?php if(View::hasSection('subSectionUrl')): ?>
                                        <a href="<?php echo $__env->yieldContent('subSectionUrl'); ?>" class="text-muted text-hover-primary">
                                            <?php echo $__env->yieldContent('subSection'); ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted"><?php echo $__env->yieldContent('subSection'); ?></span>
                                    <?php endif; ?>
                                </li>
                                <i class="ki-duotone ki-right text-muted mx-1 px-0"></i>
                            <?php endif; ?>

                            <?php if (! empty(trim($__env->yieldContent('subSection2')))): ?>
                                <li class="breadcrumb-item mx-0 px-0">
                                    <?php if(View::hasSection('subSection2Url')): ?>
                                        <a href="<?php echo $__env->yieldContent('subSection2Url'); ?>" class="text-muted text-hover-primary">
                                            <?php echo $__env->yieldContent('subSection2'); ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted"><?php echo $__env->yieldContent('subSection2'); ?></span>
                                    <?php endif; ?>
                                </li>
                                <i class="ki-duotone ki-right text-muted mx-1 px-0"></i>
                            <?php endif; ?>

                            <?php if (! empty(trim($__env->yieldContent('subSection3')))): ?>
                                <li class="breadcrumb-item mx-0 px-0">
                                    <?php if(View::hasSection('subSection3Url')): ?>
                                        <a href="<?php echo $__env->yieldContent('subSection3Url'); ?>" class="text-muted text-hover-primary">
                                            <?php echo $__env->yieldContent('subSection3'); ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted"><?php echo $__env->yieldContent('subSection3'); ?></span>
                                    <?php endif; ?>
                                </li>
                                <i class="ki-duotone ki-right text-muted mx-1 px-0"></i>
                            <?php endif; ?>

                            <?php if (! empty(trim($__env->yieldContent('subSection4')))): ?>
                                <li class="breadcrumb-item mx-0 px-0">
                                    <?php if(View::hasSection('subSection4Url')): ?>
                                        <a href="<?php echo $__env->yieldContent('subSection4Url'); ?>" class="text-muted text-hover-primary">
                                            <?php echo $__env->yieldContent('subSection4'); ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted"><?php echo $__env->yieldContent('subSection4'); ?></span>
                                    <?php endif; ?>
                                </li>
                                <i class="ki-duotone ki-right text-muted mx-1 px-0"></i>
                            <?php endif; ?>

                            
                            <li class="breadcrumb-item active mx-0 px-0" aria-current="page">
                                <span style="color: #071437; font-weight: 500;"><?php echo $__env->yieldContent('currentSection'); ?></span>
                            </li>
                        </ol>
                    </nav>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Text Content-->
            </div>
            <!--end::Page title-->
            <!--begin::Action group-->
            <div class="d-flex align-items-stretch pt-lg-0 overflow-auto pt-3">
                <!-- Your existing Action group content here -->
            </div>
            <!--end::Action group-->
        </div>
        <!--end::Toolbar container-->
    </div>

    
    <div class="aside-user d-none d-lg-flex align-items-center justify-content-end p-5" style="border: none;">
        <!--begin::Wrapper-->
        <div class="aside-user-info flex-row-fluid ms-5 flex-wrap">
            <!--begin::Section-->
            <div class="d-flex">
                <!--begin::Info-->
                <div class="flex-grow-1 me-2">
                    <!--begin::Username-->
                    <!--begin::Username-->
                    <span class="fs-8 fw-bold text-capitalize text-gray-600"><?php echo e(Auth::user()->username); ?></span>
                    <!--end::Username-->
                    <!--begin::Description-->
                    <span class="fw-semibold d-block fs-8 text-capitalize mb-1 text-gray-400">
                        <?php echo e(Auth::user()->roles()->first()->name); ?>

                    </span>
                    <!--end::Description-->

                    <!--end::Description-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Section-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Symbol-->
        <!--begin::User symbol + trigger-->
        <a href="#" class="symbol symbol-35px symbol-circle mt-n2" data-kt-menu-trigger="click"
            data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
            <?php if(Auth::user()->foto): ?>
                <img src="<?php echo e(asset('/storage/' . Auth::user()->foto)); ?>" alt="User foto" class="symbol-label" />
            <?php else: ?>
                <?php
                    $initial = strtoupper(substr(Auth::user()->username, 0, 1));
                ?>
                <div class="symbol-label fs-2 fw-semibold bg-primary text-inverse-danger"><?php echo e($initial); ?></div>
            <?php endif; ?>
        </a>
        <!--end::User symbol-->

        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold fs-6 w-275px py-4"
            data-kt-menu="true">
            <!--begin::Menu item-->
            
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="<?php echo e(route('logout')); ?>" class="menu-link d-flex align-items-center text-capitalize gap-2 px-5">
                    <i class="fa-solid fa-arrow-right-from-bracket fs-5"></i>
                    <span>Sign Out</span>
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::User account menu-->
        <!--end::Symbol-->
    </div>
    <!--end::Toolbar-->
</div>

<style>
    /* Breadcrumb Navigation Styles */
    .breadcrumb a {
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .breadcrumb a:hover {
        color: #071437 !important;
    }

    .breadcrumb-item.active span {
        color: #071437 !important;
    }

    .breadcrumb-item:not(.active) a {
        cursor: pointer;
    }
</style>
<?php /**PATH /Users/gustibagus/Documents/GitHub/web-koni/resources/views/layouts/header.blade.php ENDPATH**/ ?>