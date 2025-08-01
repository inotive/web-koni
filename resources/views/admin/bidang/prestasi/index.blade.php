@extends('layouts.app')

@section('pageTitle', 'Pembinaan Prestasi')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang Bidang')
@section('subSectionUrl', route('admin.bidang.index') )
@section('currentSection', 'Pembinaan Prestasi')

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

    .btn-grid {
        background: #007bff;
        border: none;
        border-radius: 6px;
        padding: 8px 12px;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-grid:hover {
        background: #0056b3;
        color: white;
    }

    .btn-list {
        background: #6c757d;
        border: none;
        border-radius: 6px;
        padding: 8px 12px;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-list:hover {
        background: #545b62;
        color: white;
    }

    .btn-grid.active {
        background: #007bff;
    }

    .btn-list.active {
        background: #007bff;
    }

    .search-container {
        margin-bottom: 30px;
    }

    .search-box {
        max-width: 400px;
        position: relative;
    }

    .search-input {
        border: 1px solid #dee2e6;
        border-radius: 25px;
        padding: 12px 45px 12px 20px; /* LEFT: space for text, RIGHT: space for icon */
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
        font-size: 1rem;
    }

    .search-wrapper {
        position: relative;
        display: inline-block;
    }

    .search-wrapper input {
        padding: 10px 40px 10px 16px;
        border-radius: 50px;
        border: 1px solid #ddd;
        outline: none;
        font-size: 14px;
    }

    .search-wrapper input:focus{
        border-color: #F8285A;
        box-shadow: 0 0 0 0.2rem rgba(248, 40, 90, 0.15);
        outline: none;
    }

    .search-wrapper i {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        pointer-events: none;
    }

    .cabor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .cabor-card {
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

    .cabor-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        text-decoration: none;
        color: inherit;
    }

    .cabor-icon {
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

    .cabor-icon i {
        color: white !important;
    }

    .icon-terukur { background: #9e9e9e !important; }
    .icon-akurasi { background: #f44336 !important; }
    .icon-permainan { background: #ffeb3b !important; }
    .icon-beladiri { background: #4caf50 !important; }

    .cabor-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .cabor-count {
        color: #6c757d;
        font-size: 0.9rem;
        margin: 0;
    }

    .cabor-card:hover .cabor-title {
        color: #F8285A;
    }

    @media (max-width: 768px) {
        .cabor-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .cabor-card {
            padding: 25px 20px;
        }

        .page-header h2 {
            font-size: 1.6rem;
        }

        .action-buttons {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .cabor-grid {
            grid-template-columns: 1fr;
        }
    }

    .position-relative i.fa-search {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        pointer-events: none;
        color: #6c757d; /* Muted text color */
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <!-- Title & Subtitle -->
        <div>
            <h2 class="fw-bold mb-1">Pembinaan Prestasi</h2>
            <p class="text-muted mb-0">Beberapa Kategori Pembinaan Prestasi</p>
        </div>

        <!-- Buttons + Search -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- View Toggle Buttons -->
            <button class="btn btn-grid active" id="gridView">
                <i class="fas fa-th"></i>
            </button>
            <button class="btn btn-list" id="listView">
                <i class="fas fa-list"></i>
            </button>

            <!-- Search Box -->
            <div class="search-wrapper">
                <input type="text" placeholder="Search Teams..." />
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>



        <!-- Empty State (hidden by default) -->
        <div class="empty-state text-center py-5" id="emptyState" style="display: none;">
            <i class="fas fa-search fs-1 text-muted mb-3"></i>
            <h4 class="text-muted">Data tidak ditemukan</h4>
            <p class="text-muted mb-0">Tidak ada cabang olahraga yang cocok dengan pencarian Anda</p>
        </div>

        <!-- Cabor Grid -->
        <div class="cabor-grid" id="caborGrid">
            <!-- Cabor Terukur -->
            <a href="#" class="cabor-card" data-title="cabor terukur">
                <div class="cabor-icon icon-terukur">
                    <i class="fas fa-ruler-combined"></i>
                </div>
                <h4 class="cabor-title">Cabor Terukur</h4>
                <p class="cabor-count">10 Olahraga</p>
            </a>

            <!-- Cabor Akurasi -->
            <a href="#" class="cabor-card" data-title="cabor akurasi">
                <div class="cabor-icon icon-akurasi">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h4 class="cabor-title">Cabor Akurasi</h4>
                <p class="cabor-count">11 Olahraga</p>
            </a>

            <!-- Cabor Permainan -->
            <a href="#" class="cabor-card" data-title="cabor permainan">
                <div class="cabor-icon icon-permainan">
                    <i class="fas fa-trophy"></i>
                </div>
                <h4 class="cabor-title">Cabor Permainan</h4>
                <p class="cabor-count">14 Olahraga</p>
            </a>

            <!-- Cabor Beladiri -->
            <a href="#" class="cabor-card" data-title="cabor beladiri">
                <div class="cabor-icon icon-beladiri">
                    <i class="fas fa-fist-raised"></i>
                </div>
                <h4 class="cabor-title">Cabor Beladiri</h4>
                <p class="cabor-count">13 Olahraga</p>
            </a>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        // View toggle functionality
        $('#gridView').on('click', function() {
            $(this).addClass('active');
            $('#listView').removeClass('active');
            $('#caborGrid').removeClass('list-view').addClass('grid-view');
        });

        $('#listView').on('click', function() {
            $(this).addClass('active');
            $('#gridView').removeClass('active');
            $('#caborGrid').removeClass('grid-view').addClass('list-view');
        });

        // Search functionality
        $('#searchInput').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            let visibleCount = 0;

            $('.cabor-card').each(function() {
                const title = $(this).data('title').toLowerCase();
                const cardTitle = $(this).find('.cabor-title').text().toLowerCase();

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
                $('#caborGrid').hide();
            } else {
                $('#emptyState').hide();
                $('#caborGrid').show();
            }
        });

        // Add hover effects
        $('.cabor-card').hover(
            function() {
                $(this).find('.cabor-icon').addClass('animate__animated animate__pulse');
            },
            function() {
                $(this).find('.cabor-icon').removeClass('animate__animated animate__pulse');
            }
        );
    });
</script>
@endsection
