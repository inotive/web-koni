<!-- Modal Tambah Pengguna -->
<div class="modal fade" tabindex="-1" id="kt_modal_tambah_pengguna">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Data Pengguna</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('admin.manajemen-pengguna.pengguna.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-5">
                        <label for="username" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan Nama"
                            required>
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="role" class="form-label">Jabatan</label>
                        <select class="form-select @error('role') is-invalid @enderror" name="role" id="role"
                            required>
                            <option value="" disabled selected hidden>Pilih Role</option>
                            @foreach ($roles as $item)
                                <option value="{{ $item->name }}" {{ old('role') == $item->name ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" placeholder="Masukkan Email" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" id="passwordInput" placeholder="Masukkan Password" required>
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="fa-solid fa-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn w-100 me-2"
                            style="background-color: #D20A11; color: white; border-radius: 8px;">
                            <i class="ki-duotone ki-plus fs-2" style="color: white"></i>Simpan Pengguna
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
            const passwordInput = document.getElementById("passwordInput");
            const togglePassword = document.getElementById("togglePassword");
            const toggleIcon = document.getElementById("toggleIcon");

            togglePassword.addEventListener("click", function() {
                const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                passwordInput.setAttribute("type", type);

                toggleIcon.classList.toggle("fa-eye");
                toggleIcon.classList.toggle("fa-eye-slash");
            });
        });
        const inputNama = $("#inputNama");

        inputNama?.on("input", function() {
            const inputValue = inputNama.val();
            const nonNumericValue = inputValue.replace(/[!@#$%^&*="()_+{}\[\]:;<>,.?~\\|0-9/'-]/g, '');
            if (inputValue !== nonNumericValue) {
                inputNama.val(nonNumericValue);
            }
        });
    </script>
@endpush
