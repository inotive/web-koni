{{-- Style & script bersama untuk halaman modul arsip --}}
@push('stack-css')
    <style>
        .arsip-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .arsip-stat {
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            height: 100%;
        }

        .arsip-stat .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .arsip-table th {
            font-weight: 600;
            color: #5e6278;
            text-transform: uppercase;
            font-size: .75rem;
            white-space: nowrap;
        }

        .arsip-table td {
            vertical-align: middle;
        }

        .arsip-kode {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: .85rem;
            background: #f5f8fa;
            border-radius: 4px;
            padding: 1px 6px;
            white-space: nowrap;
        }

        .arsip-tabs .nav-link {
            color: #5e6278;
            font-weight: 600;
        }

        .arsip-tabs .nav-link.active {
            color: #1F6B5A;
            border-bottom: 2px solid #1F6B5A;
        }
    </style>
@endpush

@push('stack-script')
    <script>
        // Konfirmasi untuk form yang memiliki atribut data-confirm
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (!form.dataset.confirm || form.dataset.confirmed) return;
            e.preventDefault();
            Swal.fire({
                text: form.dataset.confirm,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-light'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.dataset.confirmed = '1';
                    form.submit();
                }
            });
        });
    </script>
@endpush
