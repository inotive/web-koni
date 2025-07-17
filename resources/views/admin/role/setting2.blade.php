@extends('layouts.app')


@push('stack-css')

@endpush
@section('pageTitle', 'Manajemen Pengguna')
@section('mainSection', 'Karir')
{{-- @section('currentSection', 'Daftar Berita') --}}

@section('breadcrumb-title')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Halaman Jabatan</h1>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item text-gray-600">Jabatan</li>

@endsection

@section('content')
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Daftar Jabatan</span>
                </h3>

                <div class="card-toolbar d-flex gap-2">
                    <div class="col-5">
                        <input type="search" name="search" id="search" class="form-control" placeholder="Search">
                    </div>
                        <a href="#" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_tambah">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Jabatan</a>
                    </div>

            </div>
            <div class="card-body col-12">
                <div class="d-flex flex-wrap">
                    @foreach ($dataPermission as $value)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="gap-2 card-body d-flex flex-column justify-content-between">
                                        <h3 class="m-0 card-title">{{ $value->group }}</h3>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 permission-group" data-group="{{ $value->group }}">
                                                    <form id="checkboxForm">
                                                        @csrf
                                                        <div
                                                            class="mb-2 form-check form-check-custom form-check-solid form-check-sm">
                                                            <input type="hidden" id="roleId" value="{{ $data->id }}">
                                                            <input class="select-all form-check-input" type="checkbox"
                                                                value="" id="selectAll{{ $value->group }}"
                                                                data-group="{{ $value->group }}" />
                                                            <label class="form-check-label" for="selectAll{{ $value->group }}">
                                                                Semua Akses
                                                            </label>
                                                        </div>
                                                        @php
                                                            $names = explode(',', $value->names);
                                                            $displays = explode(',', $value->displays);
                                                            $id = explode(',', $value->id);
                                                        @endphp
    
                                                        @foreach ($names as $index => $name)
                                                            <div
                                                                class="mb-2 form-check form-check-custom form-check-solid form-check-sm">
                                                                <input
                                                                    class="form-check-input permission-group permission-checkbox"
                                                                    type="checkbox" name="permissions[]"
                                                                    value="{{ $id[$index] }}"
                                                                    data-group="{{ $value->group }}" id="{{ $id[$index] }}"
                                                                    {{ in_array($id[$index], $data->permissions->pluck('id')->toArray()) ? 'checked' : null }} />
                                                                <label class="form-check-label" for="{{ $id[$index] }}">
                                                                    {{ $displays[$index] }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".select-all").change(function() {
                let group = $(this).data("group");
                let checkboxes = $("[data-group='" + group + "'] .permission-checkbox");
                checkboxes.prop('checked', $(this).prop("checked"));
                updatePermissions();
            });

            $(".permission-checkbox").change(function() {
                let roleId = $('#roleId').val();
                let permissionId = $(this).val();
                let isChecked = $(this).prop('checked');

                if (isChecked) {
                    addSinglePermission(roleId, permissionId);
                } else {
                    removeSinglePermission(roleId, permissionId);
                }
            });

            function updatePermissions() {
                let roleId = $('#roleId').val();
                let permissions = [];
                $(".permission-checkbox:checked").each(function() {
                    permissions.push($(this).val());
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.manajemen-pengguna.role.updatePermissions') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        roleId: roleId,
                        permissions: permissions
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message || "Error updating permissions");
                    }
                });
            }

            function addSinglePermission(roleId, permissionId) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.manajemen-pengguna.role.updateSinglePermissions') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        roleId: roleId,
                        permissionId: permissionId
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message || "Error adding permission");
                    }
                });
            }

            function removeSinglePermission(roleId, permissionId) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.manajemen-pengguna.role.deletePermissions') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        roleId: roleId,
                        permissionId: permissionId
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message || "Error deleting permission");
                    }
                });
            }
        });
    </script>
@endsection
