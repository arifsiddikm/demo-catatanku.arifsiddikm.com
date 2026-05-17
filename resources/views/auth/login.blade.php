@extends('layouts.app')

@section('title', 'Login')
@section('meta_description', 'Masuk ke akun CatatanKu Anda dan mulai mencatat.')

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
            <p class="text-gray-500 text-sm mt-1">Catatan digital yang sederhana &amp; cepat</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Masuk ke Akun</h2>

            @if($errors->any())
            <div style="margin-bottom:1.25rem;padding:0.875rem 1rem;background:#fef2f2;border:1.5px solid #fecaca;border-radius:0.75rem;font-size:0.875rem;color:#dc2626;display:flex;align-items:flex-start;gap:0.5rem;">
                <svg style="width:1rem;height:1rem;margin-top:0.1rem;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom:1rem;">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="email@contoh.com" required autofocus>
                </div>

                <div style="margin-bottom:1rem;">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-right">
                        <input type="password" id="password" name="password"
                            class="form-input" placeholder="••••••••" required>
                        <button type="button" onclick="togglePassword('password')" class="input-icon-right" tabindex="-1">
                            <svg style="width:1.1rem;height:1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label class="form-check">
                        <input type="checkbox" id="remember" name="remember" class="form-checkbox">
                        <span class="form-check-label">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Masuk
                </button>
            </form>

            <div style="margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid #f3f4f6;">
                <p style="text-align:center;font-size:0.75rem;color:#9ca3af;margin-bottom:0.625rem;font-weight:500;">— Testing Akun —</p>
                <div style="display:flex;gap:0.5rem;">
                    <button type="button" onclick="autofillAdmin()"
                        style="flex:1;padding:0.5rem;font-size:0.8rem;font-weight:600;border-radius:0.625rem;border:1.5px solid #bfdbfe;background:#eff6ff;color:#2563eb;cursor:pointer;transition:all 0.15s;display:inline-flex;align-items:center;justify-content:center;gap:0.375rem;">
                        🔑 Admin
                    </button>
                    <button type="button" onclick="autofillUser()"
                        style="flex:1;padding:0.5rem;font-size:0.8rem;font-weight:600;border-radius:0.625rem;border:1.5px solid #fde68a;background:#fffbeb;color:#b45309;cursor:pointer;transition:all 0.15s;display:inline-flex;align-items:center;justify-content:center;gap:0.375rem;">
                        👤 User Demo
                    </button>
                </div>
            </div>
        </div>

        <p style="text-align:center;font-size:0.875rem;color:#6b7280;margin-top:1.5rem;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:#f59e0b;font-weight:600;text-decoration:none;">Daftar sekarang</a>
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
function autofillAdmin() {
    document.getElementById('email').value = 'admin@catatanku.com';
    document.getElementById('password').value = 'admin123';
}
function autofillUser() {
    document.getElementById('email').value = 'demo@catatanku.com';
    document.getElementById('password').value = 'demo123';
}
</script>
@endpush
