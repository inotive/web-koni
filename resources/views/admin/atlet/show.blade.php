@extends('layouts.app')

@section('pageTitle', 'Detail Atlet')
@section('mainSection', 'Konfigurasi')
@section('subSection', 'Atlet')
@section('subSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('currentSection', 'Detail Atlet')
<h1 class="text-dark fw-bold fs-3 mb-0">Detail Atlet</h1>

@section('content')
<style>
    /* Base Layout */
    body {
        background-color: #f5f5f5 !important;
    }

    .main-content {
        background-color: #f5f5f5;
        min-height: 100vh;
        padding: 20px 10px 40px;
    }

    .detail-container {
        gap: 30px;
        width: 100%;
        display: flex;
        padding: 0 20px 20px;
        position: relative;
        max-width: 1067px;
        margin: 0 auto;
        box-sizing: border-box;
        align-items: center;
        flex-direction: column;
        justify-content: center;
    }

    /* Headers */
    .detail-header {
        width: 100%;
        max-width: 987px;
        box-sizing: border-box;
        gap: 8px;
        display: flex;
        position: relative;
        align-items: flex-start;
        flex-direction: column;
        justify-content: flex-start;
    }

    .detail-title {
        width: 100%;
        margin: 0;
        text-align: left;
        color: #071437;
        font-size: 20px;
        font-style: normal;
        font-family: "Inter", sans-serif;
        font-weight: 600;
        line-height: 20px;
        letter-spacing: 0;
    }

    /* Cards */
    .detail-card {
        width: 100%;
        display: flex;
        position: relative;
        max-width: 987px;
        box-sizing: border-box;
        gap: 20px;
        border: 1px solid #f1f1f4;
        box-shadow: 0 3px 4px 0 rgba(0, 0, 0, 0.03);
        align-items: flex-start;
        border-radius: 12px;
        flex-direction: column;
        justify-content: flex-start;
        background-color: #fff;
    }

    .detail-card-header {
        width: 100%;
        display: flex;
        max-width: 987px;
        box-sizing: border-box;
        gap: 10px;
        padding: 20px 30px;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f1f4;
    }

    .detail-card-title {
        width: 100%;
        margin: 0;
        text-align: left;
        color: #071437;
        font-size: 16px;
        font-family: "Inter", sans-serif;
        font-weight: 600;
        line-height: 16px;
    }

    /* Detail Content */
    .detail-body {
        width: 100%;
        margin-bottom: 20px;
        max-width: 987px;
        box-sizing: border-box;
        align-items: flex-start;
        flex-direction: column;
        justify-content: flex-start;
        display: flex;
        position: relative;
    }

    .detail-row {
        gap: 10px;
        width: 100%;
        display: flex;
        position: relative;
        box-sizing: border-box;
        align-items: center;
        justify-content: flex-start;
        padding: 10px 30px;
        max-width: 987px;
    }

    .detail-label {
        gap: 10px;
        width: 100%;
        display: flex;
        position: relative;
        box-sizing: border-box;
        align-items: center;
        justify-content: flex-start;
        max-width: 220px;
    }

    .detail-label-text {
        width: 100%;
        margin: 0;
        text-align: left;
        color: #78829d;
        font-size: 14px;
        font-family: "Inter", sans-serif;
        font-weight: 400;
        line-height: 14px;
    }

    .detail-value {
        width: 100%;
        margin: 0;
        text-align: left;
        color: #252f4a;
        font-size: 14px;
        font-family: "Inter", sans-serif;
        font-weight: 400;
        line-height: 14px;
    }

    .detail-divider {
        width: 100%;
        height: 1px;
        background-color: #f1f1f4;
        margin: 5px 0;
    }

    /* Photo Components */
    .detail-photo-container {
        gap: 10px;
        width: 100%;
        display: flex;
        position: relative;
        max-width: 617px;
        box-sizing: border-box;
        align-items: center;
        justify-content: flex-end;
    }

    .detail-photo-wrapper {
        width: 100%;
        max-width: 60px;
        border-radius: 200px;
        overflow: hidden;
        position: relative;
        border: 2px solid #17c653;
    }

    .detail-photo {
        width: 60px;
        height: 60px;
        object-fit: cover;
    }

    /* Buttons and Interactive Elements */
    .btn-secondary {
        gap: 10px;
        display: flex;
        padding: 13px 16px;
        overflow: hidden;
        align-items: center;
        border-radius: 6px;
        background-color: #6b7280;
        color: #fff;
        font-size: 13px;
        font-family: "Inter", sans-serif;
        font-weight: 500;
        line-height: 14px;
        letter-spacing: -1px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    .edit-icon {
        display: flex;
        padding: 6px;
        align-items: center;
        justify-content: center;
        border-radius: 60px;
        background-color: transparent;
        cursor: pointer;
    }

    .edit-icon:hover {
        background-color: #f1f1f4;
    }

    /* Status Elements */
    .empty-value {
        color: #6b7280;
        font-style: italic;
    }

    .availability-badge {
        display: inline-flex;
        padding: 5px 6px;
        align-items: center;
        border-radius: 4px;
        background-color: #eafff1;
        border: 1px solid #17c653;
        color: #04b440;
        font-size: 11px;
        font-weight: 500;
        line-height: 12px;
    }

    /* Ketersediaan Dropdown */
    .ketersediaan-dropdown {
        padding: 8px 12px;
        border: 1px solid #f1f1f4;
        border-radius: 6px;
        font-size: 13px;
        font-family: "Inter", sans-serif;
        font-weight: 500;
        cursor: pointer;
        outline: none;
        transition: all 0.2s ease;
        min-width: 150px;
    }

    .ketersediaan-dropdown[data-status="tersedia"] {
        background-color: #eafff1;
        border: 1px solid #17c653;
        color: #04b440;
    }

    .ketersediaan-dropdown[data-status="tersedia"]:hover {
        background-color: #d1f7e0;
        border-color: #15b84f;
    }

    .ketersediaan-dropdown[data-status="tidak-tersedia"] {
        background-color: #fef2f2;
        border: 1px solid #ef4444;
        color: #dc2626;
    }

    .ketersediaan-dropdown[data-status="tidak-tersedia"]:hover {
        background-color: #fee2e2;
        border-color: #dc2626;
    }

    .ketersediaan-dropdown.loading {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Achievement Table */
    .achievement-table-container {
        border: 1px solid #f1f1f4;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        margin: 0;
        width: 100%;
    }

    .achievement-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin: 0;
    }

    .achievement-table th {
        background-color: #fcfcfc;
        color: #4b5675;
        font-size: 13px;
        font-weight: 500;
        padding: 15px 20px;
        text-align: left;
        border-bottom: 1px solid #f1f1f4;
        border-right: 1px solid #f1f1f4;
        white-space: nowrap;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .achievement-table th:hover {
        background-color: #f8f9fa;
    }

    .achievement-table th:last-child {
        border-right: none;
    }

    .achievement-table th.sortable {
        padding-right: 35px;
        position: relative;
    }

    .achievement-table th .sort-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 12px;
    }

    .achievement-table th.sorted-asc .sort-icon::before,
    .achievement-table th.sorted-desc .sort-icon::before {
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        color: #4b5675;
    }

    .achievement-table th.sorted-asc .sort-icon::before {
        content: "\f0de";
    }

    .achievement-table th.sorted-desc .sort-icon::before {
        content: "\f0dd";
    }

    .achievement-table th.sortable:not(.sorted-asc):not(.sorted-desc) .sort-icon::before {
        content: "\f0dc";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
    }

    .achievement-table td {
        padding: 18px 20px;
        border-bottom: 1px solid #f1f1f4;
        color: #4b5675;
        font-size: 13px;
        vertical-align: middle;
        border-right: 1px solid #f1f1f4;
    }

    .achievement-table td:last-child {
        border-right: none;
    }

    .achievement-table tr:last-child td {
        border-bottom: none;
    }

    .achievement-table tr:hover {
        background-color: #fafbfc;
    }

    /* Table Column Widths */
    .achievement-table th:nth-child(1),
    .achievement-table td:nth-child(1) {
        width: 60px;
        text-align: center;
    }

    .achievement-table th:nth-child(2),
    .achievement-table td:nth-child(2) {
        width: auto;
        min-width: 300px;
    }

    .achievement-table th:nth-child(3),
    .achievement-table td:nth-child(3) {
        width: 150px;
        text-align: center;
    }

    /* Medal and Achievement Components */
    .medal-container {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
    }

    .medal-icon {
        font-size: 18px;
        width: 20px;
        text-align: center;
    }

    .achievement-info {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 0;
    }

    .achievement-name {
        color: #071437;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 4px;
        line-height: 1.3;
        word-wrap: break-word;
    }

    .achievement-meta {
        color: #78829d;
        font-size: 12px;
        line-height: 1.2;
    }

    .text-bronze {
        color: #CD7F32 !important;
    }

    /* Empty States */
    .empty-achievement {
        text-align: center;
        padding: 60px 20px;
        color: #78829d;
        width: 100%;
    }

    .empty-achievement i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    /* Loading States */
    .table-loading {
        position: relative;
        opacity: 0.6;
        pointer-events: none;
    }

    .table-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #4f46e5;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    /* Modern Compact Pagination */
    .table-footer {
        background-color: white;
        padding: 15px 25px;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .compact-pagination-container {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 14px;
        color: #6b7280;
        flex-shrink: 0;
    }

    .compact-pagination-info {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
        white-space: nowrap;
    }

    .modern-pagination {
        display: flex;
        align-items: center;
        gap: 2px;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-shrink: 0;
    }

    .modern-pagination .page-item {
        margin: 0;
    }

    .modern-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border: 1px solid #e5e7eb;
        background-color: #ffffff;
        color: #6b7280;
        font-size: 14px;
        font-weight: 400;
        text-decoration: none;
        border-radius: 6px;
        margin: 0 1px;
        cursor: pointer;
        transition: all 0.15s ease;
        box-sizing: border-box;
    }

    .modern-pagination .page-link:hover:not(.disabled) {
        background-color: #f9fafb;
        border-color: #d1d5db;
        color: #374151;
    }

    .modern-pagination .page-item.active .page-link {
        background-color: #f3f4f6;
        border-color: #d1d5db;
        color: #1f2937;
        font-weight: 500;
        cursor: default;
    }

    .modern-pagination .page-item.disabled .page-link {
        background-color: #ffffff;
        border-color: #e5e7eb;
        color: #d1d5db;
        cursor: not-allowed;
    }

    .modern-pagination .page-link.pagination-arrow {
        font-size: 16px;
        font-weight: 500;
    }

    .pagination-arrow-prev::before {
        content: "←";
    }

    .pagination-arrow-next::before {
        content: "→";
    }

    /* Hide old pagination elements */
    .pagination-info,
    .achievement-pagination {
        display: none;
    }

    /* Animations */
    @keyframes spin {
       0% { transform: rotate(0deg); }
       100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .detail-container {
            gap: 30px;
            width: 100%;
            display: flex;
            padding: 0 20px 20px;
            position: relative;
            max-width: 1067px;
            margin: 0 auto;
            box-sizing: border-box;
            align-items: center;
            flex-direction: column;
            justify-content: center;
        }

        .detail-header {
            width: 100%;
            max-width: 987px;
            box-sizing: border-box;
            gap: 8px;
            display: flex;
            position: relative;
            align-items: flex-start;
            flex-direction: column;
            justify-content: flex-start;
        }

        .detail-title {
            width: 100%;
            max-width: auto;
            min-height: auto;
            margin-top: 0;
            text-align: left;
            margin-bottom: 0;
            color: #071437;
            font-size: 20px;
            font-style: normal;
            font-family: "Inter", sans-serif;
            font-weight: 600;
            line-height: 20px;
            letter-spacing: 0;
            text-transform: none;
        }

        .detail-card {
            width: 100%;
            display: flex;
            position: relative;
            max-width: 987px;
            box-sizing: border-box;
            gap: 20px;
            border-top: 1px solid #f1f1f4;
            border-bottom: 1px solid #f1f1f4;
            box-shadow: 0 3px 4px 0 rgba(0, 0, 0, 0.03);
            align-items: flex-start;
            border-left: 1px solid #f1f1f4;
            border-right: 1px solid #f1f1f4;
            border-radius: 12px;
            flex-direction: column;
            justify-content: flex-start;
            background-color: #fff;
        }

        .detail-card-header {
            width: 100%;
            display: flex;
            position: relative;
            max-width: 987px;
            box-sizing: border-box;
            gap: 10px;
            padding: 20px 30px;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f1f1f4;
        }

        .detail-card-title {
            width: 100%;
            max-width: auto;
            min-height: auto;
            margin-top: 0;
            text-align: left;
            margin-bottom: 0;
            color: #071437;
            font-size: 16px;
            font-style: normal;
            font-family: "Inter", sans-serif;
            font-weight: 600;
            line-height: 16px;
            letter-spacing: 0;
            text-transform: none;
        }

        .detail-body {
            width: 100%;
            margin-bottom: 20px;
            max-width: 987px;
            box-sizing: border-box;
            align-items: flex-start;
            flex-direction: column;
            justify-content: flex-start;
            display: flex;
            position: relative;
        }

        .detail-row {
            gap: 10px;
            width: 100%;
            display: flex;
            position: relative;
            box-sizing: border-box;
            align-items: center;
            justify-content: flex-start;
            padding: 10px 30px;
            max-width: 987px;
        }

        .detail-label {
            gap: 10px;
            width: 100%;
            display: flex;
            position: relative;
            box-sizing: border-box;
            align-items: center;
            justify-content: flex-start;
            max-width: 220px;
        }

        .detail-label-text {
            width: 100%;
            max-width: auto;
            min-height: auto;
            margin-top: 0;
            text-align: left;
            margin-bottom: 0;
            color: #78829d;
            font-size: 14px;
            font-style: normal;
            font-family: "Inter", sans-serif;
            font-weight: 400;
            line-height: 14px;
            letter-spacing: 0;
            text-transform: none;
        }

        .detail-value {
            width: 100%;
            max-width: auto;
            min-height: auto;
            margin-top: 0;
            text-align: left;
            margin-bottom: 0;
            color: #252f4a;
            font-size: 14px;
            font-style: normal;
            font-family: "Inter", sans-serif;
            font-weight: 400;
            line-height: 14px;
            letter-spacing: 0;
            text-transform: none;
        }

        .detail-photo-container {
            gap: 10px;
            width: 100%;
            display: flex;
            position: relative;
            max-width: 617px;
            box-sizing: border-box;
            align-items: center;
            justify-content: flex-end;
        }

        .detail-photo-wrapper {
            width: 100%;
            max-width: 60px;
            border-radius: 200px;
            overflow: hidden;
            position: relative;
            border: 2px solid #17c653;
        }

        .detail-photo {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }

        .detail-photo-info {
            color: #4b5675;
            font-size: 13px;
            font-style: normal;
            font-family: "Inter", sans-serif;
            font-weight: 400;
            line-height: 14px;
            margin-top: 8px;
        }

        .detail-divider {
            width: 100%;
            height: 1px;
            background-color: #f1f1f4;
            margin: 5px 0;
        }

        .detail-actions {
            gap: 10px;
            width: 100%;
            display: flex;
            position: relative;
            box-sizing: border-box;
            justify-content: flex-end;
            padding: 20px 30px;
            max-width: 987px;
            align-items: flex-end;
            flex-direction: row;
        }

        .btn-secondary {
            gap: 10px;
            display: flex;
            padding: 13px 16px;
            overflow: hidden;
            align-items: center;
            border-radius: 6px;
            background-color: #6b7280;
            color: #fff;
            font-size: 13px;
            font-style: normal;
            font-family: "Inter", sans-serif;
            font-weight: 500;
            line-height: 14px;
            letter-spacing: -1px;
            text-transform: none;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        .empty-value {
            color: #6b7280;
            font-style: italic;
        }

        .availability-badge {
            display: inline-flex;
            padding: 5px 6px;
            align-items: center;
            border-radius: 4px;
            background-color: #eafff1;
            border: 1px solid #17c653;
            color: #04b440;
            font-size: 11px;
            font-weight: 500;
            line-height: 12px;
        }

        .edit-icon {
            display: flex;
            padding: 6px;
            align-items: center;
            justify-content: center;
            border-radius: 60px;
            background-color: transparent;
            cursor: pointer;
        }

        .edit-icon:hover {
            background-color: #f1f1f4;
        }

        .add-address {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #1b84ff;
            font-size: 12px;
            font-weight: 500;
            line-height: 12px;
            border-bottom: 1px dashed #1b84ff;
            cursor: pointer;
            padding-bottom: 4px;
        }

        /* Achievement table styles */
        .achievement-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .achievement-table th {
            background-color: #fcfcfc;
            color: #4b5675;
            font-size: 13px;
            font-weight: 400;
            padding: 10px 20px;
            text-align: left;
            border-bottom: 1px solid #f1f1f4;
            border-right: 1px solid #f1f1f4;
        }

        .achievement-table td {
            padding: 10px 20px;
            border-bottom: 1px solid #f1f1f4;
            color: #4b5675;
            font-size: 13px;
            vertical-align: middle;
        }

        .achievement-table tr:last-child td {
            border-bottom: none;
        }

        .achievement-icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }

        .achievement-info {
            display: flex;
            flex-direction: column;
        }

        .achievement-title {
            color: #071437;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .achievement-year {
            color: #4b5675;
            font-size: 12px;
        }

        .pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 2px;
            padding: 14px 20px;
        }
    }
</style>
<div class="main-content">
    <div class="detail-container">
        <div class="detail-header">
            <h1 class="detail-title">Profil Atlet</h1>
        </div>

            <div class="detail-card">
                <div class="detail-card-header">
                    <h2 class="detail-card-title">Personal Info</h2>
                </div>

                <div class="detail-body">
                    <div class="detail-row">
                        <div class="detail-label">
                            <p class="detail-label-text">Foto</p>
                        </div>
                        <div class="detail-photo-container">
                            @if ($atlet->foto)
                                <div class="detail-photo-wrapper">
                                    <img src="{{ asset('storage/' . $atlet->foto) }}" alt="Foto Atlet"
                                        class="detail-photo">
                                </div>
                            @else
                                <div class="detail-photo-wrapper">
                                    <div
                                        style="width: 60px; height: 60px; background-color: #f1f1f4; display: flex; align-items: center; justify-content: center;">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">

                                        </svg>
                                    </div>
                                </div>
                            @endif
                            @php
                                $caborNama = $atlet->cabangOlahraga ? $atlet->cabangOlahraga->nama_cabor : '-';
                            @endphp
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                    <div class="detail-row">
                        <div class="detail-label">
                            <p class="detail-label-text">Nama</p>
                        </div>
                        <p class="detail-value">{{ $atlet->nama }}</p>
                        <div class="edit-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                            </svg>
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                    <div class="detail-row">
                        <div class="detail-label">
                            <p class="detail-label-text">Cabor</p>
                        </div>
                        <p class="detail-value">{{ $caborNama }}</p>
                        <div class="edit-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                            </svg>
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                    <div class="detail-row">
                        <div class="detail-label">
                            <p class="detail-label-text">Email</p>
                        </div>
                        <p class="detail-value">{{ $atlet->email ?? '-' }}</p>
                        <div class="edit-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                            </svg>
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Ketersediaan</p>
                    </div>
                    <div class="detail-value">
                        <select name="ketersediaan" id="ketersediaanSelect" class="ketersediaan-dropdown"
                                data-status="{{ strtolower(str_replace('-', '-', $atlet->ketersediaan)) }}"
                                onchange="submitKetersediaanForm()">
                            <option value="Tersedia" {{ $atlet->ketersediaan == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Tidak-Tersedia" {{ $atlet->ketersediaan == 'Tidak-Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
                <div class="detail-divider"></div>

                    <div class="detail-row">
                        <div class="detail-label">
                            <p class="detail-label-text">No Telepon</p>
                        </div>
                        <p class="detail-value">{{ $atlet->no_telepon ?? '-' }}</p>
                        <div class="edit-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                            </svg>
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                    <div class="detail-row">
                        <div class="detail-label">
                            <p class="detail-label-text">Tempat Lahir</p>
                        </div>
                        <p class="detail-value">{{ $atlet->tempat_lahir }}</p>
                        <div class="edit-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                            </svg>
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                    <div class="detail-row">
                        <div class="detail-label">
                            <p class="detail-label-text">Tanggal Lahir</p>
                        </div>
                        <p class="detail-value">{{ \Carbon\Carbon::parse($atlet->tanggal_lahir)->format('d M Y') }}</p>
                        <div class="edit-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                            </svg>
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                    <div class="detail-row">
                        <div class="detail-label">
                            <p class="detail-label-text">Umur</p>
                        </div>
                        <p class="detail-value">{{ \Carbon\Carbon::parse($atlet->tanggal_lahir)->age }} Tahun</p>
                        <div class="edit-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                            </svg>
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                    <div class="detail-row">
                        <div class="detail-label">
                            <p class="detail-label-text">Kelamin</p>
                        </div>
                        <p class="detail-value">{{ $atlet->kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        <div class="edit-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                            </svg>
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                <div class="detail-row">
                <div class="detail-label">
                    <p class="detail-label-text">Alamat</p>
                </div>
                <div class="detail-value">
                    @if($atlet->alamatkota && $atlet->alamatprovinsi)
                        <div>
                            <strong>{{ $atlet->alamatkota }}, {{ $atlet->alamatprovinsi }}</strong>
                        </div>
                        @if($atlet->alamat)
                            <div class="text-muted" style="font-size: 12px; color: #78829d; margin-top: 4px;">
                                {{ $atlet->alamat }}
                            </div>
                        @endif
                    @elseif($atlet->alamat)
                        <div>{{ $atlet->alamat }}</div>
                    @else
                        <span class="empty-value">Belum ada alamat yang tercantum</span>
                    @endif
                </div>
                <div class="add-address">
                </div>
            </div>
            </div>
        </div>

<div class="detail-card">
    @include('admin.atlet._tableprestasi')
</div>

<div class="detail-actions">
    <a href="{{ $backUrl ?? route('admin.konfigurasi.atlet.index') }}" class="btn btn-light-primary">
        <i class="ki-duotone ki-arrow-left fs-2"></i> Kembali
    </a>
</div>

@endsection

@section('script')
<script>
    function submitKetersediaanForm() {
        console.log('Function called!');

        const select = document.getElementById('ketersediaanSelect');
        const csrfToken = document.querySelector('meta[name="csrf-token"]');

        if (!csrfToken) {
            alert('CSRF token not found!');
            return;
        }

        const selectedValue = select.value;
        console.log('Selected value:', selectedValue);

        // Update the data-status attribute for styling
        updateSelectStatus(select, selectedValue);

        // Add loading state
        select.classList.add('loading');
        select.disabled = true;

        // Create manual FormData instead of using form
        const formData = new FormData();
        formData.append('_token', csrfToken.getAttribute('content'));
        formData.append('_method', 'PATCH');
        formData.append('ketersediaan', selectedValue);

        console.log('FormData entries:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        // Submit the request
        fetch('{{ route("admin.konfigurasi.atlet.updateKetersediaan", $atlet->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);

            if (!response.ok) {
                return response.text().then(text => {
                    console.log('Error response body:', text);
                    throw new Error(`HTTP error! status: ${response.status}`);
                });
            }

            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);

            if (data.success) {
                console.log('Success! Ketersediaan updated');
                // Optional: Show success message
                // alert('Ketersediaan berhasil diperbarui!');
            } else {
                console.error('Server returned success: false');
                alert('Error: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Error: ' + error.message);

            // Revert selection on error
            // You might want to store the previous value and revert here
        })
        .finally(() => {
            // Remove loading state
            select.classList.remove('loading');
            select.disabled = false;
        });
    }

    // Function to update the select styling based on value
    function updateSelectStatus(selectElement, value) {
        if (value === 'Tersedia') {
            selectElement.setAttribute('data-status', 'tersedia');
        } else if (value === 'Tidak-Tersedia') {
            selectElement.setAttribute('data-status', 'tidak-tersedia');
        }
    }

    // Initialize styling on page load
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('ketersediaanSelect');
        if (select) {
            updateSelectStatus(select, select.value);
        }
    });

    console.log('Script loaded successfully!');
</script>

<script>
$(document).ready(function() {
    // Initialize sorting and pagination variables
    let currentSort = {
        column: 'created_at',
        direction: 'desc'
    };
    let currentPage = 1;
    let isLoading = false;

    // Load achievements with proper error handling
    function loadAchievements(page = 1) {
        if (isLoading) return;

        const container = document.getElementById('achievement-table-container');
        const tbody = document.getElementById('achievement-tbody');

        if (!container || !tbody) {
            console.error('Required DOM elements not found');
            return;
        }

        isLoading = true;
        container.classList.add('table-loading');

        // Build query parameters
        const params = new URLSearchParams({
            page: page,
            sort_by: currentSort.column,
            order: currentSort.direction,
            per_page: 3,
            ajax: 1  // Add this to identify AJAX requests
        });

        const url = `{{ route('admin.konfigurasi.atlet.show', $atlet->id) }}?${params}`;

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);

            if (data.success && data.prestasis) {
                updateTable(data.prestasis, data.pagination);
                currentPage = page;
                updateSortIcons();
                bindPaginationEvents();
                updateURL(page);
            } else {
                throw new Error('Invalid response format or success false');
            }
        })
        .catch(error => {
            console.error('Error loading achievements:', error);

            tbody.innerHTML = `
                <tr>
                    <td colspan="3" class="empty-achievement">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                        <div>Error loading achievements</div>
                        <div style="font-size: 11px; margin-top: 5px;">${error.message}</div>
                    </td>
                </tr>
            `;

            // Clear pagination on error
            const paginationContainer = document.querySelector('.simple-pagination');
            if (paginationContainer) {
                paginationContainer.innerHTML = '';
            }
        })
        .finally(() => {
            container.classList.remove('table-loading');
            isLoading = false;
        });
    }

    // Update table with new data
    function updateTable(prestasis, pagination) {
    const tbody = document.getElementById('achievement-tbody');
    const compactPaginationInfo = document.getElementById('compact-pagination-info');

    if (!tbody) return;

    // Update table body (keep your existing table body code)
    if (!prestasis || prestasis.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="empty-achievement">
                    <br>
                    <center><i class="fas fa-trophy"></i></center>
                    <center><div>Belum ada data prestasi.</div></center>
                    <center><div style="font-size: 11px; margin-top: 5px;">Silakan tambahkan di menu kejuaraan.</div></center>
                    <br>
                    <br>
                </td>
            </tr>
        `;
    } else {
        tbody.innerHTML = prestasis.map((prestasi, index) => {
            const medaliType = prestasi.medali ? prestasi.medali.toLowerCase() : '';
            let medalIcon = '<i class="fas fa-trophy text-muted"></i>';

            if (medaliType === 'emas') {
                medalIcon = '<i class="fas fa-medal text-warning"></i>';
            } else if (medaliType === 'perak') {
                medalIcon = '<i class="fas fa-medal text-secondary"></i>';
            } else if (medaliType === 'perunggu') {
                medalIcon = '<i class="fas fa-medal text-bronze"></i>';
            }

            const rowNumber = pagination ? (pagination.from + index) : (index + 1);

            return `
                <tr>
                    <td>${rowNumber}</td>
                    <td>
                        <div class="medal-container">
                            <div class="medal-icon">${medalIcon}</div>
                            <div class="achievement-info">
                                <div class="achievement-name">${prestasi.nama_prestasi || 'N/A'}</div>
                                <div class="achievement-meta">${prestasi.tahun || '-'} • Medali ${prestasi.medali ? prestasi.medali.charAt(0).toUpperCase() + prestasi.medali.slice(1) : 'Lainnya'}</div>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: center;">${prestasi.tempat || '-'}</td>
                </tr>
            `;
        }).join('');
    }

    // Update compact pagination info (new format)
    if (compactPaginationInfo && pagination && pagination.total > 0) {
        compactPaginationInfo.textContent = `${pagination.from}-${pagination.to} of ${pagination.total}`;
    } else if (compactPaginationInfo) {
        compactPaginationInfo.textContent = '0-0 of 0';
    }

    // Update pagination controls
    if (pagination && pagination.last_page > 1) {
        updateModernPaginationControls(pagination);
    } else {
        clearModernPagination();
    }
}

    // Update pagination controls
    function updateModernPaginationControls(pagination) {
    const paginationParent = document.getElementById('modern-pagination');
    if (!paginationParent) return;

    let html = '';

    // Previous button
    if (pagination.current_page > 1) {
        html += `<li class="page-item">
            <button class="page-link pagination-arrow pagination-arrow-prev" data-page="${pagination.current_page - 1}" type="button" title="Previous page"></button>
        </li>`;
    } else {
        html += `<li class="page-item disabled">
            <span class="page-link pagination-arrow pagination-arrow-prev disabled"></span>
        </li>`;
    }

    // Show limited page numbers for compact design
    let startPage, endPage;

    if (pagination.last_page <= 5) {
        // If 5 or fewer pages, show all
        startPage = 1;
        endPage = pagination.last_page;
    } else {
        // More than 5 pages, show smart pagination
        if (pagination.current_page <= 3) {
            startPage = 1;
            endPage = 5;
        } else if (pagination.current_page >= pagination.last_page - 2) {
            startPage = pagination.last_page - 4;
            endPage = pagination.last_page;
        } else {
            startPage = pagination.current_page - 2;
            endPage = pagination.current_page + 2;
        }
    }

    // Add ellipsis if needed at the beginning
    if (startPage > 1) {
        html += `<li class="page-item"><button class="page-link" data-page="1" type="button">1</button></li>`;
        if (startPage > 2) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }

    // Page numbers
    for (let i = startPage; i <= endPage; i++) {
        if (i === pagination.current_page) {
            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
        } else {
            html += `<li class="page-item"><button class="page-link" data-page="${i}" type="button">${i}</button></li>`;
        }
    }

    // Add ellipsis if needed at the end
    if (endPage < pagination.last_page) {
        if (endPage < pagination.last_page - 1) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        html += `<li class="page-item"><button class="page-link" data-page="${pagination.last_page}" type="button">${pagination.last_page}</button></li>`;
    }

    // Next button
    if (pagination.current_page < pagination.last_page) {
        html += `<li class="page-item">
            <button class="page-link pagination-arrow pagination-arrow-next" data-page="${pagination.current_page + 1}" type="button" title="Next page"></button>
        </li>`;
    } else {
        html += `<li class="page-item disabled">
            <span class="page-link pagination-arrow pagination-arrow-next disabled"></span>
        </li>`;
    }

    paginationParent.innerHTML = html;
}

    // Clear pagination when no data
function clearModernPagination() {
    const paginationParent = document.getElementById('modern-pagination');
    if (paginationParent) {
        paginationParent.innerHTML = '';
    }
}

    // Bind pagination click events
function bindPaginationEvents() {
    const paginationButtons = document.querySelectorAll('#modern-pagination .page-link[data-page]');

    paginationButtons.forEach(button => {
        // Remove existing event listeners to prevent duplicates
        button.removeEventListener('click', handlePaginationClick);
        button.addEventListener('click', handlePaginationClick);
    });
}

    // Handle pagination button clicks
    function handlePaginationClick(e) {
        e.preventDefault();
        const page = parseInt(e.target.getAttribute('data-page'));

        if (page && page !== currentPage && !isLoading) {
            loadAchievements(page);
        }
    }

    // Handle column sorting
    function handleSort(column) {
        if (isLoading) return;

        // Toggle direction if same column, otherwise default to desc
        if (currentSort.column === column) {
            currentSort.direction = currentSort.direction === 'desc' ? 'asc' : 'desc';
        } else {
            currentSort.column = column;
            currentSort.direction = 'desc';
        }

        // Load first page with new sort
        loadAchievements(1);
    }

    // Update sort icons
    function updateSortIcons() {
        const headers = document.querySelectorAll('.achievement-table th.sortable');

        headers.forEach(header => {
            const column = header.getAttribute('data-column');
            header.classList.remove('sorted-asc', 'sorted-desc');

            if (column === currentSort.column) {
                header.classList.add(currentSort.direction === 'desc' ? 'sorted-desc' : 'sorted-asc');
            }
        });
    }

    // Update URL without page reload
    function updateURL(page) {
        if (history.pushState) {
            const url = new URL(window.location);
            url.searchParams.set('page', page);
            url.searchParams.set('sort_by', currentSort.column);
            url.searchParams.set('order', currentSort.direction);
            history.pushState(null, '', url);
        }
    }

    // Initialize sorting event listeners
    function initializeSorting() {
        const sortableHeaders = document.querySelectorAll('.achievement-table th[data-column]');

        sortableHeaders.forEach(header => {
            header.style.cursor = 'pointer';
            header.classList.add('sortable');

            // Add sort icon if not present
            if (!header.querySelector('.sort-icon')) {
                const icon = document.createElement('span');
                icon.className = 'sort-icon';
                header.appendChild(icon);
            }

            header.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                handleSort(column);
            });
        });
    }

    // Get initial page from URL
    function getInitialPage() {
        const urlParams = new URLSearchParams(window.location.search);
        const page = parseInt(urlParams.get('page')) || 1;
        const sortBy = urlParams.get('sort_by') || 'created_at';
        const order = urlParams.get('order') || 'desc';

        currentSort.column = sortBy;
        currentSort.direction = order;
        currentPage = page;

        return page;
    }

    // Initialize everything
    function initialize() {
        console.log('Initializing pagination and sorting...');

        // Initialize sorting
        initializeSorting();

        // Get initial page and load data
        const initialPage = getInitialPage();
        loadAchievements(initialPage);

        // Update sort icons
        updateSortIcons();
    }

    // Run initialization
    initialize();

    // Make functions available globally if needed
    window.loadAchievements = loadAchievements;
    window.handleSort = handleSort;
});
</script>
@endsection
