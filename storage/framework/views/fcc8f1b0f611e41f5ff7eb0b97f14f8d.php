<?php $__env->startSection('pageTitle', 'Rencana Kegiatan Anggaran'); ?>
<?php $__env->startSection('mainSection', 'Menu Utama'); ?>
<?php $__env->startSection('currentSection', 'Manajemen RKA'); ?>
<?php $__env->startSection('style'); ?>
    <style>
        /* Match page background with Bendahara/Surat/File Kesekretariat */
        body {
            background-color: #f5f5f5;
        }

        main.flex-grow-1 {
            background-color: #f5f5f5 !important;
        }

        .edit:hover {
            background-color: rgb(249, 245, 172) !important;
        }

        .delete:hover {
            background-color: #ffcad7ff !important;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-grid gap-5 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-none d-md-block">
                                <h1>Manajemen RKA</h1>
                                <span>Pemusatan Rencana Kegiatan Anggaran</span>
                            </div>
                        </div>

                        <div id="table" class="">
                            <?php echo $__env->make('admin.manajemen-rka.components.table-grid', compact('data'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>

                        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 gap-5 px-10 py-8">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="fs-2 fw-bold leading-5">Tambah Folder RKA</div>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form id="formAdd" action="<?php echo e(route('admin.manajemen-rka.store')); ?>" method="POST"
                                        class="d-grid gap-2">
                                        <?php echo csrf_field(); ?>
                                        <div class="fs-4 fw-bold">Tahun RKA</div>
                                        <input id="judul" name="judul" type="number" class="form-control border border-gray-600"
                                            placeholder="Masukkan tahun RKA" />
                                    </form>

                                    <div class="d-grid py-4">
                                        <button type="button" onclick="submitForm('formAdd')"
                                            class="bg-danger fw-bold d-flex align-items-center justify-content-center gap-2 rounded border-0 p-4 text-white">
                                            Tambah Folder
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        function submitForm(formId) {
            let form = document.getElementById(formId);
            let formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    },
                    body: formData,
                })
                .then(async response => {
                    const data = await response.json();

                    if (!response.ok) {

                        console.log('Error response from controller:', data);

                        if (data.errors) {
                            for (let field in data.errors) {
                                let msg = data.errors[field].join(', ');
                                toastr.error(msg, "Error!");
                            }
                        } else {
                            toastr.error("Gagal menyimpan data", "Error!");
                        }

                        return;
                    } else {
                        $('.modal.show').modal('hide');
                        window.location.reload();
                        reloadTable();

                        form.reset();
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    toastr.error("Terjadi kesalahan. Silakan coba lagi.", "Error!");
                });
        }

        function reloadTable(url = null) {
            let formData = $('#filter').serialize();
            let target = url ?? "<?php echo e(route('admin.manajemen-rka.index')); ?>";

            $.ajax({
                url: target,
                data: formData,
                beforeSend: function() {
                    $('#table').html(
                        '<div class="py-20 text-center"><span class="spinner-border text-danger"></span></div>'
                    );
                },
                success: function(response) {
                    $('#table').html(response);
                },
                error: function(xhr) {
                    $('#table').html(
                        '<div class="py-20 text-center text-danger fw-bold">Terjadi kesalahan saat memuat data.</div>'
                    );
                }
            });
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

        function confirmDelete(url, name = 'item ini') {
            Swal.fire({
                title: "Apakah Anda Yakin?",
                html: `Hapus RKA <strong>${name}</strong>?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Berhasil!", data.message, "success");
                                // Refresh tabel atau hapus baris
                                setTimeout(() => location.reload(), 1500);
                            } else {
                                Swal.fire("Gagal!", data.message, "error");
                            }
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Terjadi kesalahan pada server.", "error");
                        });
                }
            });
        }

        $(document).ready(function() {
            $(document).on('input', '#filter input[name="search"]', debounce(function() {
                let keyword = $(this).val();
                if (keyword.length >= 1 || keyword.length === 0) {
                    reloadTable();
                }
            }, 300));

            $(document).on('change', '#sortBy', function() {
                reloadTable();
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Inotive\KONI\web-koni\resources\views/admin/manajemen-rka/index.blade.php ENDPATH**/ ?>