<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta -->
    <title>@yield('title', 'CatatanKu') - Catatan Digitalmu</title>
    <meta name="description" content="@yield('meta_description', 'CatatanKu - Aplikasi catatan digital sederhana dan cepat. Buat, kelola, dan organisir catatanmu dengan mudah.')">
    <meta name="keywords" content="catatan, notes, aplikasi catatan, catatan digital, CatatanKu">
    <meta name="author" content="CatatanKu">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'CatatanKu')">
    <meta property="og:description" content="@yield('meta_description', 'Aplikasi catatan digital sederhana dan cepat.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                        },
                        note: {
                            yellow: '#fef9c3',
                            blue: '#dbeafe',
                            green: '#dcfce7',
                            pink: '#fce7f3',
                            purple: '#ede9fe',
                            orange: '#ffedd5',
                            white: '#f9fafb',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS -->
    <style>
        *, *::before, *::after { box-sizing: border-box; font-family: 'Inter', sans-serif; }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #fbbf24; border-radius: 10px; }

        /* ===== MASONRY ===== */
        .masonry-grid { columns: 1; column-gap: 1rem; }
        @media (min-width: 640px)  { .masonry-grid { columns: 2; } }
        @media (min-width: 1024px) { .masonry-grid { columns: 3; } }
        @media (min-width: 1280px) { .masonry-grid { columns: 4; } }
        .masonry-item { break-inside: avoid; margin-bottom: 1rem; }

        /* ===== NOTE CARD ===== */
        .note-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .note-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); }

        /* ===== SIDEBAR ===== */
        #sidebar { transition: transform 0.3s ease; }
        .sidebar-item { display: flex; align-items: center; gap: 0.625rem; padding: 0.625rem 0.75rem; border-radius: 0.75rem; font-size: 0.875rem; font-weight: 500; color: #4b5563; text-decoration: none; transition: background 0.15s, color 0.15s; }
        .sidebar-item:hover { background-color: #fef9c3; color: #b45309; }
        .sidebar-item.active { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #ffffff !important; }

        /* ===== FORM LABEL ===== */
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.4rem;
        }

        /* ===== FORM INPUT (text, email, password, number, tel, url, date) ===== */
        .form-input {
            display: block;
            width: 100%;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            line-height: 1.6;
            color: #111827;
            background-color: #ffffff;
            border: 1.5px solid #e5e7eb;
            border-radius: 0.75rem;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            -webkit-appearance: none;
            appearance: none;
        }
        .form-input::placeholder { color: #9ca3af; }
        .form-input:focus {
            border-color: #fbbf24;
            box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.2);
        }
        .form-input:disabled {
            background-color: #f9fafb;
            color: #6b7280;
            cursor: not-allowed;
        }
        .form-input.error,
        .form-input.is-invalid {
            border-color: #f87171;
            box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.15);
        }

        /* ===== TEXTAREA ===== */
        textarea.form-input {
            resize: vertical;
            min-height: 100px;
        }

        /* ===== SELECT ===== */
        select.form-input {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
            padding-right: 2.5rem;
        }

        /* ===== CHECKBOX ===== */
        .form-checkbox {
            -webkit-appearance: none;
            appearance: none;
            width: 1.1rem;
            height: 1.1rem;
            border: 1.5px solid #d1d5db;
            border-radius: 0.3rem;
            background-color: #fff;
            cursor: pointer;
            transition: all 0.15s ease;
            flex-shrink: 0;
            position: relative;
            vertical-align: middle;
        }
        .form-checkbox:checked {
            background-color: #fbbf24;
            border-color: #fbbf24;
        }
        .form-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 0.22rem;
            top: 0.05rem;
            width: 0.4rem;
            height: 0.65rem;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
        }
        .form-checkbox:focus { outline: none; box-shadow: 0 0 0 3px rgba(251,191,36,0.25); }

        /* ===== RADIO ===== */
        .form-radio {
            -webkit-appearance: none;
            appearance: none;
            width: 1.1rem;
            height: 1.1rem;
            border: 1.5px solid #d1d5db;
            border-radius: 50%;
            background-color: #fff;
            cursor: pointer;
            transition: all 0.15s ease;
            flex-shrink: 0;
            position: relative;
            vertical-align: middle;
        }
        .form-radio:checked {
            border-color: #fbbf24;
            background-color: #fbbf24;
        }
        .form-radio:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0.35rem;
            height: 0.35rem;
            border-radius: 50%;
            background-color: #fff;
        }
        .form-radio:focus { outline: none; box-shadow: 0 0 0 3px rgba(251,191,36,0.25); }

        /* ===== CHECKBOX LABEL / RADIO LABEL WRAPPER ===== */
        .form-check { display: flex; align-items: center; gap: 0.5rem; }
        .form-check-label { font-size: 0.875rem; color: #4b5563; cursor: pointer; user-select: none; }

        /* ===== INPUT GROUP (icon inside) ===== */
        .input-group { position: relative; }
        .input-group .form-input { padding-left: 2.5rem; }
        .input-group .input-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            width: 1rem;
            height: 1rem;
        }
        .input-group-right .form-input { padding-right: 2.75rem; }
        .input-group-right .input-icon-right {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .input-group-right .input-icon-right:hover { color: #6b7280; }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            transition: background-color 0.15s ease, box-shadow 0.15s ease, transform 0.1s ease, border-color 0.15s ease;
            line-height: 1;
            -webkit-user-select: none;
            user-select: none;
        }
        .btn:focus { outline: none; }
        .btn:disabled { opacity: 0.55; cursor: not-allowed; transform: none !important; }

        /* Primary — Yellow */
        .btn-primary {
            background-color: #fbbf24;
            color: #ffffff;
            border: 1.5px solid #fbbf24;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .btn-primary:hover:not(:disabled) {
            background-color: #f59e0b;
            border-color: #f59e0b;
            box-shadow: 0 4px 12px rgba(251,191,36,0.35);
            transform: translateY(-1px);
        }
        .btn-primary:active { transform: translateY(0); }

        /* Secondary — Gray */
        .btn-secondary {
            background-color: #f3f4f6;
            color: #374151;
            border: 1.5px solid #e5e7eb;
        }
        .btn-secondary:hover:not(:disabled) {
            background-color: #e5e7eb;
            border-color: #d1d5db;
        }

        /* Danger — Red */
        .btn-danger {
            background-color: #ef4444;
            color: #ffffff;
            border: 1.5px solid #ef4444;
        }
        .btn-danger:hover:not(:disabled) {
            background-color: #dc2626;
            border-color: #dc2626;
            box-shadow: 0 4px 12px rgba(239,68,68,0.3);
        }

        /* Outline Yellow */
        .btn-outline {
            background-color: transparent;
            color: #d97706;
            border: 1.5px solid #fbbf24;
        }
        .btn-outline:hover:not(:disabled) {
            background-color: #fef3c7;
        }

        /* Ghost */
        .btn-ghost {
            background-color: transparent;
            color: #6b7280;
            border: 1.5px solid transparent;
        }
        .btn-ghost:hover:not(:disabled) {
            background-color: #f3f4f6;
            color: #374151;
        }

        /* Icon-only button */
        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            padding: 0;
            border-radius: 0.625rem;
            border: 1.5px solid #e5e7eb;
            background-color: #ffffff;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .btn-icon:hover { background-color: #fef9c3; color: #b45309; border-color: #fde68a; }
        .btn-icon.active { background-color: #ffffff; color: #f59e0b; border-color: #fde68a; box-shadow: 0 1px 4px rgba(0,0,0,0.08); }

        /* Full-width helper */
        .btn-block { width: 100%; }

        /* Size modifiers */
        .btn-sm { padding: 0.4rem 0.875rem; font-size: 0.8125rem; border-radius: 0.625rem; }
        .btn-lg { padding: 0.75rem 1.75rem; font-size: 1rem; border-radius: 0.875rem; }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp 0.3s ease forwards; }

        /* ===== NOTE COLORS ===== */
        .note-bg-yellow { background-color: #fef9c3; }
        .note-bg-blue   { background-color: #dbeafe; }
        .note-bg-green  { background-color: #dcfce7; }
        .note-bg-pink   { background-color: #fce7f3; }
        .note-bg-purple { background-color: #ede9fe; }
        .note-bg-orange { background-color: #ffedd5; }
        .note-bg-white  { background-color: #f9fafb; }

        /* ===== COLOR DOT PICKER (note & category) ===== */
        .color-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .color-dot {
            display: block;
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 50%;
            border: 2.5px solid transparent;
            cursor: pointer;
            transition: transform 0.15s, border-color 0.15s, box-shadow 0.15s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }
        .color-option input[type="radio"]:checked + .color-dot {
            border-color: #374151;
            transform: scale(1.18);
            box-shadow: 0 0 0 2px rgba(0,0,0,0.15);
        }
        .color-dot:hover { transform: scale(1.1); }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900">

@yield('content')

<!-- SweetAlert Flash Messages -->
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
    });
</script>
@endif
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', timer: 3000, showConfirmButton: false, toast: true, position: 'top-end' });
    });
</script>
@endif

@stack('scripts')
</body>
</html>
