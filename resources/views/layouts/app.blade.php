<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'SIGAP TUHA' }}</title>
    <style>
        :root {
            --bg: #f5f7fb;
            --card: #ffffff;
            --primary: #0f4c81;
            --primary-soft: #e9f2fb;
            --danger: #b42318;
            --warning: #b54708;
            --success: #027a48;
            --text: #101828;
            --muted: #475467;
            --border: #d0d5dd;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        a { color: inherit; text-decoration: none; }
        .container {
            width: min(1120px, calc(100% - 32px));
            margin: 0 auto;
        }
        .topbar {
            background: #0b2540;
            color: #fff;
            padding: 18px 0;
            position: sticky;
            top: 0;
            z-index: 5;
        }
        .brand {
            font-size: 20px;
            font-weight: 700;
        }
        .subtitle {
            font-size: 13px;
            color: #d0d5dd;
            margin-top: 4px;
        }
        .nav {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 14px;
        }
        .nav a {
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.1);
            font-size: 14px;
        }
        .nav a.active,
        .nav a:hover {
            background: #fff;
            color: #0b2540;
        }
        .hero, .section, .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
        }
        .hero {
            padding: 28px;
            margin: 24px 0;
        }
        .section {
            padding: 24px;
            margin-bottom: 20px;
        }
        .grid {
            display: grid;
            gap: 16px;
        }
        .grid-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .grid-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        .grid-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
        .card {
            padding: 18px;
        }
        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-biru { background: #dbeafe; color: #1d4ed8; }
        .badge-merah { background: #fee4e2; color: var(--danger); }
        .badge-kuning { background: #fef0c7; color: var(--warning); }
        .badge-hijau { background: #d1fadf; color: var(--success); }
        .table-wrap { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eaecf0;
            font-size: 14px;
        }
        th { color: var(--muted); }
        .muted { color: var(--muted); }
        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 18px;
        }
        .btn {
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 700;
            display: inline-block;
        }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-secondary { background: var(--primary-soft); color: var(--primary); }
        .list {
            margin: 0;
            padding-left: 18px;
            color: var(--muted);
        }
        .list li { margin: 10px 0; }
        footer {
            padding: 28px 0 36px;
            color: var(--muted);
            font-size: 14px;
        }
        @media (max-width: 900px) {
            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }
            .hero, .section, .card {
                border-radius: 16px;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container">
            <div class="brand">SIGAP TUHA</div>
            <div class="subtitle">Sistem Informasi Gerak Cepat Perlindungan Lansia Tangguh Bencana</div>
            <nav class="nav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('lansia.index') }}" class="{{ request()->routeIs('lansia.*') ? 'active' : '' }}">Data Lansia</a>
                <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">Laporan</a>
                <a href="{{ route('peta.index') }}" class="{{ request()->routeIs('peta.*') ? 'active' : '' }}">Peta</a>
                <a href="{{ route('edukasi.index') }}" class="{{ request()->routeIs('edukasi.*') ? 'active' : '' }}">Edukasi</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="container">
        Project awal Laravel untuk SIGAP TUHA. Struktur ini siap dilanjutkan ke autentikasi, CRUD, notifikasi, dan integrasi database produksi.
    </footer>
</body>
</html>
