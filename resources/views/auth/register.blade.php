@extends('layouts.app')

@section('title', 'Daftar Akun')
@section('meta_description', 'Buat akun CatatanKu gratis dan mulai mencatat hari ini.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-blue-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-400 rounded-2xl shadow-lg mb-4">
                <svg style="width:2.25rem;height:2.25rem;" fill="white" viewBox="0 0 24 24">
                    <path d="M19 3H5C3.9 3 3 3.9 3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">CatatanKu</h1>
            <p class="text-gray-500 text-sm mt-1">Buat akun gratis sekarang</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Daftar Akun Baru</h2>

            @if($errors->any())
            <div style="margin-bottom:1.25rem;padding:0.875rem 1rem;background:#fef2f2;border:1.5px solid #fecaca;border-radius:0.75rem;font-size:0.875rem;color:#dc2626;">
                <ul style="margin:0;padding-left:1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div style="margin-bottom:1rem;">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                        value="{{ old('name') }}"
                        class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                        placeholder="Nama kamu" required autofocus>
                </div>

                <div style="margin-bottom:1rem;">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="email@contoh.com" required>
                </div>

                <div style="margin-bottom:1rem;">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-right">
                        <input type="password" id="password" name="password"
                            class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                            placeholder="Min. 6 karakter" required>
                        <button type="button" onclick="togglePassword('password')" class="input-icon-right" tabindex="-1">
                            <svg style="width:1.1rem;height:1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-group input-group-right">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-input" placeholder="Ulangi password" required>
                        <button type="button" onclick="togglePassword('password_confirmation')" class="input-icon-right" tabindex="-1">
                            <svg style="width:1.1rem;height:1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Buat Akun
                </button>
            </form>
        </div>

        <p style="text-align:center;font-size:0.875rem;color:#6b7280;margin-top:1.5rem;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color:#f59e0b;font-weight:600;text-decoration:none;">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(id) {
    const el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
}
</script>
@endpush
