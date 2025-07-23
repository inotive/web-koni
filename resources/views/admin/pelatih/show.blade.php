@extends('layouts.app')

@section('pageTitle', 'Detail Pelatih')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('subSection', 'Pelatih')
@section('subSectionUrl', route('admin.konfigurasi.pelatih.index'))
@section('currentSection', 'Detail Pelatih')
<h1 class="text-dark fw-bold fs-3 mb-0">Detail Pelatih</h1>

@section('content')
    <style>
        .detail-container {
            gap: 30px;
            width: 100%;
            display: flex;
            padding: 0 40px 30px;
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

        .pagination-item {
            padding: 8px 12px;
            border-radius: 6px;
            color: #4b5675;
            font-size: 14px;
            cursor: pointer;
        }

        .pagination-item.active {
            background-color: #f1f1f4;
            color: #252f4a;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .detail-container {
                padding: 0 20px 20px;
            }

            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
                padding: 15px 20px;
            }

            .detail-label {
                max-width: 100%;
            }

            .detail-photo-container {
                justify-content: flex-start;
                margin-top: 10px;
            }

            .achievement-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>

    <div class="detail-container">
        <div class="detail-header">
            <h1 class="detail-title">Profil Pelatih</h1>
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
                        @if ($pelatih->foto)
                            <div class="detail-photo-wrapper">
                                <img src="{{ asset('storage/' . $pelatih->foto) }}" alt="Foto Pelatih" class="detail-photo">
                            </div>
                        @else
                            <div class="detail-photo-wrapper">
                                <div
                                    style="width: 60px; height: 60px; background-color: #f1f1f4; display: flex; align-items: center; justify-content: center;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z"
                                            fill="#78829D" />
                                    </svg>
                                </div>
                            </div>
                        @endif
                        <p class="detail-photo-info">150x150px JPEG, PNG Image</p>
                    </div>
                </div>

                <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Nama</p>
                    </div>
                    <p class="detail-value">{{ $pelatih->nama }}</p>
                    <div class="edit-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.3333 2.00001C11.5083 1.82503 11.7162 1.68699 11.945 1.59411C12.1738 1.50123 12.4189 1.45532 12.6666 1.45915C12.9143 1.46298 13.1596 1.51648 13.3858 1.61618C13.6121 1.71588 13.8145 1.85961 13.9799 2.03821C14.1453 2.21681 14.2702 2.42652 14.3467 2.65414C14.4232 2.88176 14.4496 3.12235 14.4243 3.36015C14.399 3.59795 14.3226 3.82771 14.2 4.03334L13.6666 4.66668L11.3333 2.33334L11.9666 1.80001C12.0563 1.72078 12.1598 1.65792 12.2723 1.6143C12.3848 1.57068 12.5044 1.547 12.625 1.54433C12.7455 1.54166 12.8653 1.56005 12.9793 1.59862C13.0933 1.63719 13.1996 1.69531 13.2933 1.77001L14.2266 2.70668C14.3013 2.80041 14.3594 2.90673 14.398 2.02073C14.4366 3.13473 14.4566 2.91873 14.4566 3.04001C14.4539 3.16057 14.4302 3.28016 14.3866 3.39266C14.343 3.50516 14.2801 3.60867 14.2008 3.69834L5.53329 12.3667C5.45305 12.4475 5.35663 12.5104 5.25063 12.5513C5.14463 12.5921 5.03156 12.61 4.91863 12.6033L2.66663 12.3333L2.39663 10.0813C2.38996 9.96841 2.40783 9.85534 2.44868 9.74934C2.48953 9.64334 2.55242 9.54692 2.63329 9.46668L11.3333 2.00001Z"
                                fill="#78829D" />
                        </svg>
                    </div>
                </div>

                <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Cabor</p>
                    </div>
                    <p class="detail-value">{{ $pelatih->cabor }}</p>
                    <div class="edit-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.3333 2.00001C11.5083 1.82503 11.7162 1.68699 11.945 1.59411C12.1738 1.50123 12.4189 1.45532 12.6666 1.45915C12.9143 1.46298 13.1596 1.51648 13.3858 1.61618C13.6121 1.71588 13.8145 1.85961 13.9799 2.03821C14.1453 2.21681 14.2702 2.42652 14.3467 2.65414C14.4232 2.88176 14.4496 3.12235 14.4243 3.36015C14.399 3.59795 14.3226 3.82771 14.2 4.03334L13.6666 4.66668L11.3333 2.33334L11.9666 1.80001C12.0563 1.72078 12.1598 1.65792 12.2723 1.6143C12.3848 1.57068 12.5044 1.547 12.625 1.54433C12.7455 1.54166 12.8653 1.56005 12.9793 1.59862C13.0933 1.63719 13.1996 1.69531 13.2933 1.77001L14.2266 2.70668C14.3013 2.80041 14.3594 2.90673 14.398 2.02073C14.4366 3.13473 14.4566 2.91873 14.4566 3.04001C14.4539 3.16057 14.4302 3.28016 14.3866 3.39266C14.343 3.50516 14.2801 3.60867 14.2008 3.69834L5.53329 12.3667C5.45305 12.4475 5.35663 12.5104 5.25063 12.5513C5.14463 12.5921 5.03156 12.61 4.91863 12.6033L2.66663 12.3333L2.39663 10.0813C2.38996 9.96841 2.40783 9.85534 2.44868 9.74934C2.48953 9.64334 2.55242 9.54692 2.63329 9.46668L11.3333 2.00001Z"
                                fill="#78829D" />
                        </svg>
                    </div>
                </div>

                <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Email</p>
                    </div>
                    <p class="detail-value">{{ $pelatih->email ?? '<span class="empty-value">-</span>' }}</p>
                    <div class="edit-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.3333 2.00001C11.5083 1.82503 11.7162 1.68699 11.945 1.59411C12.1738 1.50123 12.4189 1.45532 12.6666 1.45915C12.9143 1.46298 13.1596 1.51648 13.3858 1.61618C13.6121 1.71588 13.8145 1.85961 13.9799 2.03821C14.1453 2.21681 14.2702 2.42652 14.3467 2.65414C14.4232 2.88176 14.4496 3.12235 14.4243 3.36015C14.399 3.59795 14.3226 3.82771 14.2 4.03334L13.6666 4.66668L11.3333 2.33334L11.9666 1.80001C12.0563 1.72078 12.1598 1.65792 12.2723 1.6143C12.3848 1.57068 12.5044 1.547 12.625 1.54433C12.7455 1.54166 12.8653 1.56005 12.9793 1.59862C13.0933 1.63719 13.1996 1.69531 13.2933 1.77001L14.2266 2.70668C14.3013 2.80041 14.3594 2.90673 14.398 2.02073C14.4366 3.13473 14.4566 2.91873 14.4566 3.04001C14.4539 3.16057 14.4302 3.28016 14.3866 3.39266C14.343 3.50516 14.2801 3.60867 14.2008 3.69834L5.53329 12.3667C5.45305 12.4475 5.35663 12.5104 5.25063 12.5513C5.14463 12.5921 5.03156 12.61 4.91863 12.6033L2.66663 12.3333L2.39663 10.0813C2.38996 9.96841 2.40783 9.85534 2.44868 9.74934C2.48953 9.64334 2.55242 9.54692 2.63329 9.46668L11.3333 2.00001Z"
                                fill="#78829D" />
                        </svg>
                    </div>
                </div>

                <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Ketersediaan</p>
                    </div>
                    <span class="availability-badge">Tersedia sekarang</span>
                    <div class="edit-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.3333 2.00001C11.5083 1.82503 11.7162 1.68699 11.945 1.59411C12.1738 1.50123 12.4189 1.45532 12.6666 1.45915C12.9143 1.46298 13.1596 1.51648 13.3858 1.61618C13.6121 1.71588 13.8145 1.85961 13.9799 2.03821C14.1453 2.21681 14.2702 2.42652 14.3467 2.65414C14.4232 2.88176 14.4496 3.12235 14.4243 3.36015C14.399 3.59795 14.3226 3.82771 14.2 4.03334L13.6666 4.66668L11.3333 2.33334L11.9666 1.80001C12.0563 1.72078 12.1598 1.65792 12.2723 1.6143C12.3848 1.57068 12.5044 1.547 12.625 1.54433C12.7455 1.54166 12.8653 1.56005 12.9793 1.59862C13.0933 1.63719 13.1996 1.69531 13.2933 1.77001L14.2266 2.70668C14.3013 2.80041 14.3594 2.90673 14.398 2.02073C14.4366 3.13473 14.4566 2.91873 14.4566 3.04001C14.4539 3.16057 14.4302 3.28016 14.3866 3.39266C14.343 3.50516 14.2801 3.60867 14.2008 3.69834L5.53329 12.3667C5.45305 12.4475 5.35663 12.5104 5.25063 12.5513C5.14463 12.5921 5.03156 12.61 4.91863 12.6033L2.66663 12.3333L2.39663 10.0813C2.38996 9.96841 2.40783 9.85534 2.44868 9.74934C2.48953 9.64334 2.55242 9.54692 2.63329 9.46668L11.3333 2.00001Z"
                                fill="#78829D" />
                        </svg>
                    </div>
                </div>

                <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">No Telepon</p>
                    </div>
                    <p class="detail-value">{{ $pelatih->no_telepon ?? '<span class="empty-value">-</span>' }}</p>
                    <div class="edit-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.3333 2.00001C11.5083 1.82503 11.7162 1.68699 11.945 1.59411C12.1738 1.50123 12.4189 1.45532 12.6666 1.45915C12.9143 1.46298 13.1596 1.51648 13.3858 1.61618C13.6121 1.71588 13.8145 1.85961 13.9799 2.03821C14.1453 2.21681 14.2702 2.42652 14.3467 2.65414C14.4232 2.88176 14.4496 3.12235 14.4243 3.36015C14.399 3.59795 14.3226 3.82771 14.2 4.03334L13.6666 4.66668L11.3333 2.33334L11.9666 1.80001C12.0563 1.72078 12.1598 1.65792 12.2723 1.6143C12.3848 1.57068 12.5044 1.547 12.625 1.54433C12.7455 1.54166 12.8653 1.56005 12.9793 1.59862C13.0933 1.63719 13.1996 1.69531 13.2933 1.77001L14.2266 2.70668C14.3013 2.80041 14.3594 2.90673 14.398 2.02073C14.4366 3.13473 14.4566 2.91873 14.4566 3.04001C14.4539 3.16057 14.4302 3.28016 14.3866 3.39266C14.343 3.50516 14.2801 3.60867 14.2008 3.69834L5.53329 12.3667C5.45305 12.4475 5.35663 12.5104 5.25063 12.5513C5.14463 12.5921 5.03156 12.61 4.91863 12.6033L2.66663 12.3333L2.39663 10.0813C2.38996 9.96841 2.40783 9.85534 2.44868 9.74934C2.48953 9.64334 2.55242 9.54692 2.63329 9.46668L11.3333 2.00001Z"
                                fill="#78829D" />
                        </svg>
                    </div>
                </div>

                <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Tempat Lahir</p>
                    </div>
                    <p class="detail-value">{{ $pelatih->tempat_lahir }}</p>
                    <div class="edit-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.3333 2.00001C11.5083 1.82503 11.7162 1.68699 11.945 1.59411C12.1738 1.50123 12.4189 1.45532 12.6666 1.45915C12.9143 1.46298 13.1596 1.51648 13.3858 1.61618C13.6121 1.71588 13.8145 1.85961 13.9799 2.03821C14.1453 2.21681 14.2702 2.42652 14.3467 2.65414C14.4232 2.88176 14.4496 3.12235 14.4243 3.36015C14.399 3.59795 14.3226 3.82771 14.2 4.03334L13.6666 4.66668L11.3333 2.33334L11.9666 1.80001C12.0563 1.72078 12.1598 1.65792 12.2723 1.6143C12.3848 1.57068 12.5044 1.547 12.625 1.54433C12.7455 1.54166 12.8653 1.56005 12.9793 1.59862C13.0933 1.63719 13.1996 1.69531 13.2933 1.77001L14.2266 2.70668C14.3013 2.80041 14.3594 2.90673 14.398 2.02073C14.4366 3.13473 14.4566 2.91873 14.4566 3.04001C14.4539 3.16057 14.4302 3.28016 14.3866 3.39266C14.343 3.50516 14.2801 3.60867 14.2008 3.69834L5.53329 12.3667C5.45305 12.4475 5.35663 12.5104 5.25063 12.5513C5.14463 12.5921 5.03156 12.61 4.91863 12.6033L2.66663 12.3333L2.39663 10.0813C2.38996 9.96841 2.40783 9.85534 2.44868 9.74934C2.48953 9.64334 2.55242 9.54692 2.63329 9.46668L11.3333 2.00001Z"
                                fill="#78829D" />
                        </svg>
                    </div>
                </div>

                <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Tanggal Lahir</p>
                    </div>
                    <p class="detail-value">{{ \Carbon\Carbon::parse($pelatih->tanggal_lahir)->format('d M Y') }}</p>
                    <div class="edit-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.3333 2.00001C11.5083 1.82503 11.7162 1.68699 11.945 1.59411C12.1738 1.50123 12.4189 1.45532 12.6666 1.45915C12.9143 1.46298 13.1596 1.51648 13.3858 1.61618C13.6121 1.71588 13.8145 1.85961 13.9799 2.03821C14.1453 2.21681 14.2702 2.42652 14.3467 2.65414C14.4232 2.88176 14.4496 3.12235 14.4243 3.36015C14.399 3.59795 14.3226 3.82771 14.2 4.03334L13.6666 4.66668L11.3333 2.33334L11.9666 1.80001C12.0563 1.72078 12.1598 1.65792 12.2723 1.6143C12.3848 1.57068 12.5044 1.547 12.625 1.54433C12.7455 1.54166 12.8653 1.56005 12.9793 1.59862C13.0933 1.63719 13.1996 1.69531 13.2933 1.77001L14.2266 2.70668C14.3013 2.80041 14.3594 2.90673 14.398 2.02073C14.4366 3.13473 14.4566 2.91873 14.4566 3.04001C14.4539 3.16057 14.4302 3.28016 14.3866 3.39266C14.343 3.50516 14.2801 3.60867 14.2008 3.69834L5.53329 12.3667C5.45305 12.4475 5.35663 12.5104 5.25063 12.5513C5.14463 12.5921 5.03156 12.61 4.91863 12.6033L2.66663 12.3333L2.39663 10.0813C2.38996 9.96841 2.40783 9.85534 2.44868 9.74934C2.48953 9.64334 2.55242 9.54692 2.63329 9.46668L11.3333 2.00001Z"
                                fill="#78829D" />
                        </svg>
                    </div>
                </div>

                <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Umur</p>
                    </div>
                    <p class="detail-value">{{ \Carbon\Carbon::parse($pelatih->tanggal_lahir)->age }} Tahun</p>
                    <div class="edit-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.3333 2.00001C11.5083 1.82503 11.7162 1.68699 11.945 1.59411C12.1738 1.50123 12.4189 1.45532 12.6666 1.45915C12.9143 1.46298 13.1596 1.51648 13.3858 1.61618C13.6121 1.71588 13.8145 1.85961 13.9799 2.03821C14.1453 2.21681 14.2702 2.42652 14.3467 2.65414C14.4232 2.88176 14.4496 3.12235 14.4243 3.36015C14.399 3.59795 14.3226 3.82771 14.2 4.03334L13.6666 4.66668L11.3333 2.33334L11.9666 1.80001C12.0563 1.72078 12.1598 1.65792 12.2723 1.6143C12.3848 1.57068 12.5044 1.547 12.625 1.54433C12.7455 1.54166 12.8653 1.56005 12.9793 1.59862C13.0933 1.63719 13.1996 1.69531 13.2933 1.77001L14.2266 2.70668C14.3013 2.80041 14.3594 2.90673 14.398 2.02073C14.4366 3.13473 14.4566 2.91873 14.4566 3.04001C14.4539 3.16057 14.4302 3.28016 14.3866 3.39266C14.343 3.50516 14.2801 3.60867 14.2008 3.69834L5.53329 12.3667C5.45305 12.4475 5.35663 12.5104 5.25063 12.5513C5.14463 12.5921 5.03156 12.61 4.91863 12.6033L2.66663 12.3333L2.39663 10.0813C2.38996 9.96841 2.40783 9.85534 2.44868 9.74934C2.48953 9.64334 2.55242 9.54692 2.63329 9.46668L11.3333 2.00001Z"
                                fill="#78829D" />
                        </svg>
                    </div>
                </div>

                <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Kelamin</p>
                    </div>
                    <p class="detail-value">{{ $pelatih->kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    <div class="edit-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.3333 2.00001C11.5083 1.82503 11.7162 1.68699 11.945 1.59411C12.1738 1.50123 12.4189 1.45532 12.6666 1.45915C12.9143 1.46298 13.1596 1.51648 13.3858 1.61618C13.6121 1.71588 13.8145 1.85961 13.9799 2.03821C14.1453 2.21681 14.2702 2.42652 14.3467 2.65414C14.4232 2.88176 14.4496 3.12235 14.4243 3.36015C14.399 3.59795 14.3226 3.82771 14.2 4.03334L13.6666 4.66668L11.3333 2.33334L11.9666 1.80001C12.0563 1.72078 12.1598 1.65792 12.2723 1.6143C12.3848 1.57068 12.5044 1.547 12.625 1.54433C12.7455 1.54166 12.8653 1.56005 12.9793 1.59862C13.0933 1.63719 13.1996 1.69531 13.2933 1.77001L14.2266 2.70668C14.3013 2.80041 14.3594 2.90673 14.398 2.02073C14.4366 3.13473 14.4566 2.91873 14.4566 3.04001C14.4539 3.16057 14.4302 3.28016 14.3866 3.39266C14.343 3.50516 14.2801 3.60867 14.2008 3.69834L5.53329 12.3667C5.45305 12.4475 5.35663 12.5104 5.25063 12.5513C5.14463 12.5921 5.03156 12.61 4.91863 12.6033L2.66663 12.3333L2.39663 10.0813C2.38996 9.96841 2.40783 9.85534 2.44868 9.74934C2.48953 9.64334 2.55242 9.54692 2.63329 9.46668L11.3333 2.00001Z"
                                fill="#78829D" />
                        </svg>
                    </div>
                </div>

                <div class="detail-divider"></div>

                <div class="detail-row">
                    <div class="detail-label">
                        <p class="detail-label-text">Alamat</p>
                    </div>
                    <p class="detail-value">{{ $pelatih->alamat ?? 'Belum ada alamat yang tercantum' }}</p>
                    <div class="add-address">
                        <span>tambah</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="detail-card-title">Informasi Kejuaraan</h2>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#tambahPrestasiModal">
                    + Tambah Prestasi
                </button>
            </div>

            <div class="detail-body" style="padding: 0;">
                <table class="achievement-table">
                    <thead>
                        <tr>
                            <th>Prestasi Kejuaraan</th>
                            <th>Tempat & Tahun</th>
                            <th>Medali</th>
                            <th style="width: 100px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelatih->prestasis as $prestasi)
                            <tr>
                                <td>{{ $prestasi->nama_prestasi }}</td>
                                <td>{{ $prestasi->tempat }} - <strong>{{ $prestasi->tahun }}</strong></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        @php
                                            $medalColor = '';
                                            if ($prestasi->medali == 'Emas') {
                                                $medalColor = '#FFD700';
                                            }
                                            // Gold
                                            elseif ($prestasi->medali == 'Perak') {
                                                $medalColor = '#C0C0C0';
                                            }
                                            // Silver
                                            elseif ($prestasi->medali == 'Perunggu') {
                                                $medalColor = '#CD7F32';
                                            } // Bronze
                                        @endphp
                                        <svg class="achievement-icon" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="10" fill="{{ $medalColor }}"
                                                stroke="#4A5568" stroke-width="0.5" />
                                            <path
                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                                                fill="white" opacity="0.8" />
                                        </svg>
                                        <strong>{{ $prestasi->medali }}</strong>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <form
                                        action="{{ route('admin.prestasi.destroy', [$pelatih->id, $prestasi->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menghapus prestasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px;">Belum ada data prestasi.
                                    Silakan tambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="detail-actions">
            <a href="{{ route('admin.konfigurasi.pelatih.index') }}" class="btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="modal fade" id="tambahPrestasiModal" tabindex="-1" aria-labelledby="tambahPrestasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPrestasiModalLabel">Tambah Prestasi Baru untuk {{ $pelatih->nama }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.konfigurasi.pelatih.prestasi.store', $pelatih->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_prestasi" class="form-label">Nama Kejuaraan</label>
                            <input type="text" class="form-control" id="nama_prestasi" name="nama_prestasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="tempat" class="form-label">Tempat Lomba</label>
                            <input type="text" class="form-control" id="tempat" name="tempat" required>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" class="form-control" id="tahun" name="tahun" required
                                placeholder="Contoh: 2024">
                        </div>
                        <div class="mb-3">
                            <label for="medali" class="form-label">Medali</label>
                            <select class="form-select" id="medali" name="medali" required>
                                <option value="" disabled selected>-- Pilih Medali --</option>
                                <option value="Emas">Emas</option>
                                <option value="Perak">Perak</option>
                                <option value="Perunggu">Perunggu</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Prestasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
