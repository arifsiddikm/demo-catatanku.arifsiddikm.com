@extends('layouts.app')

@section('title', $activeCategory ? $activeCategory->name : 'Catatan')
@section('meta_description', 'Kelola catatan digitalmu dengan mudah di CatatanKu.')

@section('content')
<div style="display:flex;height:100vh;overflow:hidden;background:#f9fafb;">

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar" style="width:260px;background:#fff;border-right:1px solid #f3f4f6;display:flex;flex-direction:column;box-shadow:2px 0 8px rgba(0,0,0,0.04);flex-shrink:0;z-index:20;">

        {{-- Logo --}}
        <div style="padding:1.25rem 1.25rem 1rem;border-bottom:1px solid #f3f4f6;">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div style="width:2.25rem;height:2.25rem;background:#fbbf24;border-radius:0.625rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 6px rgba(251,191,36,0.35);">
                    <svg style="width:1.2rem;height:1.2rem;" fill="white" viewBox="0 0 24 24">
                        <path d="M19 3H5C3.9 3 3 3.9 3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                </div>
                <div>
                    <div style="font-weight:700;font-size:1.1rem;color:#1f2937;line-height:1.2;">CatatanKu</div>
                    <div style="font-size:0.75rem;color:#9ca3af;line-height:1.2;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Auth::user()->name }}</div>
                </div>
            </div>
        </div>

        {{-- Category list --}}
        <div style="flex:1;overflow-y:auto;padding:0.75rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:0 0.5rem;margin-bottom:0.5rem;">
                <span style="font-size:0.7rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Kategori</span>
                <button onclick="openAddCategory()" title="Tambah Kategori"
                    style="width:1.5rem;height:1.5rem;background:#fef3c7;border:none;border-radius:0.4rem;color:#d97706;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.15s;font-size:1rem;line-height:1;"
                    onmouseover="this.style.background='#fde68a'" onmouseout="this.style.background='#fef3c7'">+</button>
            </div>

            <nav style="display:flex;flex-direction:column;gap:2px;" id="categoryList">
                @foreach($categories as $cat)
                <div style="position:relative;" class="cat-row-{{ $cat->id }}">
                    <a href="{{ route('notes.index', ['category' => $cat->id]) }}"
                        class="sidebar-item {{ $activeCategory && $activeCategory->id == $cat->id ? 'active' : '' }}"
                        style="position:relative;padding-right:3.5rem;">
                        <span style="width:0.625rem;height:0.625rem;border-radius:50%;background:{{ $cat->color }};flex-shrink:0;display:inline-block;"></span>
                        <span style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $cat->name }}</span>
                        <span style="font-size:0.7rem;{{ $activeCategory && $activeCategory->id == $cat->id ? 'color:rgba(255,255,255,0.75)' : 'color:#9ca3af' }};">
                            {{ $cat->notes()->count() }}
                        </span>
                    </a>
                    {{-- Action buttons (shown on hover via JS) --}}
                    <div class="cat-actions" style="position:absolute;right:0.375rem;top:50%;transform:translateY(-50%);display:none;align-items:center;gap:2px;background:#fff;border:1px solid #f3f4f6;border-radius:0.5rem;padding:2px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                        <button onclick="openEditCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->color }}')"
                            style="width:1.4rem;height:1.4rem;border:none;background:none;cursor:pointer;border-radius:0.3rem;display:flex;align-items:center;justify-content:center;color:#9ca3af;transition:all 0.15s;"
                            onmouseover="this.style.background='#eff6ff';this.style.color='#3b82f6'" onmouseout="this.style.background='none';this.style.color='#9ca3af'">
                            <svg style="width:0.7rem;height:0.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button onclick="deleteCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}')"
                            style="width:1.4rem;height:1.4rem;border:none;background:none;cursor:pointer;border-radius:0.3rem;display:flex;align-items:center;justify-content:center;color:#9ca3af;transition:all 0.15s;"
                            onmouseover="this.style.background='#fef2f2';this.style.color='#ef4444'" onmouseout="this.style.background='none';this.style.color='#9ca3af'">
                            <svg style="width:0.7rem;height:0.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </nav>
        </div>

        {{-- Bottom actions --}}
        <div style="padding:0.75rem;border-top:1px solid #f3f4f6;">
            @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item" style="margin-bottom:2px;text-decoration:none;color:#3b82f6;">
                <svg style="width:1rem;height:1rem;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Panel Admin
            </a>
            @endif
            <button onclick="confirmLogout()" class="sidebar-item" style="width:100%;border:none;background:none;cursor:pointer;text-align:left;color:#ef4444;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='none'">
                <svg style="width:1rem;height:1rem;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </div>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <main style="flex:1;display:flex;flex-direction:column;overflow:hidden;">

        {{-- Top bar --}}
        <header style="background:#fff;border-bottom:1px solid #f3f4f6;padding:1rem 1.5rem;display:flex;align-items:center;gap:1rem;box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <h2 style="font-weight:700;font-size:1.125rem;color:#1f2937;white-space:nowrap;flex-shrink:0;">
                {{ $activeCategory ? $activeCategory->name : 'Semua Catatan' }}
            </h2>

            {{-- Search --}}
            <div class="input-group" style="flex:1;max-width:26rem;">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" value="{{ $search ?? '' }}"
                    class="form-input" placeholder="Cari catatan..."
                    style="background:#f9fafb;">
            </div>

            {{-- Actions --}}
            <div style="display:flex;align-items:center;gap:0.5rem;margin-left:auto;">
                {{-- Sort button --}}
                <button id="sortBtn" onclick="toggleSort()" title="Sortir Asc/Desc" class="btn-icon">
                    <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sort === 'asc' ? 'M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12' : 'M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4' }}"/>
                    </svg>
                </button>

                {{-- Layout toggle --}}
                <div style="display:flex;align-items:center;gap:2px;background:#f3f4f6;border-radius:0.625rem;padding:3px;">
                    <button onclick="setLayout('masonry')" id="btnMasonry"
                        style="width:2rem;height:2rem;border:none;cursor:pointer;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;transition:all 0.15s;{{ $layout === 'masonry' ? 'background:#fff;color:#f59e0b;box-shadow:0 1px 3px rgba(0,0,0,0.1);' : 'background:transparent;color:#9ca3af;' }}">
                        <svg style="width:0.9rem;height:0.9rem;" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h7v9H3zm11 0h7v5h-7zm0 8h7v9h-7zM3 15h7v6H3z"/></svg>
                    </button>
                    <button onclick="setLayout('list')" id="btnList"
                        style="width:2rem;height:2rem;border:none;cursor:pointer;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;transition:all 0.15s;{{ $layout === 'list' ? 'background:#fff;color:#f59e0b;box-shadow:0 1px 3px rgba(0,0,0,0.1);' : 'background:transparent;color:#9ca3af;' }}">
                        <svg style="width:0.9rem;height:0.9rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

                {{-- Add note --}}
                <button onclick="openAddNote()" class="btn btn-primary btn-sm">
                    <svg style="width:0.9rem;height:0.9rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Catatan Baru
                </button>
            </div>
        </header>

        {{-- Notes grid --}}
        <div style="flex:1;overflow-y:auto;padding:1.5rem;" id="notesContainer">
            <div id="notesGrid" class="{{ $layout === 'masonry' ? 'masonry-grid' : '' }}" style="{{ $layout === 'list' ? 'display:flex;flex-direction:column;gap:0.75rem;max-width:42rem;margin:0 auto;' : '' }}">
                @forelse($notes as $note)
                    @include('notes._note_card', ['note' => $note, 'layout' => $layout])
                @empty
                @endforelse
            </div>

            {{-- Empty state di luar grid agar tidak kena masonry --}}
            @if($notes->isEmpty())
            <div id="emptyState" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:5rem 1rem;text-align:center;">
                <div style="width:6rem;height:6rem;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem;box-shadow:0 4px 20px rgba(251,191,36,0.25);">
                    <svg style="width:3rem;height:3rem;color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p style="font-weight:700;font-size:1.125rem;color:#374151;margin:0 0 0.5rem;">Belum ada catatan</p>
                <p style="font-size:0.9rem;color:#9ca3af;margin:0 0 1.5rem;">Mulai abadikan idemu sekarang</p>
                <button onclick="openAddNote()" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.6rem 1.25rem;background:#fbbf24;color:#fff;border:none;border-radius:0.75rem;font-weight:600;font-size:0.875rem;cursor:pointer;box-shadow:0 2px 8px rgba(251,191,36,0.4);transition:all 0.15s;" onmouseover="this.style.background='#f59e0b'" onmouseout="this.style.background='#fbbf24'">
                    <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Buat Catatan Pertama
                </button>
            </div>
            @endif

            <div id="notesGridHidden" style="display:none;">
            </div>
        </div>
    </main>
