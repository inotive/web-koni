@extends('layouts.app')

@section('pageTitle', 'Pembinaan Prestasi')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang Bidang')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.index'))
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

    /* Enhanced controls container */
    .controls-container {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-container {
        position: relative;
        max-width: 280px;
        flex: 1;
    }

    .search-input {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 12px 20px 12px 45px; /* Fixed padding for icon space */
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        width: 100%;
    }

    .search-input:focus {
        border-color: #F8285A;
        box-shadow: 0 0 0 0.2rem rgba(248, 40, 90, 0.15);
        outline: none;
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
        z-index: 10;
    }

    /* Sort dropdown styling */
    .sort-dropdown {
        position: relative;
    }

    .sort-btn {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 0.95rem;
        color: #495057;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        min-width: 140px;
    }

    .sort-btn:hover {
        border-color: #F8285A;
        color: #F8285A;
    }

    .sort-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        min-width: 200px;
        margin-top: 4px;
        display: none;
        overflow: visible !important;
    }

    .sort-menu.show {
        display: block;
    }

    .sort-option {
        padding: 12px 16px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f8f9fa;
    }

    .sort-option:last-child {
        border-bottom: none;
    }

    .sort-option:hover {
        background-color: #f8f9fa;
    }

    .sort-option.active {
        background-color: #F8285A;
        color: white;
    }

    /* Grid layouts */
    .bidang-grid {
        display: grid;
        gap: 20px;
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    /* Default grid - 4 columns */
    .bidang-grid.grid-default {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }

    /* Large grid - 2 columns for few results */
    .bidang-grid.grid-large {
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    }

    /* Single result - centered */
    .bidang-grid.grid-single {
        grid-template-columns: 1fr;
        max-width: 500px;
        margin: 20px auto;
    }

    .bidang-card {
        background: white;
        border-radius: 16px;
        padding: 35px 30px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        position: relative;
        overflow: hidden;
    }

    .bidang-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(248, 40, 90, 0.05), transparent);
        transition: left 0.5s;
    }

    .bidang-card:hover::before {
        left: 100%;
    }

    .bidang-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
        text-decoration: none;
        color: inherit;
        border-color: #F8285A;
    }

    /* Fixed icon container - no upscaling */
    .bidang-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: all 0.3s ease;
    }

    /* Original size images - no quality loss */
    .bidang-icon img {
        width: 56px !important;
        height: 56px !important;
        object-fit: contain;
        transition: all 0.3s ease;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
    }

    .bidang-card:hover .bidang-icon img {
        transform: scale(1.05);
    }

    .bidang-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        line-height: 1.3;
        transition: color 0.3s ease;
    }

    .bidang-count {
        color: #6c757d;
        font-size: 0.95rem;
        margin: 0;
        font-weight: 500;
    }

    .bidang-card:hover .bidang-title {
        color: #F8285A;
    }

    /* Loading state */
    .bidang-grid.loading {
        opacity: 0.7;
        pointer-events: none;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .controls-container {
            flex-direction: column;
            align-items: stretch;
        }

        .search-container {
            max-width: none;
        }

        .bidang-grid.grid-default,
        .bidang-grid.grid-large {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .bidang-card {
            padding: 25px 20px;
        }

        .page-header h1 {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 576px) {
        .bidang-grid.grid-default,
        .bidang-grid.grid-large,
        .bidang-grid.grid-single {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <!-- Page Header -->
        <div>
            <strong><h1 class="fw-bold mb-1">Pembinaan Prestasi</h1></strong>
            <h3 class="text-muted mb-0">Beberapa Kategori Pembinaan Prestasi</h3>
        </div>

        <!-- Enhanced Search and Sort Controls -->
        <div class="controls-container">
            <!-- Search Container -->
            <div class="search-container">
                <input
                    type="text"
                    class="form-control search-input"
                    placeholder="Search Cabor..."
                    id="searchInput"
                >
                <i class="fas fa-search search-icon"></i>
            </div>

            <!-- Sort Dropdown -->
            {{-- <div class="sort-dropdown">
                <div class="sort-btn" id="sortBtn">
                    <i class="fas fa-sort"></i>
                    <span>Sort by</span>
                    <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                </div>
                <div class="sort-menu" id="sortMenu">
                    <div class="sort-option active" data-sort="default">
                        <span>Default Order</span>
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="sort-option" data-sort="name-asc">
                        <span>Name (A-Z)</span>
                        <i class="fas fa-sort-alpha-down"></i>
                    </div>
                    <div class="sort-option" data-sort="name-desc">
                        <span>Name (Z-A)</span>
                        <i class="fas fa-sort-alpha-up"></i>
                    </div>
                    <div class="sort-option" data-sort="docs-desc">
                        <span>Most Documents</span>
                        <i class="fas fa-sort-numeric-down"></i>
                    </div>
                    <div class="sort-option" data-sort="docs-asc">
                        <span>Least Documents</span>
                        <i class="fas fa-sort-numeric-up"></i>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

        <!-- Empty State (hidden by default) -->
        <div class="empty-state text-center py-5" id="emptyState" style="display: none;">
            <i class="fas fa-search fs-1 text-muted mb-3"></i>
            <h4 class="text-muted">Data tidak ditemukan</h4>
            <p class="text-muted mb-0">Tidak ada bidang cabang olahraga yang cocok dengan pencarian Anda</p>
        </div>

        <!-- Bidang Grid -->
        <div class="bidang-grid grid-default" id="bidangGrid">
            <!-- Cabor Terukur -->
            <a href="prestasi/cabor-terukur" class="bidang-card" data-title="mobilisasi sumberdaya" data-docs="13">
                <div class="bidang-icon icon-mobilisasi">
                    <img src="{{ asset('assets2/media/misc/bidang/timer.png') }}" alt="">
                </div>
                <h4 class="bidang-title">Cabor Terukur</h4>
                <p class="bidang-count">10 Olahraga</p>
            </a>

            <!-- Cabor Akurasi -->
            <a href="prestasi/cabor-akurasi" class="bidang-card" data-title="hubungan antar lembaga" data-docs="5">
                <div class="bidang-icon icon-hubungan">
                    <img src="{{ asset('assets2/media/misc/bidang/focus.png') }}" alt="">
                </div>
                <h4 class="bidang-title">Cabor Akurasi</h4>
                <p class="bidang-count">11 Olahraga</p>
            </a>

            <!-- Continue for other cards... -->
            <!-- Cabor Permainan -->
            <a href="prestasi/cabor-permainan" class="bidang-card" data-title="kesehatan" data-docs="15">
                <div class="bidang-icon icon-kesehatan">
                    <img src="{{ asset('assets2/media/misc/bidang/cup.png') }}" alt="">
                </div>
                <h4 class="bidang-title">Cabor Permainan</h4>
                <p class="bidang-count">12 Olahraga</p>
            </a>

            <!-- Cabor Beladiri -->
            <a href="prestasi/cabor-beladiri" class="bidang-card" data-title="organisasi" data-docs="0">
                <div class="bidang-icon icon-organisasi">
                    <img src="{{ asset('assets2/media/misc/bidang/courier-express.png') }}" alt="">
                </div>
                <h4 class="bidang-title">Cabor Beladiri</h4>
                <p class="bidang-count">13 Olahraga</p>
            </a>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function() {
    // let currentSort = 'default';

    // // Store original order for default sorting
    // const originalOrder = $('.bidang-card').toArray();

    // // Sort dropdown functionality
    // $('#sortBtn').on('click', function(e) {
    //     e.stopPropagation();
    //     $('#sortMenu').toggleClass('show');
    // });

    // // Close dropdown when clicking outside
    // $(document).on('click', function() {
    //     $('#sortMenu').removeClass('show');
    // });

    // // Sort option selection
    // $('.sort-option').on('click', function(e) {
    //     e.stopPropagation();

    //     const sortType = $(this).data('sort');
    //     if (sortType === currentSort) return;

    //     // Update active state
    //     $('.sort-option').removeClass('active');
    //     $(this).addClass('active');

    //     // Update button text
    //     const sortText = $(this).find('span').text();
    //     $('#sortBtn span').text(sortText);

    //     currentSort = sortType;
    //     sortCards(sortType);

    //     $('#sortMenu').removeClass('show');
    // });

    // // Sort function
    // function sortCards(sortType) {
    //     const $grid = $('#bidangGrid');
    //     const $cards = $('.bidang-card:visible');

    //     $grid.addClass('loading');

    //     let sortedCards;

    //     switch(sortType) {
    //         case 'name-asc':
    //             sortedCards = $cards.toArray().sort((a, b) => {
    //                 return $(a).find('.bidang-title').text().localeCompare($(b).find('.bidang-title').text());
    //             });
    //             break;

    //         case 'name-desc':
    //             sortedCards = $cards.toArray().sort((a, b) => {
    //                 return $(b).find('.bidang-title').text().localeCompare($(a).find('.bidang-title').text());
    //             });
    //             break;

    //         case 'docs-desc':
    //             sortedCards = $cards.toArray().sort((a, b) => {
    //                 const aCount = parseInt($(a).data('docs')) || 0;
    //                 const bCount = parseInt($(b).data('docs')) || 0;
    //                 return bCount - aCount;
    //             });
    //             break;

    //         case 'docs-asc':
    //             sortedCards = $cards.toArray().sort((a, b) => {
    //                 const aCount = parseInt($(a).data('docs')) || 0;
    //                 const bCount = parseInt($(b).data('docs')) || 0;
    //                 return aCount - bCount;
    //             });
    //             break;

    //         case 'default':
    //         default:
    //             sortedCards = originalOrder.filter(card => $(card).is(':visible'));
    //             break;
    //     }

    //     // Animate and reorder
    //     setTimeout(() => {
    //         $grid.empty().append(sortedCards);
    //         $grid.removeClass('loading');

    //         // Re-trigger any hover effects
    //         bindHoverEffects();
    //     }, 300);
    // }

    // Enhanced search functionality with grid layout changes
    $('#searchInput').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        let visibleCount = 0;
        const $grid = $('#bidangGrid');

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

        // Update grid layout based on results
        $grid.removeClass('grid-default grid-large grid-single');

        if (visibleCount === 0 && searchTerm.length > 0) {
            $('#emptyState').show();
            $('#bidangGrid').hide();
        } else {
            $('#emptyState').hide();
            $('#bidangGrid').show();

            // Apply appropriate grid class
            if (visibleCount === 1) {
                $grid.addClass('grid-single');
            } else if (visibleCount <= 3 && searchTerm.length > 0) {
                $grid.addClass('grid-large');
            } else {
                $grid.addClass('grid-default');
            }
        }

        // Re-sort if not default
        if (currentSort !== 'default') {
            sortCards(currentSort);
        }
    });

    // Bind hover effects
    function bindHoverEffects() {
        $('.bidang-card').off('mouseenter mouseleave').hover(
            function() {
                $(this).find('.bidang-icon').addClass('animate__animated animate__pulse');
            },
            function() {
                $(this).find('.bidang-icon').removeClass('animate__animated animate__pulse');
            }
        );
    }

    // Initialize hover effects
    bindHoverEffects();

    // Add smooth transitions for grid changes
    $('#bidangGrid').on('transitionend', function() {
        $(this).removeClass('loading');
    });

    // Keyboard shortcuts
    $(document).keydown(function(e) {
        // Focus search on Ctrl+F or Cmd+F
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 70) {
            e.preventDefault();
            $('#searchInput').focus();
        }

        // Clear search on Escape
        if (e.keyCode === 27) {
            $('#searchInput').val('').trigger('keyup');
            $('#searchInput').blur();
        }
    });
});
</script>
@endsection
