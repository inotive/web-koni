@extends('layouts.app')

@section('pageTitle', 'Bidang Bidang')
@section('mainSection', 'Laporan LPJ')
@section('currentSection', 'Bidang Bidang')

@section('content')

<style>
    body {
        background-color: #f5f5f5 !important;
    }

    .main-content {
        background-color: #f5f5f5;
        min-height: 100vh;
        padding: 20px 0;
    }

    .page-header {
        background-color: transparent;
        padding: 0;
        margin-bottom: 30px;
    }

    .page-header h2 {
        color: #2c3e50;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .page-subtitle {
        color: #6c757d;
        font-size: 1rem;
        margin-bottom: 0;
    }

    .action-buttons {
        margin-bottom: 30px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-box {
        max-width: 400px;
        position: relative;
    }

    .search-input {
        border: 1px solid #dee2e6;
        border-radius: 25px;
        padding: 12px 45px 12px 20px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .search-input:focus {
        border-color: #F8285A;
        box-shadow: 0 0 0 0.2rem rgba(248, 40, 90, 0.15);
        outline: none;
    }

    .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }

    .bidang-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .bidang-card {
        background: white;
        border-radius: 12px;
        padding: 30px 25px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .bidang-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        text-decoration: none;
        color: inherit;
    }

    .bidang-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        color: white !important;
        position: relative;
    }

    .bidang-icon i {
        color: white !important;
    }

    .icon-mobilisasi { background: #4285f4 !important; }
    .icon-hubungan { background: #db4437 !important; }
    .icon-kesehatan { background: #0f9d58 !important; }
    .icon-organisasi { background: #ff9800 !important; }
    .icon-hukum { background: #fdd835 !important; }
    .icon-prestasi { background: #e91e63 !important; }
    .icon-science { background: #00acc1 !important; }
    .icon-perencanaan { background: #7b1fa2 !important; }

    .bidang-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .bidang-count {
        color: #6c757d;
        font-size: 0.9rem;
        margin: 0;
    }

    .bidang-card:hover .bidang-title {
        color: #F8285A;
    }

    @media (max-width: 768px) {
        .bidang-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .bidang-card {
            padding: 25px 20px;
        }

        .page-header h2 {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 576px) {
        .bidang-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <!-- Page Header -->
            <div>
                <h2 class="fw-bold mb-1">Bidang Bidang</h2>
                <p class="text-muted mb-0">Jelajahi Bidang Bidang yang terdaftar</p>
            </div>

            <!-- Search Box -->
            <div class="position-relative" style="max-width: 250px;">
                <input
                    type="text"
                    class="form-control search-input"
                    placeholder="Search Teams..."
                    id="searchInput"
                >
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>

        <!-- Empty State (hidden by default) -->
        <div class="empty-state text-center py-5" id="emptyState" style="display: none;">
            <i class="fas fa-search fs-1 text-muted mb-3"></i>
            <h4 class="text-muted">Data tidak ditemukan</h4>
            <p class="text-muted mb-0">Tidak ada bidang yang cocok dengan pencarian Anda</p>
        </div>

        <!-- Bidang Grid -->
        <div class="bidang-grid" id="bidangGrid">
            <!-- Mobilisasi Sumberdaya -->
            <a href="{{ route('admin.laporan-lpj.bidang.mobilisasi-sumberdaya') }}" class="bidang-card" data-title="mobilisasi sumberdaya">
                <div class="bidang-icon icon-mobilisasi">
                    <i class="fas fa-building"></i>
                </div>
                <h4 class="bidang-title">Mobilisasi Sumberdaya...</h4>
                <p class="bidang-count">13 Dokumen</p>
            </a>

            <!-- Hubungan Antar Lembaga -->
            <a href="{{ route('admin.laporan-lpj.bidang.hubungan-antar-lembaga') }}" class="bidang-card" data-title="hubungan antar lembaga">
                <div class="bidang-icon icon-hubungan">
                    <i class="fas fa-handshake"></i>
                </div>
                <h4 class="bidang-title">Hubungan Antar Lemba...</h4>
                <p class="bidang-count">5 Dokumen</p>
            </a>

            <!-- Kesehatan -->
            <a href="{{ route('admin.laporan-lpj.bidang.kesehatan') }}" class="bidang-card" data-title="kesehatan">
                <div class="bidang-icon icon-kesehatan">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h4 class="bidang-title">Kesehatan</h4>
                <p class="bidang-count">15 Dokumen</p>
            </a>

            <!-- Organisasi -->
            <a href="{{ route('admin.laporan-lpj.bidang.organisasi') }}" class="bidang-card" data-title="organisasi">
                <div class="bidang-icon icon-organisasi">
                    <i class="fas fa-sitemap"></i>
                </div>
                <h4 class="bidang-title">Organisasi</h4>
                <p class="bidang-count">5 Days Ago</p>
            </a>

            <!-- Pembinaan Hukum Olahraga -->
            <a href="{{ route('admin.laporan-lpj.bidang.pembinaan-hukum') }}" class="bidang-card" data-title="pembinaan hukum olahraga">
                <div class="bidang-icon icon-hukum">
                    <i class="fas fa-gavel"></i>
                </div>
                <h4 class="bidang-title">Pembinaan Hukum Olah...</h4>
                <p class="bidang-count">9 Dokumen</p>
            </a>

            <!-- Pembinaan Prestasi -->
            <a href="{{ route('admin.laporan-lpj.bidang.prestasi.index') }}" class="bidang-card" data-title="pembinaan prestasi">
                <div class="bidang-icon icon-prestasi">
                    <i class="fas fa-trophy"></i>
                </div>
                <h4 class="bidang-title">Pembinaan Prestasi</h4>
                <p class="bidang-count">48 Cabang Olahraga</p>
            </a>

            <!-- Sport Science & Iptek -->
            <a href="{{ route('admin.laporan-lpj.bidang.sport-science') }}" class="bidang-card" data-title="sport science iptek">
                <div class="bidang-icon icon-science">
                    <i class="fas fa-flask"></i>
                </div>
                <h4 class="bidang-title">Sport Science & Iptek</h4>
                <p class="bidang-count">10 Dokumen</p>
            </a>

            <!-- Perencanaan Program dan Anggaran -->
            <a href="{{ route('admin.laporan-lpj.bidang.perencanaan-program') }}" class="bidang-card" data-title="perencanaan program anggaran">
                <div class="bidang-icon icon-perencanaan">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h4 class="bidang-title">Perencanaan Program d...</h4>
                <p class="bidang-count">35 Dokumen</p>
            </a>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Search functionality
        $('#searchInput').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            let visibleCount = 0;

            $('.bidang-card').each(function() {
                const title = $(this).data('title').toLowerCase();
                const cardTitle = $(this).find('.bidang-title').text().toLowerCase();

                if (title.includes(searchTerm) || cardTitle.includes(searchTerm)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            // Show/hide empty state
            if (visibleCount === 0 && searchTerm.length > 0) {
                $('#emptyState').show();
                $('#bidangGrid').hide();
            } else {
                $('#emptyState').hide();
                $('#bidangGrid').show();
            }
        });

        // Add hover effects
        $('.bidang-card').hover(
            function() {
                $(this).find('.bidang-icon').addClass('animate__animated animate__pulse');
            },
            function() {
                $(this).find('.bidang-icon').removeClass('animate__animated animate__pulse');
            }
        );
    });
</script>
@endsection