</div>

{{-- ===== MODAL: ADD / EDIT NOTE ===== --}}
<div id="noteModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:50;align-items:center;justify-content:center;padding:1rem;">
    <div class="fade-in-up" style="background:#fff;border-radius:1.25rem;box-shadow:0 20px 60px rgba(0,0,0,0.18);width:100%;max-width:32rem;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;">
            <h3 style="font-weight:700;font-size:1.1rem;color:#1f2937;margin:0;" id="noteModalTitle">Tambah Catatan</h3>
            <button onclick="closeNoteModal()" style="width:2rem;height:2rem;background:#f3f4f6;border:none;border-radius:0.5rem;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#6b7280;transition:background 0.15s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                <svg style="width:0.9rem;height:0.9rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="noteForm" style="padding:1.25rem 1.5rem;">
            <input type="hidden" id="noteId">

            <div style="margin-bottom:1rem;">
                <label class="form-label" for="noteTitle">Judul Catatan <span style="color:#ef4444;">*</span></label>
                <input type="text" id="noteTitle" class="form-input" placeholder="Judul catatan..." required>
            </div>

            <div style="margin-bottom:1rem;">
                <label class="form-label" for="noteDescription">Deskripsi</label>
                <textarea id="noteDescription" class="form-input" rows="4" placeholder="Isi catatanmu di sini..."></textarea>
            </div>

            <div style="margin-bottom:1rem;">
                <label class="form-label" for="noteCategoryId">Kategori <span style="color:#ef4444;">*</span></label>
                <select id="noteCategoryId" class="form-input">
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $activeCategory && $activeCategory->id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:1.25rem;">
                <label class="form-label">Warna Catatan</label>
                <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
                    @foreach(['#fef9c3'=>'Kuning','#dbeafe'=>'Biru','#dcfce7'=>'Hijau','#fce7f3'=>'Pink','#ede9fe'=>'Ungu','#ffedd5'=>'Oranye','#f9fafb'=>'Putih'] as $color => $label)
                    <label class="color-option" title="{{ $label }}" style="position:relative;cursor:pointer;">
                        <input type="radio" name="noteColor" value="{{ $color }}" {{ $color === '#fef9c3' ? 'checked' : '' }}>
                        <span class="color-dot" style="background-color:{{ $color }};"></span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div style="display:flex;gap:0.75rem;">
                <button type="button" onclick="closeNoteModal()" class="btn btn-secondary" style="flex:1;">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex:1;">Simpan Catatan</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL: ADD / EDIT CATEGORY ===== --}}
