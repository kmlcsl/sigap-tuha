@extends('layouts.admin')
@section('header_title', 'Manajemen User')

@section('styles')
<style>
/* ── Responsive fix: Users Index ── */
.page-header-row {
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
}
.table-filter-row {
    display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
}
.table-filter-row select,
.table-filter-row input { min-width: 0; }
.table-search-input {
    padding: 7px 12px 7px 30px;
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-md);
    font-size: 13px; font-family: inherit;
    background: var(--gray-50); color: var(--text-primary);
    width: 100%;
}
.table-search-wrap { position: relative; min-width: 180px; flex: 1; }
.table-search-wrap i {
    position: absolute; left: 10px; top: 50%;
    transform: translateY(-50%); color: var(--text-placeholder);
    font-size: 12px; pointer-events: none;
}
/* Overflow table on mobile */
.user-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
/* Hide less important columns on small screens */
@media (max-width: 640px) {
    .col-join { display: none; }
    .page-header-row .btn { width: 100%; justify-content: center; }
    .stats-row { grid-template-columns: repeat(2, 1fr) !important; }
    .card__header { flex-wrap: wrap; gap: 10px; }
    .table-filter-row { flex-direction: column; align-items: stretch; }
    .table-filter-row select,
    .table-filter-row .table-search-wrap { width: 100%; }
}
@media (max-width: 400px) {
    .col-email { display: none; }
}
</style>
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header-row">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-user-shield" style="color:var(--brand-500); margin-right:10px; font-size:22px;"></i>
            Manajemen User
        </h1>
        <p class="page-header__desc">Kelola akun pengguna dan hak akses sistem SIGAP TUHA.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Tambah User
    </a>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="flash-message success" id="flashMsg">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="document.getElementById('flashMsg').remove()" style="margin-left:auto; background:none; border:none; cursor:pointer; color:inherit; opacity:0.6; font-size:18px;">&times;</button>
    </div>
@endif

{{-- Stats --}}
@php
    $total    = $users->count();
    $admins   = $users->where('role','admin')->count();
    $koors    = $users->where('role','koordinator')->count();
    $relawans = $users->where('role','relawan')->count();
