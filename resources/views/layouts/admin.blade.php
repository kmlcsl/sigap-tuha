<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="SIGAP TUHA Admin Panel - Sistem Informasi Gerak Aksi Peduli Terhadap Usia Harapan Aman">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Panel' }} — SIGAP TUHA</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            /* Brand Palette */
            --brand-50:  #eef4ff;
            --brand-100: #dae6ff;
            --brand-200: #bdd4ff;
            --brand-300: #90b8ff;
            --brand-400: #6194fd;
            --brand-500: #3b6cf9;
            --brand-600: #254aee;
            --brand-700: #1d37db;
            --brand-800: #1f2fb1;
            --brand-900: #1f2d8c;
            --brand-950: #0b1340;

            /* Neutral Palette */
            --gray-25:  #fcfcfd;
            --gray-50:  #f8f9fb;
            --gray-100: #f0f2f5;
            --gray-200: #e4e7ec;
            --gray-300: #cdd3dc;
            --gray-400: #98a2b3;
            --gray-500: #667085;
            --gray-600: #475467;
            --gray-700: #344054;
            --gray-800: #1d2939;
            --gray-900: #101828;

            /* Semantic */
            --success-50: #ecfdf3; --success-500: #12b76a; --success-700: #027a48;
            --warning-50: #fffaeb; --warning-500: #f79009; --warning-700: #b54708;
            --danger-50:  #fef3f2; --danger-500:  #f04438; --danger-700:  #b42318;
            --info-50:    #eff8ff; --info-500:    #2e90fa; --info-700:    #175cd3;

            /* Layout */
            --sidebar-w: 268px;
            --header-h: 64px;
            --content-max-w: 1400px;

            /* Surfaces */
            --surface-primary: #ffffff;
            --surface-secondary: var(--gray-50);
            --surface-elevated: #ffffff;
            --surface-overlay: rgba(16, 24, 40, 0.55);

            /* Borders */
            --border-primary: var(--gray-200);
            --border-secondary: var(--gray-100);

            /* Text */
            --text-primary: var(--gray-900);
            --text-secondary: var(--gray-600);
            --text-tertiary: #000000;
            --text-placeholder: var(--gray-400);
            --text-on-brand: #ffffff;

            /* Shadows */
            --shadow-xs:  0 1px 2px rgba(16, 24, 40, 0.05);
            --shadow-sm:  0 1px 3px rgba(16, 24, 40, 0.1), 0 1px 2px -1px rgba(16, 24, 40, 0.1);
            --shadow-md:  0 4px 8px -2px rgba(16, 24, 40, 0.1), 0 2px 4px -2px rgba(16, 24, 40, 0.06);
            --shadow-lg:  0 12px 16px -4px rgba(16, 24, 40, 0.08), 0 4px 6px -2px rgba(16, 24, 40, 0.03);
            --shadow-xl:  0 20px 24px -4px rgba(16, 24, 40, 0.08), 0 8px 8px -4px rgba(16, 24, 40, 0.03);
            --shadow-2xl: 0 24px 48px -12px rgba(16, 24, 40, 0.18);
            --shadow-brand: 0 4px 14px rgba(37, 74, 238, 0.25);
            --shadow-glow: 0 0 20px rgba(59, 108, 249, 0.15);

            /* Radius */
            --radius-xs: 4px;
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --radius-2xl: 20px;
            --radius-full: 9999px;

            /* Motion */
            --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-in-out: cubic-bezier(0.65, 0, 0.35, 1);
            --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
            --duration-fast: 150ms;
            --duration-base: 250ms;
            --duration-slow: 400ms;
        }

        /* ── Reset ── */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
            background: var(--surface-secondary);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; cursor: pointer; }
        img { max-width: 100%; display: block; }

        /* ── App Shell ── */
        .admin-shell {
            display: flex;
            min-height: 100vh;
            min-height: 100dvh;
        }

        /* ══════════════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════════════ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: var(--surface-primary);
            border-right: 1px solid var(--border-secondary);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform var(--duration-slow) var(--ease-out);
            will-change: transform;
        }

        /* Decorative gradient stripe on the left edge */
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: linear-gradient(
                180deg,
                var(--brand-500) 0%,
                var(--brand-700) 35%,
                var(--success-500) 65%,
                var(--warning-500) 100%
            );
            z-index: 1;
        }

        /* ── Sidebar Header ── */
        .sidebar__header {
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--border-secondary);
            flex-shrink: 0;
        }

        .sidebar__brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar__logo {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-lg);
            background: linear-gradient(135deg, var(--brand-600) 0%, var(--brand-800) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: 14px;
            letter-spacing: -0.02em;
            flex-shrink: 0;
            box-shadow: var(--shadow-brand);
            position: relative;
            overflow: hidden;
        }

        .sidebar__logo::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.12) 50%, transparent 70%);
            animation: shimmer 4s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }

        .sidebar__title {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .sidebar__subtitle {
            font-size: 11px;
            font-weight: 500;
            color: var(--text-tertiary);
            margin-top: 2px;
            letter-spacing: 0.02em;
        }

        /* ── Sidebar Nav ── */
        .sidebar__nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: var(--gray-200) transparent;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }

        .sidebar__nav::-webkit-scrollbar { width: 4px; }
        .sidebar__nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar__nav::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: var(--radius-full); }

        .nav-group { margin-bottom: 24px; }

        .nav-group__label {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-placeholder);
            padding: 0 12px;
            margin-bottom: 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius-md);
            border: none;
            background: #e2e8f0; /* Inactive: distinct solid gray */
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-secondary);
            transition: all var(--duration-fast) var(--ease-out);
            position: relative;
            margin-bottom: 6px;
        }

        .nav-link:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
            color: var(--text-primary);
        }

        .nav-link.active {
            background: var(--brand-50);
            color: var(--brand-700);
            font-weight: 600;
        }

        .nav-link.active .nav-link__icon {
            color: var(--brand-600);
        }

        .nav-link__icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 15px;
            color: var(--text-tertiary);
            transition: color var(--duration-fast) var(--ease-out);
        }

        .nav-link:hover .nav-link__icon {
            color: var(--text-primary);
        }

        .nav-link__text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-link__badge {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: var(--radius-full);
            background: var(--danger-50);
            color: var(--danger-700);
            line-height: 1.4;
        }

        .nav-link__badge.success {
            background: var(--success-50);
            color: var(--success-700);
        }

        .nav-link__ext-icon {
            font-size: 10px;
            color: var(--text-placeholder);
        }

        /* ── Sidebar Footer ── */
        .sidebar__footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border-secondary);
            flex-shrink: 0;
        }

        .sidebar__user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius-lg);
            background: var(--gray-50);
            transition: background var(--duration-fast) var(--ease-out);
        }

        .sidebar__user:hover {
            background: var(--gray-100);
        }

        .sidebar__avatar {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, var(--brand-500) 0%, var(--success-500) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }

        .sidebar__user-info { flex: 1; min-width: 0; }

        .sidebar__user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar__user-role {
            font-size: 11px;
            color: var(--text-tertiary);
        }

        .sidebar__logout-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: transparent;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-tertiary);
            font-size: 14px;
            transition: all var(--duration-fast) var(--ease-out);
            flex-shrink: 0;
        }

        .sidebar__logout-btn:hover {
            background: var(--danger-50);
            color: var(--danger-500);
        }

        /* ══════════════════════════════════════════════
           MAIN CONTENT AREA
        ══════════════════════════════════════════════ */
        .main-area {
            flex: 1;
            min-width: 0; /* Mencegah layout rusak karena child lebar */
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
            transition: margin-left var(--duration-slow) var(--ease-out);
        }

        /* ── Topbar ── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 500;
            height: var(--header-h);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-bottom: 1px solid var(--border-secondary);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
        }

        /* Hamburger Toggle */
        .topbar__toggle {
            display: none;
            width: 40px;
            height: 40px;
            border: none;
            background: var(--gray-50);
            border-radius: var(--radius-md);
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
            color: var(--text-primary);
            transition: all var(--duration-fast) var(--ease-out);
        }

        .topbar__toggle:hover {
            background: var(--brand-50);
            color: var(--brand-600);
        }

        /* Page Info */
        .topbar__page-info {
            flex: 1;
            min-width: 0;
        }

        .topbar__breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-tertiary);
            margin-bottom: 1px;
        }

        .topbar__breadcrumb a {
            color: var(--text-tertiary);
            transition: color var(--duration-fast);
        }

        .topbar__breadcrumb a:hover {
            color: var(--brand-600);
        }

        .topbar__breadcrumb-sep {
            font-size: 10px;
            color: var(--gray-300);
        }

        .topbar__page-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Search */
        .topbar__search {
            position: relative;
            width: 260px;
            flex-shrink: 0;
        }

        .topbar__search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-placeholder);
            font-size: 13px;
            pointer-events: none;
        }

        .topbar__search-input {
            width: 100%;
            padding: 9px 60px 9px 34px;
            border: 1px solid var(--border-primary);
            border-radius: var(--radius-md);
            font-size: 13px;
            font-family: inherit;
            background: var(--gray-50);
            color: var(--text-primary);
            transition: all var(--duration-fast) var(--ease-out);
        }

        .topbar__search-input::placeholder { color: var(--text-placeholder); }

        .topbar__search-input:focus {
            outline: none;
            border-color: var(--brand-400);
            background: var(--surface-primary);
            box-shadow: 0 0 0 3px var(--brand-100);
        }

        .topbar__search-shortcut {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 10px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 500;
            color: var(--text-placeholder);
            background: var(--surface-primary);
            border: 1px solid var(--border-primary);
            border-radius: var(--radius-xs);
            padding: 1px 6px;
            line-height: 1.5;
        }

        /* Actions */
        .topbar__actions {
            display: flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
        }

        .topbar__action-btn {
            width: 38px;
            height: 38px;
            border: none;
            background: transparent;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: 16px;
            transition: all var(--duration-fast) var(--ease-out);
            position: relative;
        }

        .topbar__action-btn:hover {
            background: var(--gray-100);
            color: var(--text-primary);
        }

        .topbar__notif-dot {
            position: absolute;
            top: 8px;
            right: 9px;
            width: 8px;
            height: 8px;
            background: var(--danger-500);
            border-radius: var(--radius-full);
            border: 2px solid var(--surface-primary);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.7; }
        }

        .topbar__divider {
            width: 1px;
            height: 28px;
            background: var(--border-primary);
            margin: 0 8px;
        }

        .topbar__user-mini {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 10px 5px 5px;
            border-radius: var(--radius-full);
            transition: background var(--duration-fast) var(--ease-out);
            cursor: pointer;
        }

        .topbar__user-mini:hover {
            background: var(--gray-50);
        }

        .topbar__user-mini-avatar {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, var(--brand-500) 0%, var(--brand-700) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 12px;
        }

        .topbar__user-mini-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }        /* ── Dropdowns ── */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 12px;
            width: 280px;
            background: #fff;
            border: 1px solid var(--border-primary);
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 30px rgba(16, 24, 40, 0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 100;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-secondary);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dropdown-item {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 13.5px;
            transition: background 0.2s;
        }

        .dropdown-item:hover {
            background: var(--gray-50);
            color: var(--text-primary);
        }

        .dropdown-item i {
            color: var(--text-tertiary);
            font-size: 14px;
            width: 16px;
            text-align: center;
        }

        .dropdown-item:hover i {
            color: var(--brand-600);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border-secondary);
            margin: 4px 0;
        }

        .dropdown-container {
            position: relative;
        }


        /* ── Content Area ── */
        .content-area {
            flex: 1;
            min-width: 0; /* Mencegah layout rusak karena child lebar */
            padding: 28px 32px 40px;
            width: 100%;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 28px;
        }

        .page-header__title {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.025em;
            line-height: 1.2;
        }

        .page-header__desc {
            font-size: 14px;
            color: var(--text-secondary);
            margin-top: 6px;
            max-width: 600px;
        }

        .page-header__actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 16px;
        }

        /* ══════════════════════════════════════════════
           SHARED COMPONENTS
        ══════════════════════════════════════════════ */

        /* Card */
        .card {
            background: var(--surface-primary); /* White background */
            border: 2px solid #cbd5e1; /* Strong distinct border color as requested */
            border-radius: var(--radius-xl);
            padding: 24px;
            min-width: 0; /* Mencegah card memanjang di luar container */
            box-shadow: 0 4px 12px rgba(16, 24, 40, 0.05);
            transition: box-shadow var(--duration-base) var(--ease-out),
                        transform var(--duration-base) var(--ease-out);
        }

        .card:hover {
            box-shadow: var(--shadow-sm);
        }

        .card--interactive:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card__title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card__title i {
            color: var(--text-tertiary);
            font-size: 14px;
        }

        .card__action {
            font-size: 13px;
            font-weight: 600;
            color: var(--brand-600);
            transition: color var(--duration-fast);
            cursor: pointer;
        }

        .card__action:hover {
            color: var(--brand-800);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--surface-primary);
            border: 1px solid var(--border-secondary);
            border-radius: var(--radius-xl);
            padding: 22px;
            box-shadow: var(--shadow-sm);
            transition: all var(--duration-base) var(--ease-out);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            opacity: 0.06;
            transform: translate(30%, -30%);
            transition: transform var(--duration-slow) var(--ease-out);
        }

        .stat-card:hover::before {
            transform: translate(20%, -20%) scale(1.3);
        }

        .stat-card.brand { background: #bfdbfe; border: none; }
        .stat-card.success { background: #bbf7d0; border: none; }
        .stat-card.warning { background: #fef08a; border: none; }
        .stat-card.danger { background: #fecaca; border: none; }

        .stat-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-3px);
        }

        .stat-card__top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .stat-card__label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .stat-card__icon {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .stat-card__icon.brand   { color: var(--brand-600); }
        .stat-card__icon.success { color: var(--success-500); }
        .stat-card__icon.warning { color: var(--warning-500); }
        .stat-card__icon.danger  { color: var(--danger-500); }
        .stat-card__icon.info    { color: var(--info-500); }

        .stat-card__value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-card__change {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: var(--radius-full);
        }

        .stat-card__change.up   { background: var(--success-50); color: var(--success-700); }
        .stat-card__change.down  { background: var(--danger-50); color: var(--danger-700); }

        /* Grid Layout */
        .grid { display: grid; gap: 24px; }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }

        /* Table */
        .table-wrap {
            overflow-x: auto;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-secondary);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: var(--gray-50);
            padding: 12px 16px;
            text-align: left;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            /* color: var(--text-tertiary); */
            color: #000000;
            border-bottom: 1px solid var(--border-secondary);
            white-space: nowrap;
        }

        .table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-secondary);
            font-size: 13.5px;
            /* color: var(--text-secondary); */
            color:#ffffff;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: background var(--duration-fast);
        }

        .table tbody tr:hover {
            background: var(--gray-25);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: var(--radius-full);
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge--brand   { background: var(--brand-50);   color: var(--brand-700); }
        .badge--success { background: var(--success-50); color: var(--success-700); }
        .badge--warning { background: var(--warning-50); color: var(--warning-700); }
        .badge--danger  { background: var(--danger-50);  color: var(--danger-700); }
        .badge--neutral { background: var(--gray-100);   color: var(--gray-700); }

        .badge__dot {
            width: 6px;
            height: 6px;
            border-radius: var(--radius-full);
            background: currentColor;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: var(--radius-md);
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all var(--duration-fast) var(--ease-out);
            white-space: nowrap;
            font-family: inherit;
            line-height: 1.4;
        }

        .btn i { font-size: 13px; }

        .btn-primary {
            background: var(--brand-600);
            color: var(--text-on-brand);
            box-shadow: var(--shadow-xs);
        }
        .btn-primary:hover {
            background: var(--brand-700);
            box-shadow: var(--shadow-brand);
            transform: translateY(-1px);
        }

        .btn-success {
            background: var(--success-500);
            color: #fff;
            box-shadow: var(--shadow-xs);
        }
        .btn-success:hover {
            background: var(--success-700);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: var(--surface-primary);
            color: var(--text-secondary);
            border: 1px solid var(--border-primary);
        }
        .btn-outline:hover {
            background: var(--gray-50);
            color: var(--text-primary);
            border-color: var(--gray-300);
        }

        .btn-danger {
            background: var(--danger-50);
            color: var(--danger-700);
            border: 1px solid transparent;
        }
        .btn-danger:hover {
            background: var(--danger-500);
            color: #fff;
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-secondary);
            padding: 8px 12px;
        }
        .btn-ghost:hover {
            background: var(--gray-100);
            color: var(--text-primary);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12.5px;
            border-radius: var(--radius-sm);
        }

        .btn-sm i { font-size: 11px; }

        /* Form */
        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .form-group label .required {
            color: var(--danger-500);
            margin-left: 2px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-primary);
            border-radius: var(--radius-md);
            font-size: 14px;
            font-family: inherit;
            background: var(--surface-primary);
            color: var(--text-primary);
            transition: all var(--duration-fast) var(--ease-out);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--brand-400);
            box-shadow: 0 0 0 3px var(--brand-100);
        }

        .form-control::placeholder {
            color: var(--text-placeholder);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5 5L9 1' stroke='%23667085' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        .form-hint {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 5px;
        }

        .form-error {
            font-size: 12.5px;
            color: var(--danger-500);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Activity List */
        .activity-list {
            display: flex;
            flex-direction: column;
        }

        .activity-item {
            display: flex;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-secondary);
            transition: background var(--duration-fast);
        }

        .activity-item:last-child { border-bottom: none; }

        .activity-item__icon {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 14px;
        }

        .activity-item__content { flex: 1; min-width: 0; }

        .activity-item__title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .activity-item__desc {
            font-size: 12.5px;
            color: var(--text-secondary);
            margin-bottom: 4px;
        }

        .activity-item__time {
            font-size: 11.5px;
            color: var(--text-tertiary);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
        }

        .empty-state__icon {
            font-size: 40px;
            color: var(--gray-300);
            margin-bottom: 16px;
        }

        .empty-state__title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .empty-state__desc {
            font-size: 13.5px;
            color: var(--text-tertiary);
            margin-bottom: 20px;
        }

        /* ══════════════════════════════════════════════
           OVERLAY
        ══════════════════════════════════════════════ */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: var(--surface-overlay);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all var(--duration-base) var(--ease-out);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Flash Messages */
        .flash-message {
            padding: 14px 18px;
            border-radius: var(--radius-lg);
            margin-bottom: 20px;
            font-size: 13.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown var(--duration-base) var(--ease-out);
        }

        .flash-message i { font-size: 16px; }

        .flash-message.success {
            background: var(--success-50);
            color: var(--success-700);
            border: 1px solid #a7f3d0;
        }

        .flash-message.error {
            background: var(--danger-50);
            color: var(--danger-700);
            border: 1px solid #fecaca;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Color dot */
        .color-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: var(--radius-full);
            border: 2px solid rgba(0,0,0,0.08);
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE — TABLET (≤ 1024px)
        ══════════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .grid-2 { grid-template-columns: 1fr; }
            .grid-3 { grid-template-columns: 1fr 1fr; }
            .topbar__search { width: 200px; }
            .content-area { padding: 24px 20px 36px; }
            .topbar__user-mini-name { display: none; }
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE — MOBILE (≤ 768px)
        ══════════════════════════════════════════════ */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: var(--shadow-2xl);
            }
            .main-area { margin-left: 0; }
            .topbar__toggle { display: flex; }
            .topbar__search { display: none; }
            .topbar__divider { display: none; }
            .topbar__user-mini .fa-chevron-down { display: none; }
            .topbar { padding: 0 16px; height: 58px; }
            .content-area { padding: 20px 16px 32px; }
            .stat-card { padding: 18px; }
            .stat-card__value { font-size: 24px; }
            .stat-card__icon { width: 38px; height: 38px; font-size: 16px; }
            .page-header__title { font-size: 22px; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .card { padding: 18px; border-radius: var(--radius-lg); }
            .page-header__actions { flex-direction: column; align-items: stretch; }
            .table td, .table th { padding: 10px 12px; font-size: 12.5px; }
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE — SMALL MOBILE (≤ 480px)
        ══════════════════════════════════════════════ */
        @media (max-width: 480px) {
            .content-area { padding: 16px 12px 28px; }
            .topbar { padding: 0 12px; }
            .card { padding: 14px; }
            .page-header__title { font-size: 20px; }
            .stat-card { padding: 12px; }
            .stat-card__value { font-size: 20px; }
            .stat-card__label { font-size: 11px; }
            .stat-card__icon { width: 32px; height: 32px; font-size: 14px; }
            .table td, .table th { padding: 10px 10px; font-size: 12px; }
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE — EXTRA SMALL (≤ 360px)
        ══════════════════════════════════════════════ */
        @media (max-width: 360px) {
            .content-area { padding: 12px 10px 24px; }
            .topbar { padding: 0 10px; }
            .card { padding: 12px; }
            .page-header__title { font-size: 18px; }
            .stat-card { padding: 12px 14px; }
            .stat-card__value { font-size: 20px; }
        }

        /* Focus visible */
        :focus-visible {
            outline: 2px solid var(--brand-500);
            outline-offset: 2px;
        }

        /* Selection */
        ::selection {
            background: var(--brand-200);
            color: var(--brand-900);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: var(--radius-full); }
        ::-webkit-scrollbar-thumb:hover { background: var(--gray-300); }

        /* Print */
        @media print {
            .sidebar, .topbar, .sidebar-overlay { display: none !important; }
            .main-area { margin-left: 0 !important; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="admin-shell" id="adminShell">

        {{-- ════════ Sidebar Overlay ════════ --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        {{-- ════════ Sidebar ════════ --}}
        <aside class="sidebar" id="sidebar">
            {{-- Brand --}}
            <div class="sidebar__header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar__brand">
                    <div class="sidebar__logo">ST</div>
                    <div>
                        <div class="sidebar__title">SIGAP TUHA</div>
                        <div class="sidebar__subtitle">Admin Panel</div>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="sidebar__nav">
                {{-- Utama --}}
                <div class="nav-group">
                    <div class="nav-group__label">Utama</div>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" id="nav-dashboard">
                        <span class="nav-link__icon" style="color: var(--brand-500)"><i class="fas fa-th-large"></i></span>
                        <span class="nav-link__text">Dashboard</span>
                    </a>
                    <a href="{{ route('beranda') }}" class="nav-link" id="nav-beranda" target="_blank">
                        <span class="nav-link__icon" style="color: var(--gray-500)"><i class="fas fa-home"></i></span>
                        <span class="nav-link__text">Lihat Beranda</span>
                        <span class="nav-link__ext-icon"><i class="fas fa-external-link-alt"></i></span>
                    </a>
                </div>

                {{-- Bagian Utama --}}
                <div class="nav-group">
                    <div class="nav-group__label">Bagian Utama</div>
                    <a href="{{ route('admin.profil.index') }}" class="nav-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}" id="nav-profil">
                        <span class="nav-link__icon" style="color: var(--info-500)"><i class="fas fa-id-card"></i></span>
                        <span class="nav-link__text">Profil</span>
                    </a>
                    <a href="{{ route('admin.programs.index') }}" class="nav-link {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}" id="nav-programs">
                        <span class="nav-link__icon" style="color: var(--success-500)"><i class="fas fa-project-diagram"></i></span>
                        <span class="nav-link__text">Program & Kegiatan</span>
                    </a>
                    <a href="{{ route('admin.berita.index') }}" class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}" id="nav-berita">
                        <span class="nav-link__icon" style="color: var(--warning-500)"><i class="fas fa-newspaper"></i></span>
                        <span class="nav-link__text">Berita</span>
                    </a>
                    <a href="{{ route('admin.kontak.index') }}" class="nav-link {{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}" id="nav-kontak">
                        <span class="nav-link__icon" style="color: var(--danger-500)"><i class="fas fa-envelope"></i></span>
                        <span class="nav-link__text">Kontak</span>
                    </a>
                    <a href="{{ route('admin.features.index') }}" class="nav-link {{ request()->routeIs('admin.features.*') ? 'active' : '' }}" id="nav-features">
                        <span class="nav-link__icon" style="color: var(--brand-500)"><i class="fas fa-star"></i></span>
                        <span class="nav-link__text">Fitur Landing Page</span>
                    </a>
                </div>

                {{-- 5 Card Utama --}}
                <div class="nav-group">
                    <div class="nav-group__label">5 Card Utama</div>
                    <a href="{{ route('admin.lansia.index') }}" class="nav-link {{ request()->routeIs('admin.lansia.*') ? 'active' : '' }}" id="nav-lansia">
                        <span class="nav-link__icon" style="color: var(--info-500)"><i class="fas fa-users"></i></span>
                        <span class="nav-link__text">Pendataan Lansia</span>
                    </a>
                    <a href="{{ route('admin.bantuan-darurat.index') }}" class="nav-link {{ request()->routeIs('admin.bantuan-darurat.*') ? 'active' : '' }}" id="nav-bantuan">
                        <span class="nav-link__icon" style="color: var(--danger-500)"><i class="fas fa-ambulance"></i></span>
                        <span class="nav-link__text">Bantuan Darurat</span>
                    </a>
                    <a href="{{ route('admin.edukasi.index') }}" class="nav-link {{ request()->routeIs('admin.edukasi.*') ? 'active' : '' }}" id="nav-edukasi">
                        <span class="nav-link__icon" style="color: var(--warning-500)"><i class="fas fa-graduation-cap"></i></span>
                        <span class="nav-link__text">Edukasi & Pelatihan</span>
                    </a>
                    <a href="{{ route('admin.organisasi-relawan.index') }}" class="nav-link {{ request()->routeIs('admin.organisasi-relawan.*', 'admin.relawan.*') ? 'active' : '' }}" id="nav-relawan">
                        <span class="nav-link__icon" style="color: var(--success-500)"><i class="fas fa-hands-helping"></i></span>
                        <span class="nav-link__text">Relawan Siaga</span>
                    </a>
                    <a href="{{ route('admin.monitoring.index') }}" class="nav-link {{ request()->routeIs('admin.monitoring.*') ? 'active' : '' }}" id="nav-monitoring">
                        <span class="nav-link__icon" style="color: var(--brand-500)"><i class="fas fa-chart-line"></i></span>
                        <span class="nav-link__text">Monitoring & Evaluasi</span>
                    </a>
                </div>



                {{-- Sistem --}}
                <div class="nav-group">
                    <div class="nav-group__label">Sistem</div>
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" id="nav-users">
                        <span class="nav-link__icon"><i class="fas fa-user-shield"></i></span>
                        <span class="nav-link__text">Manajemen User</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" id="nav-settings">
                        <span class="nav-link__icon"><i class="fas fa-cog"></i></span>
                        <span class="nav-link__text">Pengaturan</span>
                    </a>
                </div>
            </nav>

            {{-- Footer / User --}}
            <div class="sidebar__footer">
                <div class="sidebar__user">
                    <div class="sidebar__avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}{{ strtoupper(substr(Auth::user()->name ?? 'D', 1, 1)) }}
                    </div>
                    <div class="sidebar__user-info">
                        <div class="sidebar__user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="sidebar__user-role">Super Admin</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="sidebar__logout-btn" title="Keluar">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ════════ Main Content ════════ --}}
        <main class="main-area" id="mainArea">
            {{-- Header --}}
            <header class="topbar" id="topbar">
                <button class="topbar__toggle" id="sidebarToggle" aria-label="Toggle sidebar menu">
                    <i class="fas fa-bars"></i>
                </button>

                <div style="flex:1;"></div>

                <div class="topbar__search" id="topbarSearch">
                    <span class="topbar__search-icon"><i class="fas fa-search"></i></span>
                    <input type="text" class="topbar__search-input" placeholder="Cari data..." id="globalSearch">
                    <span class="topbar__search-shortcut">⌘K</span>
                </div>

                <div class="topbar__actions">
                    @php
                        $recentRujukan = \App\Models\LansiaPrioritas::latest()->take(3)->get();
                        $rujukanCount  = \App\Models\LansiaPrioritas::count();
                    @endphp

                    {{-- Notifikasi Dropdown --}}
                    <div class="dropdown-container">
                        <button class="topbar__action-btn" id="notifBtn" title="Notifikasi" onclick="toggleDropdown('notifDropdown')">
                            <i class="far fa-bell"></i>
                            @if($rujukanCount > 0)
                                <span class="topbar__notif-dot"></span>
                            @endif
                        </button>
                        <div class="dropdown-menu" id="notifDropdown" style="width: 320px;">
                            <div class="dropdown-header">
                                <span>Perlu Perhatian</span>
                                @if($rujukanCount > 0)
                                    <span class="badge badge--danger" style="font-size:10px;">{{ $rujukanCount }} Lansia</span>
                                @endif
                            </div>
                            <div style="max-height: 300px; overflow-y: auto;">
                                @forelse($recentRujukan as $lansia)
                                    <a href="#" class="dropdown-item" style="align-items:flex-start; gap:14px;">
                                        <div style="width:32px; height:32px; border-radius:50%; background:var(--warning-50); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                            <i class="fas fa-exclamation-circle" style="color:var(--warning-500); font-size:14px; margin:0;"></i>
                                        </div>
                                        <div>
                                            <div style="font-size:13px; font-weight:600; color:var(--text-primary); margin-bottom:4px;">
                                                {{ $lansia->nama_lansia }}
                                            </div>
                                            <div style="font-size:12px; color:var(--warning-500); line-height:1.4; font-weight:500;">
                                                <i class="fas fa-star" style="font-size:10px;"></i> Prioritas
                                            </div>
                                            <div style="font-size:11px; color:var(--text-tertiary); margin-top:4px;">
                                                {{ $lansia->desa ? $lansia->desa->desa : '-' }} &bull; {{ $lansia->riwayat_penyakit ?? 'Memiliki riwayat penyakit' }}
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div style="padding: 30px 20px; text-align:center; color:var(--text-tertiary); font-size:13px;">
                                        <i class="fas fa-check-circle" style="font-size:24px; margin-bottom:10px; opacity:0.5; color:var(--success-500);"></i><br>
                                        Semua lansia dalam kondisi baik
                                    </div>
                                @endforelse
                            </div>
                            <div class="dropdown-divider" style="margin:0;"></div>
                            <a href="{{ route('admin.lansia.index') }}?status=Rujukan+segera" class="dropdown-item" style="justify-content:center; font-size:12.5px; font-weight:600; color:var(--danger-500);">
                                <i class="fas fa-users" style="font-size:11px;"></i>&nbsp; Lihat Semua Lansia Rujukan
                            </a>
                        </div>
                    </div>

                    {{-- Pengaturan Direct Link --}}
                    <a href="{{ route('admin.settings') }}" class="topbar__action-btn" title="Pengaturan" style="display:flex; align-items:center; justify-content:center; text-decoration:none;">
                        <i class="fas fa-cog"></i>
                    </a>

                    <div class="topbar__divider"></div>

                    {{-- Profil Dropdown --}}
                    <div class="dropdown-container">
                        <div class="topbar__user-mini" id="topbarUser" onclick="toggleDropdown('userDropdown')" style="cursor:pointer;">
                            <div class="topbar__user-mini-avatar">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="topbar__user-mini-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <i class="fas fa-chevron-down" style="font-size:10px; color:var(--text-placeholder)"></i>
                        </div>
                        <div class="dropdown-menu" id="userDropdown" style="width: 200px;">
                            <div class="dropdown-header" style="flex-direction:column; align-items:flex-start; gap:4px; padding:16px;">
                                <div style="font-weight:700; color:var(--text-primary);">{{ Auth::user()->name ?? 'Admin' }}</div>
                                <div style="font-weight:400; color:var(--text-tertiary); font-size:12px;">{{ Auth::user()->email ?? 'admin@sigaptuha.id' }}</div>
                            </div>
                            <a href="{{ route('profil') }}" class="dropdown-item">
                                <i class="far fa-user"></i> Profil Saya
                            </a>
                            <a href="{{ route('admin.settings') }}" class="dropdown-item">
                                <i class="fas fa-cog"></i> Pengaturan
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item" style="width:100%; border:none; background:transparent; cursor:pointer; color:var(--danger-500);">
                                    <i class="fas fa-sign-out-alt" style="color:var(--danger-500);"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <div class="content-area">
                @if(session('success'))
                    <div class="flash-message success" id="flashSuccess">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="flash-message error" id="flashError">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        (() => {
            'use strict';

            const sidebar   = document.getElementById('sidebar');
            const overlay   = document.getElementById('sidebarOverlay');
            const toggle    = document.getElementById('sidebarToggle');
            const BREAKPOINT = 768;

            const isMobileMode = () => window.innerWidth <= BREAKPOINT;

            let isOpen = false;

            function openSidebar() {
                isOpen = true;
                sidebar.classList.add('open');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
                toggle.innerHTML = '<i class="fas fa-times"></i>';
            }

            function closeSidebar() {
                isOpen = false;
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
                toggle.innerHTML = '<i class="fas fa-bars"></i>';
            }

            function toggleSidebar() {
                isOpen ? closeSidebar() : openSidebar();
            }

            // Only attach toggle click if toggle is visible
            toggle.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', closeSidebar);

            // Close sidebar on nav click (only on mobile)
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (isMobileMode()) closeSidebar();
                });
            });

            // Close on ESC
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape' && isOpen) closeSidebar();
            });

            // Handle resize — only close if going back to desktop
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    if (!isMobileMode() && isOpen) closeSidebar();
                }, 150);
            });

            // Touch swipe to open/close — only on real touch devices
            let touchStartX = 0, touchStartY = 0;
            document.addEventListener('touchstart', e => {
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
            }, { passive: true });

            document.addEventListener('touchend', e => {
                if (!isMobileMode()) return;
                const diffX = e.changedTouches[0].clientX - touchStartX;
                const diffY = Math.abs(e.changedTouches[0].clientY - touchStartY);
                if (diffX > 80 && diffY < 50 && touchStartX < 30 && !isOpen) openSidebar();
                if (diffX < -80 && diffY < 50 && isOpen) closeSidebar();
            }, { passive: true });

            // Flash message auto dismiss
            document.querySelectorAll('.flash-message').forEach(msg => {
                setTimeout(() => {
                    msg.style.transition = 'all 400ms ease';
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateY(-10px)';
                    setTimeout(() => msg.remove(), 400);
                }, 5000);
            });

            // Keyboard: Ctrl/Cmd + K → focus search
            document.addEventListener('keydown', e => {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const s = document.getElementById('globalSearch');
                    if (s) s.focus();
                }
            });

            // Dropdowns logic
            window.toggleDropdown = function(id) {
                const dropdown = document.getElementById(id);
                const isShowing = dropdown.classList.contains('show');
                
                // Close all open dropdowns first
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });

                if (!isShowing) {
                    dropdown.classList.add('show');
                }
            };

            // Close dropdowns when clicking outside
            document.addEventListener('click', e => {
                if (!e.target.closest('.dropdown-container')) {
                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });
        })();
    </script>

    @yield('scripts')
</body>
</html>