<div id="categoryModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:50;align-items:center;justify-content:center;padding:1rem;">
    <div class="fade-in-up" style="background:#fff;border-radius:1.25rem;box-shadow:0 20px 60px rgba(0,0,0,0.18);width:100%;max-width:22rem;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;">
            <h3 style="font-weight:700;font-size:1rem;color:#1f2937;margin:0;" id="categoryModalTitle">Tambah Kategori</h3>
            <button onclick="closeCategoryModal()" style="width:2rem;height:2rem;background:#f3f4f6;border:none;border-radius:0.5rem;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#6b7280;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                <svg style="width:0.9rem;height:0.9rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="categoryForm" style="padding:1.25rem 1.5rem;">
            <input type="hidden" id="categoryId">

            <div style="margin-bottom:1rem;">
                <label class="form-label" for="categoryName">Nama Kategori <span style="color:#ef4444;">*</span></label>
                <input type="text" id="categoryName" class="form-input" placeholder="Contoh: Pekerjaan, Pribadi..." required>
            </div>

            <div style="margin-bottom:1.25rem;">
                <label class="form-label">Warna</label>
                <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
                    @foreach(['#FBBF24','#60A5FA','#34D399','#F472B6','#A78BFA','#FB923C','#94A3B8'] as $color)
                    <label class="color-option" style="position:relative;cursor:pointer;">
                        <input type="radio" name="categoryColor" value="{{ $color }}" {{ $color === '#FBBF24' ? 'checked' : '' }}>
                        <span class="color-dot" style="background-color:{{ $color }};"></span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div style="display:flex;gap:0.75rem;">
                <button type="button" onclick="closeCategoryModal()" class="btn btn-secondary" style="flex:1;">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex:1;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let currentLayout = '{{ $layout }}';
let currentSort   = '{{ $sort }}';
let currentSortBy = '{{ $sortBy }}';
let currentCategory = '{{ $categoryId }}';
let searchTimeout = null;