@endphp
<div class="stats-row" style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;">
    <div class="stat-card brand">
        <div class="stat-card__top">
            <span class="stat-card__label">Total User</span>
            <div class="stat-card__icon brand"><i class="fas fa-users"></i></div>
        </div>
        <div class="stat-card__value">{{ $total }}</div>
        <div class="stat-card__change up"><i class="fas fa-circle" style="font-size:8px;"></i> Aktif</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-card__top">
            <span class="stat-card__label">Admin</span>
            <div class="stat-card__icon danger"><i class="fas fa-crown"></i></div>
        </div>
        <div class="stat-card__value">{{ $admins }}</div>
        <div class="stat-card__change up"><i class="fas fa-shield-alt" style="font-size:9px;"></i> Super</div>
    </div>
    <div class="stat-card success">
        <div class="stat-card__top">
            <span class="stat-card__label">Koordinator</span>
            <div class="stat-card__icon success"><i class="fas fa-user-tie"></i></div>
        </div>
        <div class="stat-card__value">{{ $koors }}</div>
        <div class="stat-card__change up"><i class="fas fa-sitemap" style="font-size:9px;"></i> Koor</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-card__top">
            <span class="stat-card__label">Relawan</span>
            <div class="stat-card__icon warning"><i class="fas fa-hands-helping"></i></div>
        </div>
        <div class="stat-card__value">{{ $relawans }}</div>
        <div class="stat-card__change up"><i class="fas fa-heart" style="font-size:9px;"></i> Aktif</div>
    </div>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card__header" style="flex-wrap:wrap; gap:12px;">
        <h3 class="card__title">
            <i class="fas fa-users-cog"></i> Daftar Pengguna
            <span class="badge badge--brand" style="margin-left:8px; font-size:11px;" id="countBadge">{{ $total }}</span>
        </h3>
        <div class="table-filter-row">
            <select id="filterRole" onchange="filterTable()" class="form-control" style="font-size:13px; padding:7px 12px; width:auto; min-width:140px;">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="koordinator">Koordinator</option>
                <option value="relawan">Relawan</option>
            </select>
            <div class="table-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="searchUser" oninput="filterTable()" placeholder="Cari nama / email..." class="table-search-input">
            </div>
        </div>
    </div>

    @if($users->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-user-slash"></i></div>
            <div class="empty-state__title">Belum Ada User</div>
            <div class="empty-state__desc">Tambahkan pengguna pertama ke dalam sistem.</div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="margin-top:4px;">
                <i class="fas fa-user-plus"></i> Tambah User Pertama
            </a>
        </div>
    @else
        <div class="user-table-wrap">
            <table class="table" id="userTable">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th><i class="fas fa-user" style="margin-right:4px;"></i> Nama</th>
                        <th class="col-email"><i class="fas fa-envelope" style="margin-right:4px;"></i> Email</th>
                        <th style="text-align:center;"><i class="fas fa-shield-alt" style="margin-right:4px;"></i> Role</th>
                        <th class="col-join"><i class="far fa-calendar" style="margin-right:4px;"></i> Bergabung</th>
                        <th style="width:120px; text-align:center;"><i class="fas fa-cogs" style="margin-right:4px;"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $user)
                    <tr class="user-row" data-role="{{ $user->role }}" data-name="{{ strtolower($user->name) }} {{ strtolower($user->email) }}">
                        <td><span style="font-weight:700; color:var(--text-tertiary);">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</span></td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:var(--radius-full); background:linear-gradient(135deg, var(--brand-500), var(--brand-700)); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:13px; flex-shrink:0; box-shadow:var(--shadow-sm);">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700; color:var(--text-primary); font-size:13.5px;">{{ $user->name }}</div>
                                    @if(Auth::id() == $user->id)
                                        <div style="font-size:10.5px; color:var(--brand-600); font-weight:600;"><i class="fas fa-circle" style="font-size:7px;"></i> Anda</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="col-email" style="font-size:13px; color:var(--text-secondary);">{{ $user->email }}</td>
                        <td style="text-align:center;">
                            @if($user->role == 'admin')
                                <span class="badge badge--danger"><i class="fas fa-crown" style="font-size:10px;"></i> Admin</span>
                            @elseif($user->role == 'koordinator')
                                <span class="badge badge--brand"><i class="fas fa-user-tie" style="font-size:10px;"></i> Koor</span>
                            @else
                                <span class="badge badge--success"><i class="fas fa-hands-helping" style="font-size:10px;"></i> Relawan</span>
                            @endif
                        </td>
                        <td class="col-join">
                            <div style="font-size:13px; color:var(--text-secondary);">{{ $user->created_at->translatedFormat('d M Y') }}</div>
                        </td>
                        <td>
                            <div style="display:flex; gap:5px; justify-content:center;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                @if(Auth::id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size:10px; color:var(--text-tertiary); padding:6px 5px; display:flex; align-items:center;">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="noResults" style="display:none; text-align:center; padding:32px; color:var(--text-tertiary);">
            <i class="fas fa-search" style="font-size:28px; opacity:.4; display:block; margin-bottom:10px;"></i>
            <div style="font-weight:600;">Tidak ada user yang cocok</div>
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 4px 0; flex-wrap:wrap; gap:8px;">
            <span style="font-size:12.5px; color:var(--text-tertiary);" id="tableFooter">
                Menampilkan <strong>{{ $total }}</strong> pengguna
            </span>
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                <span class="badge badge--danger" style="font-size:11px;"><i class="fas fa-crown" style="font-size:9px;"></i> {{ $admins }}</span>
                <span class="badge badge--brand" style="font-size:11px;"><i class="fas fa-user-tie" style="font-size:9px;"></i> {{ $koors }}</span>
                <span class="badge badge--success" style="font-size:11px;"><i class="fas fa-hands-helping" style="font-size:9px;"></i> {{ $relawans }}</span>
            </div>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
function filterTable() {
    const roleFilter = document.getElementById('filterRole').value;
    const searchVal  = document.getElementById('searchUser').value.toLowerCase();
    const rows = document.querySelectorAll('.user-row');
    let visible = 0;
    rows.forEach(row => {
        const matchRole   = !roleFilter || (row.dataset.role || '') === roleFilter;
        const matchSearch = !searchVal  || (row.dataset.name || '').includes(searchVal) || row.innerText.toLowerCase().includes(searchVal);
        const show = matchRole && matchSearch;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    const noR    = document.getElementById('noResults');
    const badge  = document.getElementById('countBadge');
    const footer = document.getElementById('tableFooter');
    if (noR)    noR.style.display  = visible === 0 ? 'block' : 'none';
    if (badge)  badge.textContent  = visible;
    if (footer) footer.innerHTML   = 'Menampilkan <strong>' + visible + '</strong> pengguna';
}
setTimeout(() => {
    const el = document.getElementById('flashMsg');
    if (el) { el.style.opacity='0'; el.style.transition='opacity .4s'; setTimeout(()=>el.remove(),400); }
}, 4000);
</script>
@endsection
