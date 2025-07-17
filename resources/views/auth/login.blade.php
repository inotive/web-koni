@extends('layouts.app-auth')

@section('content')
    <div class="d-flex flex-column flex-root min-vh-100">
        <div class="row g-0 flex-grow-1" style="min-height:100vh;">
            <!-- Left: Login Form -->
            <div class="col-lg-5 d-flex flex-column justify-content-center align-items-center bg-white px-4 px-lg-0">
                <div class="w-100" style="max-width:370px;">
                    <div class="text-center mb-4">
                        <img src="{{ asset('landing-assets/img/logo.png') }}" alt="Logo Varia Niaga" style="height:70px;">
                        <div class="fw-bold mt-2" style="font-size:1.2rem;">
                            <span style="color:#003C77">Perumda</span>
                            <span style="color:#FF6224">Varia Niaga</span>
                        </div>
                        <small class="text-muted" style="font-size:.85rem;">Samarinda</small>
                    </div>
                    <div class="card shadow-sm border-0 rounded-4 p-4">
                        <h5 class="fw-bold mb-3 text-center">Masuk</h5>
                        <form method="POST" action="{{ route('login-post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="email@example.com" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="********"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="d-flex justify-content-end mt-1">
                                    <a href="#" class="small" style="color:#FF6224">Lupa password?</a>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>
                            <button type="submit" class="btn w-100 text-white fw-bold"
                                style="background:#FF6224; height: 44px;">
                                <span>Masuk</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Illustration & Welcome -->
            <div class="col-lg-7 d-none d-lg-flex flex-column justify-content-center align-items-center px-0"
                style="background:#192846;">
                <div class="w-100 d-flex flex-column align-items-center" style="max-width:480px;">
                    <div class="mb-4 mt-5">
                        <h1 class="fw-bold text-white lh-base" style="font-size:3.1rem;">
                            Selamat Datang di <span style="color:#FF6224">Portal Manajemen Konten</span>
                        </h1>
                        <div class="text-white-50 mt-2 mb-4 f-4" style="font-size:1.5rem;">
                            Pusat kendali untuk mengelola dan mempublikasikan seluruh informasi digital Perumda Varia Niaga
                        </div>
                    </div>
                    <div class="mb-5">
                        <img src="{{ asset('assets/media/auth/bg-auth.png') }}" alt="Ilustrasi Konten"
                            class="img-fluid rounded-3 shadow-sm" style="max-width:100%; height:auto;">
                    </div>
                    <div class="text-white-50 small mb-3">© 2025 Perumda Varia Niaga. Hak Cipta Dilindungi.</div>
                </div>
            </div>
        </div>
    </div>
@endsection