// ---- Sidebar hover for category actions ----
document.querySelectorAll('.cat-row-' + '{{ $activeCategory?->id }}').forEach(() => {});
document.querySelectorAll('[class^="cat-row-"]').forEach(row => {
    const actions = row.querySelector('.cat-actions');
    if (!actions) return;
    row.addEventListener('mouseenter', () => actions.style.display = 'flex');
    row.addEventListener('mouseleave', () => actions.style.display = 'none');
});

// ---- Search ----
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => loadNotes(), 400);
});

// ---- Layout ----
function setLayout(layout) {
    currentLayout = layout;
    const grid = document.getElementById('notesGrid');
    if (layout === 'masonry') {
        grid.className = 'masonry-grid';
        grid.style.cssText = '';
    } else {
        grid.className = '';
        grid.style.cssText = 'display:flex;flex-direction:column;gap:0.75rem;max-width:42rem;margin:0 auto;';
    }
    const btnM = document.getElementById('btnMasonry');
    const btnL = document.getElementById('btnList');
    btnM.style.cssText = layout==='masonry'
        ? 'width:2rem;height:2rem;border:none;cursor:pointer;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;transition:all 0.15s;background:#fff;color:#f59e0b;box-shadow:0 1px 3px rgba(0,0,0,0.1);'
        : 'width:2rem;height:2rem;border:none;cursor:pointer;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;transition:all 0.15s;background:transparent;color:#9ca3af;';
    btnL.style.cssText = layout==='list'
        ? 'width:2rem;height:2rem;border:none;cursor:pointer;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;transition:all 0.15s;background:#fff;color:#f59e0b;box-shadow:0 1px 3px rgba(0,0,0,0.1);'
        : 'width:2rem;height:2rem;border:none;cursor:pointer;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;transition:all 0.15s;background:transparent;color:#9ca3af;';
}

// ---- Sort ----
function toggleSort() {
    currentSort = currentSort === 'desc' ? 'asc' : 'desc';
    loadNotes();
}

