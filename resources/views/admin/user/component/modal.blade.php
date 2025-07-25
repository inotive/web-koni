<!-- Modal Edit Pengguna -->
<div class="modal fade" id="modalEditPengguna{{ $value->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Data Pengguna</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"></i>
                </div>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('admin.manajemen-pengguna.pengguna.update', $value->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label for="username{{ $value->id }}" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="username{{ $value->id }}" name="username"
                            value="{{ old('username', $value->username) }}" required>
                    </div>

                    <div class="mb-5">
                        <label for="role{{ $value->id }}" class="form-label">Jabatan</label>
                        <select class="form-select" name="role" id="role{{ $value->id }}" data-control="select2"
                            required>
                            @foreach ($roles as $item)
                                <option value="{{ $item->name }}"
                                    {{ $value->getRoleNames()->first() == $item->name ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="email{{ $value->id }}" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email{{ $value->id }}"
                            value="{{ old('email', $value->email) }}" required>
                    </div>

                    <div class="mb-5">
                        <label for="password{{ $value->id }}" class="form-label">Kata Sandi (Opsional)</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password"
                                id="passwordInput{{ $value->id }}" placeholder="Kosongkan jika tidak diubah">
                            <span class="input-group-text toggle-password" data-id="{{ $value->id }}"
                                style="cursor: pointer;">
                                <i class="fa-solid fa-eye" id="toggleIcon{{ $value->id }}"></i>
                            </span>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn w-100"
                            style="background-color: #D20A11; color: white; border-radius: 8px;">
                            <i class="ki-duotone ki-pencil fs-2" style="color: white"></i>Update Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('stack-script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-password").forEach(btn => {
                btn.addEventListener("click", function() {
                    const id = this.dataset.id;
                    const input = document.getElementById(`passwordInput${id}`);
                    const icon = document.getElementById(`toggleIcon${id}`);
                    const type = input.getAttribute("type") === "password" ? "text" : "password";
                    input.setAttribute("type", type);
                    icon.classList.toggle("fa-eye");
                    icon.classList.toggle("fa-eye-slash");
                });
            });
        });
    </script>
@endpush
