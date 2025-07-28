@extends('layouts.app-auth')
<style>
    html,
    body {
        overflow: hidden;
        height: 100%;
    }
</style>

@section('content')
    <div class="row g-0 flex-grow-1 w-100" style="min-height:100vh; overflow: hidden;">
        <!-- Left: Illustration & Welcome -->
        <div class="col-lg-7 d-none d-lg-flex flex-column justify-content-start align-items-center px-0 pt-7"
            style="
        background: url('{{ asset('assets/img/kantor-koni.png') }}') 10% center / cover no-repeat;
        height: 100vh;
        max-width: 100%;
        position: relative;
    ">
        </div>


        <!-- Right: Login Form -->
        <div class="col-lg-5 d-flex flex-column justify-content-center align-items-center bg-white px-4 px-lg-0">
            <div class="w-100" style="max-width:370px;">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/koni.png') }}" alt="Logo KONI" style="height:70px;">
                </div>
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h5 class="fw-bold mb-3 text-center">Masuk</h5>
                    <form method="POST" action="{{ route('login-post') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com"
                                value="{{ old('email') }}" required autofocus>
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
                                <a href="#" class="small" style="color:#D20A11">Lupa password?</a>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <button type="submit" class="btn w-100 text-white fw-bold"
                            style="background:#D20A11; height: 44px;">
                            <span>Masuk</span>
                        </button>
                    </form>
                </div>
                {{-- Copyright di kanan --}}
                <div class="text-end text-muted small mt-4">
                    © 2025 KONI Tabalong. Hak Cipta Dilindungi.
                </div>
            </div>
        </div>
    </div>
@endsection