// ---- Load Notes (AJAX) ----
function loadNotes() {
    const search = document.getElementById('searchInput').value;
    const params = new URLSearchParams({ category: currentCategory, search, sort: currentSort, sort_by: currentSortBy });
    fetch(`/api/notes?${params}`, { headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => { if (data.success) renderNotes(data.notes); });
}

function renderNotes(notes) {
    const grid = document.getElementById('notesGrid');
    const container = document.getElementById('notesContainer');
    let emptyEl = document.getElementById('emptyState');
    if (notes.length === 0) {
        grid.innerHTML = '';
        if (!emptyEl) {
            emptyEl = document.createElement('div');
            emptyEl.id = 'emptyState';
            emptyEl.style.cssText = 'display:flex;flex-direction:column;align-items:center;justify-content:center;padding:5rem 1rem;text-align:center;';
            emptyEl.innerHTML = `<div style="width:6rem;height:6rem;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem;box-shadow:0 4px 20px rgba(251,191,36,0.25);">
                <svg style="width:3rem;height:3rem;color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p style="font-weight:700;font-size:1.125rem;color:#374151;margin:0 0 0.5rem;">Belum ada catatan</p>
            <p style="font-size:0.9rem;color:#9ca3af;margin:0 0 1.5rem;">Mulai abadikan idemu sekarang</p>
            <button onclick="openAddNote()" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.6rem 1.25rem;background:#fbbf24;color:#fff;border:none;border-radius:0.75rem;font-weight:600;font-size:0.875rem;cursor:pointer;box-shadow:0 2px 8px rgba(251,191,36,0.4);" onmouseover="this.style.background='#f59e0b'" onmouseout="this.style.background='#fbbf24'">
                <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Buat Catatan Pertama
            </button>`;
            container.appendChild(emptyEl);
        } else {
            emptyEl.style.display = 'flex';
        }
        return;
    }
    if (emptyEl) emptyEl.style.display = 'none';

    grid.innerHTML = notes.map(note => {
        const wrapClass = currentLayout === 'masonry' ? 'masonry-item' : '';
        const date = new Date(note.updated_at).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' });
        return `<div class="${wrapClass} note-card fade-in-up" style="background:${note.color||'#fef9c3'};border-radius:1rem;padding:1rem;border:1px solid rgba(0,0,0,0.06);position:relative;" data-note-id="${note.id}"
            onmouseenter="this.querySelector('.note-acts').style.opacity='1'" onmouseleave="this.querySelector('.note-acts').style.opacity='0'">
            ${note.is_pinned ? '<span style="position:absolute;top:0.5rem;right:0.5rem;font-size:0.8rem;">📌</span>' : ''}
            <h4 style="font-weight:600;font-size:0.9rem;color:#1f2937;margin:0 0 0.5rem;padding-right:1.25rem;line-height:1.35;">${esc(note.title)}</h4>
            ${note.description ? `<p style="font-size:0.8rem;color:#4b5563;line-height:1.5;margin:0 0 0.75rem;">${esc(note.description)}</p>` : ''}
            <div style="display:flex;align-items:center;justify-content:space-between;padding-top:0.5rem;border-top:1px solid rgba(0,0,0,0.06);">
                <span style="font-size:0.72rem;color:#9ca3af;">${date}</span>
                <div class="note-acts" style="display:flex;align-items:center;gap:2px;opacity:0;transition:opacity 0.2s;">
                    <button onclick="togglePin(${note.id})" title="${note.is_pinned?'Lepas sematkan':'Sematkan'}"
                        style="width:1.75rem;height:1.75rem;border:none;background:none;cursor:pointer;border-radius:0.375rem;display:flex;align-items:center;justify-content:center;font-size:0.8rem;transition:background 0.15s;"
                        onmouseover="this.style.background='rgba(0,0,0,0.08)'" onmouseout="this.style.background='none'">
                        ${note.is_pinned ? '📌' : '📍'}
                    </button>
                    <button onclick='openEditNote(${JSON.stringify(note)})'
                        style="width:1.75rem;height:1.75rem;border:none;background:none;cursor:pointer;border-radius:0.375rem;display:flex;align-items:center;justify-content:center;color:#6b7280;transition:background 0.15s;"
                        onmouseover="this.style.background='rgba(0,0,0,0.08)'" onmouseout="this.style.background='none'">
                        <svg style="width:0.8rem;height:0.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button onclick="deleteNote(${note.id})"
                        style="width:1.75rem;height:1.75rem;border:none;background:none;cursor:pointer;border-radius:0.375rem;display:flex;align-items:center;justify-content:center;color:#6b7280;transition:all 0.15s;"
                        onmouseover="this.style.background='#fef2f2';this.style.color='#ef4444'" onmouseout="this.style.background='none';this.style.color='#6b7280'">
                        <svg style="width:0.8rem;height:0.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>
        </div>`;
    }).join('');
}

function esc(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ---- Note Modal ----
function openAddNote() {
    document.getElementById('noteModalTitle').textContent = 'Tambah Catatan';
    document.getElementById('noteId').value = '';
    document.getElementById('noteTitle').value = '';
    document.getElementById('noteDescription').value = '';
    const first = document.querySelector('input[name="noteColor"]');
    if (first) first.checked = true;
    showModal('noteModal');
    setTimeout(() => document.getElementById('noteTitle').focus(), 50);
}

function openEditNote(note) {
    document.getElementById('noteModalTitle').textContent = 'Edit Catatan';
    document.getElementById('noteId').value = note.id;
    document.getElementById('noteTitle').value = note.title;
    document.getElementById('noteDescription').value = note.description || '';
    document.getElementById('noteCategoryId').value = note.category_id;
    const cr = document.querySelector(`input[name="noteColor"][value="${note.color}"]`);
    if (cr) cr.checked = true;
    showModal('noteModal');
}

function closeNoteModal() { hideModal('noteModal'); }

document.getElementById('noteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('noteId').value;
    const colorEl = document.querySelector('input[name="noteColor"]:checked');
    const data = {
        title: document.getElementById('noteTitle').value,
        description: document.getElementById('noteDescription').value,
        category_id: document.getElementById('noteCategoryId').value,
        color: colorEl ? colorEl.value : '#fef9c3',
        _token: CSRF,
    };
    const url = id ? `/notes/${id}` : '/notes';
    const params = new URLSearchParams();
    params.append('_token', CSRF);
    params.append('title', data.title);
    params.append('description', data.description);
    params.append('category_id', data.category_id);
    params.append('color', data.color);
    if (id) params.append('_method', 'PUT');
    fetch(url, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded','X-CSRF-TOKEN':CSRF,'Accept':'application/json'}, body: params.toString() })
        .then(r => r.json())
        .then(res => {
            if (res.success) { closeNoteModal(); toast('success', res.message); loadNotes(); }
            else toast('error', res.message || 'Gagal!');
        }).catch(() => toast('error', 'Terjadi kesalahan server!'));
});

// ---- Category Modal ----
function openAddCategory() {
    document.getElementById('categoryModalTitle').textContent = 'Tambah Kategori';
    document.getElementById('categoryId').value = '';
    document.getElementById('categoryName').value = '';
    const first = document.querySelector('input[name="categoryColor"]');
    if (first) first.checked = true;
    showModal('categoryModal');
    setTimeout(() => document.getElementById('categoryName').focus(), 50);
}

function openEditCategory(id, name, color) {
    document.getElementById('categoryModalTitle').textContent = 'Edit Kategori';
    document.getElementById('categoryId').value = id;
    document.getElementById('categoryName').value = name;
    const cr = document.querySelector(`input[name="categoryColor"][value="${color}"]`);
    if (cr) cr.checked = true;
    showModal('categoryModal');
}

function closeCategoryModal() { hideModal('categoryModal'); }

document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('categoryId').value;
    const colorEl = document.querySelector('input[name="categoryColor"]:checked');
    const data = { name: document.getElementById('categoryName').value, color: colorEl ? colorEl.value : '#FBBF24', _token: CSRF };
    const url = id ? `/categories/${id}` : '/categories';
    const params = new URLSearchParams();
    params.append('_token', CSRF);
    params.append('name', data.name);
    params.append('color', data.color);
    if (id) params.append('_method', 'PUT');
    fetch(url, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded','X-CSRF-TOKEN':CSRF,'Accept':'application/json'}, body: params.toString() })
        .then(r => r.json())
        .then(res => {
            if (res.success) { closeCategoryModal(); toast('success', res.message); setTimeout(() => location.reload(), 700); }
            else toast('error', res.message || 'Gagal!');
        }).catch(() => toast('error', 'Terjadi kesalahan server!'));
});

function deleteCategory(id, name) {
    Swal.fire({ title:'Hapus Kategori?', text:`"${name}" dan semua catatannya akan dihapus!`, icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#6b7280', confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal' })
        .then(r => {
            if (!r.isConfirmed) return;
            const p = new URLSearchParams({_token: CSRF, _method: 'DELETE'});
            fetch(`/categories/${id}`, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded','X-CSRF-TOKEN':CSRF,'Accept':'application/json'}, body: p.toString() })
                .then(r => r.json()).then(res => {
                    if (res.success) { toast('success', res.message); setTimeout(() => location.reload(), 700); }
                    else toast('error', res.message);
                }).catch(() => toast('error', 'Terjadi kesalahan server!'));
        });
}

// ---- Note actions ----
function deleteNote(id) {
    Swal.fire({ title:'Hapus Catatan?', text:'Catatan ini akan dihapus permanen!', icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#6b7280', confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal' })
        .then(r => {
            if (!r.isConfirmed) return;
            const p = new URLSearchParams({_token: CSRF, _method: 'DELETE'});
            fetch(`/notes/${id}`, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded','X-CSRF-TOKEN':CSRF,'Accept':'application/json'}, body: p.toString() })
                .then(r => r.json()).then(res => { if (res.success) { toast('success', res.message); loadNotes(); } })
                .catch(() => toast('error', 'Terjadi kesalahan server!'));
        });
}

function togglePin(id) {
    const p = new URLSearchParams({_token: CSRF, _method: 'PATCH'});
    fetch(`/notes/${id}/pin`, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded','X-CSRF-TOKEN':CSRF,'Accept':'application/json'}, body: p.toString() })
        .then(r => r.json()).then(res => { if (res.success) { toast('success', res.message); loadNotes(); } })
        .catch(() => toast('error', 'Terjadi kesalahan server!'));
}

// ---- Logout ----
function confirmLogout() {
    Swal.fire({ title:'Keluar?', text:'Kamu akan keluar dari CatatanKu.', icon:'question', showCancelButton:true, confirmButtonColor:'#fbbf24', cancelButtonColor:'#6b7280', confirmButtonText:'Ya, Keluar', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) document.getElementById('logoutForm').submit(); });
}

// ---- Helpers ----
function showModal(id) { const m = document.getElementById(id); m.style.display='flex'; }
function hideModal(id)  { const m = document.getElementById(id); m.style.display='none'; }
function toast(type, msg) {
    Swal.fire({ icon: type, title: msg, timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
}

// Close modals on backdrop click
['noteModal','categoryModal'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
});
</script>
@endpush
