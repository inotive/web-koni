<?php $__env->startSection('pageTitle', 'Cabor Beladiri'); ?>
<?php $__env->startSection('mainSection', 'Laporan LPJ'); ?>
<?php $__env->startSection('subSection', 'Bidang Bidang'); ?>
<?php $__env->startSection('subSectionUrl', route('admin.laporan-lpj.bidang.index')); ?>
<?php $__env->startSection('subSection2', 'Pembinaan Prestasi'); ?>
<?php $__env->startSection('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index')); ?>
<?php $__env->startSection('currentSection', 'Cabor Beladiri'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-grid gap-5 border-0">
        <div class="d-flex justify-content-between align-items-center container">
            <div class="d-none d-md-block">
                <h1>Cabor Beladiri</h1>
                <span>Informasi Cabor Beladiri</span>
            </div>
            <form id="filter" class="d-flex gap-3">
                <div class="position-relative bg-light" style="width: 180px">
                    <i class="ki-outline ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-3"></i>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" data-kt-docs-table-filter="search"
                        placeholder="Cari Teams" class="form-control border border-gray-500 py-2 ps-12" />
                </div>
                
            </form>
        </div>

        

        <div id="table" class="container">
            <?php echo $__env->make('admin.laporan-lpj.bidang.prestasi.Beladiri._table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        function filterAndSort() {
            const searchValue = $('input[name="search"]').val().toLowerCase();
            const sortBy = $('#sortBy').val();
            const $folders = $('#table .row .col-12, #table .row .col-sm-6, #table .row .col-md-3');

            // Filter folders
            let visibleFolders = [];
            $folders.each(function() {
                const $folder = $(this);
                const folderName = $folder.find('h5').text().toLowerCase();

                if (folderName.includes(searchValue)) {
                    $folder.show();
                    visibleFolders.push($folder);
                } else {
                    $folder.hide();
                }
            });

            // Sort visible folders
            visibleFolders.sort(function(a, b) {
                const nameA = $(a).find('h5').text().toLowerCase();
                const nameB = $(b).find('h5').text().toLowerCase();

                if (sortBy === 'ASC') {
                    return nameA.localeCompare(nameB);
                } else {
                    return nameB.localeCompare(nameA);
                }
            });

            // Reorder folders in the DOM
            const $container = $('#table .row');
            visibleFolders.forEach(function($folder) {
                $container.append($folder);
            });

            // Show "no results" message if no folders match
            if (visibleFolders.length === 0 && searchValue !== '') {
                if ($('#no-results').length === 0) {
                    $container.append(`
                        <div id="no-results" class="col-12 text-center py-5">
                            <div class="text-muted">
                                <i class="ki-outline ki-file-search" style="font-size: 48px;"></i>
                                <h4>Tidak ditemukan hasil</h4>
                                <p>Coba kata kunci lain untuk pencarian</p>
                            </div>
                        </div>
                    `);
                }
            } else {
                $('#no-results').remove();
            }
        }

        function debounce(func, delay) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        $(document).ready(function() {
            // Search functionality
            $(document).on('input', '#filter input[name="search"]', debounce(function() {
                filterAndSort();
            }, 300));

            // Sort functionality
            $(document).on('change', '#sortBy', function() {
                filterAndSort();
            });

            // Initial sort
            filterAndSort();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/thur/Documents/Inotive/web-koni/resources/views/admin/laporan-lpj/bidang/prestasi/Beladiri/index.blade.php ENDPATH**/ ?>