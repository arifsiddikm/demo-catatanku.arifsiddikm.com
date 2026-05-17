@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('meta_description', 'Panel administrasi CatatanKu.')

@section('content')
<div style="min-height:100vh;background:#f9fafb;">

    {{-- Navbar --}}
    <nav style="background:#fff;border-bottom:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.04);position:sticky;top:0;z-index:20;">
        <div style="max-width:80rem;margin:0 auto;padding:1rem 1.5rem;display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div style="width:2.25rem;height:2.25rem;background:#fbbf24;border-radius:0.625rem;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(251,191,36,0.35);">
                    <svg style="width:1.2rem;height:1.2rem;" fill="white" viewBox="0 0 24 24">
                        <path d="M19 3H5C3.9 3 3 3.9 3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                </div>
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <span style="font-weight:700;font-size:1.125rem;color:#1f2937;">CatatanKu</span>
                    <span style="font-size:0.7rem;font-weight:700;padding:0.2rem 0.6rem;background:#dbeafe;color:#2563eb;border-radius:99px;">ADMIN</span>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <a href="{{ route('notes.index') }}" class="btn btn-ghost btn-sm">
                    <svg style="width:0.9rem;height:0.9rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ke Catatan
                </a>
                <button onclick="confirmLogout()" class="btn btn-ghost btn-sm" style="color:#ef4444;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                    <svg style="width:0.9rem;height:0.9rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </div>
        </div>
    </nav>

    <div style="max-width:80rem;margin:0 auto;padding:2rem 1.5rem;">

        {{-- Header --}}
        <div style="margin-bottom:2rem;">
            <h1 style="font-weight:700;font-size:1.5rem;color:#1f2937;margin:0 0 0.25rem;">Dashboard Admin</h1>
            <p style="font-size:0.875rem;color:#6b7280;margin:0;">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>

        {{-- Stats --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.25rem;margin-bottom:2rem;">
            {{-- Users --}}
            <div style="background:#fff;border-radius:1.25rem;padding:1.5rem;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.04);transition:box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 1px 4px rgba(0,0,0,0.04)'">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <div style="width:3rem;height:3rem;background:#dbeafe;border-radius:0.75rem;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:1.4rem;height:1.4rem;color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span style="font-size:0.7rem;font-weight:600;padding:0.2rem 0.6rem;background:#eff6ff;color:#3b82f6;border-radius:99px;">Total</span>
                </div>
                <div style="font-size:2rem;font-weight:700;color:#1f2937;line-height:1;">{{ number_format($totalUsers) }}</div>
                <div style="font-size:0.875rem;color:#6b7280;margin-top:0.25rem;">Pengguna Terdaftar</div>
            </div>

            {{-- Notes --}}
            <div style="background:#fff;border-radius:1.25rem;padding:1.5rem;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.04);transition:box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 1px 4px rgba(0,0,0,0.04)'">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <div style="width:3rem;height:3rem;background:#fef3c7;border-radius:0.75rem;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:1.4rem;height:1.4rem;color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span style="font-size:0.7rem;font-weight:600;padding:0.2rem 0.6rem;background:#fffbeb;color:#f59e0b;border-radius:99px;">Total</span>
                </div>
                <div style="font-size:2rem;font-weight:700;color:#1f2937;line-height:1;">{{ number_format($totalNotes) }}</div>
                <div style="font-size:0.875rem;color:#6b7280;margin-top:0.25rem;">Catatan Dibuat</div>
            </div>

            {{-- Categories --}}
            <div style="background:#fff;border-radius:1.25rem;padding:1.5rem;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.04);transition:box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 1px 4px rgba(0,0,0,0.04)'">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <div style="width:3rem;height:3rem;background:#dcfce7;border-radius:0.75rem;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:1.4rem;height:1.4rem;color:#22c55e;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <span style="font-size:0.7rem;font-weight:600;padding:0.2rem 0.6rem;background:#f0fdf4;color:#22c55e;border-radius:99px;">Total</span>
                </div>
                <div style="font-size:2rem;font-weight:700;color:#1f2937;line-height:1;">{{ number_format($totalCategories) }}</div>
                <div style="font-size:0.875rem;color:#6b7280;margin-top:0.25rem;">Kategori Terbuat</div>
            </div>
        </div>

        {{-- Users table --}}
        <div style="background:#fff;border-radius:1.25rem;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.04);overflow:hidden;">
            <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h2 style="font-weight:700;font-size:1rem;color:#1f2937;margin:0 0 0.2rem;">Daftar Pengguna</h2>
                    <p style="font-size:0.78rem;color:#9ca3af;margin:0;">Pengguna yang telah mendaftar</p>
                </div>
                <span style="font-size:0.78rem;font-weight:600;padding:0.3rem 0.75rem;background:#f3f4f6;color:#6b7280;border-radius:99px;">
                    {{ $recentUsers->total() }} pengguna
                </span>
            </div>

            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9fafb;">
                            <th style="text-align:left;font-size:0.72rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;padding:0.875rem 1.5rem;">#</th>
                            <th style="text-align:left;font-size:0.72rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;padding:0.875rem 1.5rem;">Nama</th>
                            <th style="text-align:left;font-size:0.72rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;padding:0.875rem 1.5rem;">Email</th>
                            <th style="text-align:center;font-size:0.72rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;padding:0.875rem 1.5rem;">Kategori</th>
                            <th style="text-align:center;font-size:0.72rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;padding:0.875rem 1.5rem;">Catatan</th>
                            <th style="text-align:left;font-size:0.72rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.06em;padding:0.875rem 1.5rem;">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                        <tr style="border-top:1px solid #f9fafb;transition:background 0.15s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                            <td style="padding:1rem 1.5rem;font-size:0.875rem;color:#9ca3af;">
                                {{ ($recentUsers->currentPage() - 1) * $recentUsers->perPage() + $loop->iteration }}
                            </td>
                            <td style="padding:1rem 1.5rem;">
                                <div style="display:flex;align-items:center;gap:0.75rem;">
                                    <div style="width:2.125rem;height:2.125rem;border-radius:50%;background:linear-gradient(135deg,#fde68a,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.8rem;font-weight:700;flex-shrink:0;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span style="font-size:0.875rem;font-weight:500;color:#1f2937;">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td style="padding:1rem 1.5rem;font-size:0.875rem;color:#6b7280;">{{ $user->email }}</td>
                            <td style="padding:1rem 1.5rem;text-align:center;">
                                <span style="display:inline-block;padding:0.2rem 0.6rem;background:#dcfce7;color:#16a34a;font-size:0.78rem;font-weight:700;border-radius:99px;">
                                    {{ $user->categories_count }}
                                </span>
                            </td>
                            <td style="padding:1rem 1.5rem;text-align:center;">
                                <span style="display:inline-block;padding:0.2rem 0.6rem;background:#fef3c7;color:#d97706;font-size:0.78rem;font-weight:700;border-radius:99px;">
                                    {{ $user->notes_count }}
                                </span>
                            </td>
                            <td style="padding:1rem 1.5rem;font-size:0.875rem;color:#9ca3af;">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding:4rem 1.5rem;text-align:center;color:#9ca3af;">
                                <div style="display:flex;flex-direction:column;align-items:center;gap:0.5rem;">
                                    <svg style="width:2.5rem;height:2.5rem;color:#e5e7eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span style="font-size:0.875rem;">Belum ada pengguna terdaftar</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($recentUsers->hasPages())
            <div style="padding:1rem 1.5rem;border-top:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;">
                <p style="font-size:0.78rem;color:#9ca3af;margin:0;">
                    Menampilkan {{ $recentUsers->firstItem() }}–{{ $recentUsers->lastItem() }} dari {{ $recentUsers->total() }}
                </p>
                <div style="display:flex;align-items:center;gap:0.375rem;">
                    @if($recentUsers->onFirstPage())
                        <span style="padding:0.375rem 0.875rem;font-size:0.78rem;color:#d1d5db;background:#f9fafb;border-radius:0.5rem;cursor:not-allowed;">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $recentUsers->previousPageUrl() }}" class="btn btn-ghost btn-sm">‹ Sebelumnya</a>
                    @endif
                    @if($recentUsers->hasMorePages())
                        <a href="{{ $recentUsers->nextPageUrl() }}" class="btn btn-ghost btn-sm">Berikutnya ›</a>
                    @else
                        <span style="padding:0.375rem 0.875rem;font-size:0.78rem;color:#d1d5db;background:#f9fafb;border-radius:0.5rem;cursor:not-allowed;">Berikutnya ›</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
@endsection

@push('scripts')
<script>
function confirmLogout() {
    Swal.fire({ title:'Keluar?', text:'Kamu akan keluar dari panel admin.', icon:'question', showCancelButton:true, confirmButtonColor:'#fbbf24', cancelButtonColor:'#6b7280', confirmButtonText:'Ya, Keluar', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) document.getElementById('logoutForm').submit(); });
}
</script>
@endpush
