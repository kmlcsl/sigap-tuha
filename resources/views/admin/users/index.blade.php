@extends('layouts.admin')
@section('header_title', 'Manajemen User')
@section('content')
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div>
        <h1 class="page-header__title">Manajemen User</h1>
        <p class="page-header__desc">Kelola pengguna sistem SIGAP TUHA.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Tambah User</a>
</div>
<div class="card">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-users-cog"></i> Daftar User</h3>
        <span style="font-size:13px; color:var(--text-tertiary);"><i class="fas fa-info-circle"></i> Total: {{ $users->count() }} user</span>
    </div>
    @if($users->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-user-slash"></i></div>
            <div class="empty-state__title">Belum Ada User</div>
            <div class="empty-state__desc">Tambahkan user baru ke sistem.</div>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th><i class="fas fa-user" style="margin-right:4px"></i> Nama</th>
                        <th><i class="fas fa-envelope" style="margin-right:4px"></i> Email</th>
                        <th><i class="fas fa-shield-alt" style="margin-right:4px"></i> Role</th>
                        <th><i class="far fa-calendar" style="margin-right:4px"></i> Dibuat</th>
                        <th style="width:160px; text-align:center"><i class="fas fa-cogs" style="margin-right:4px"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $user)
                    <tr>
                        <td><span style="font-weight:600; color:var(--text-tertiary);">{{ $i + 1 }}</span></td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:32px; height:32px; border-radius:var(--radius-full); background:linear-gradient(135deg, var(--brand-500), var(--brand-700)); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:12px; flex-shrink:0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span style="font-weight:600; color:var(--text-primary);">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td style="font-size:13px;">{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge badge--danger"><i class="fas fa-crown" style="font-size:10px"></i> Admin</span>
                            @elseif($user->role == 'koordinator')
                                <span class="badge badge--brand"><i class="fas fa-user-tie" style="font-size:10px"></i> Koordinator</span>
                            @else
                                <span class="badge badge--success"><i class="fas fa-hands-helping" style="font-size:10px"></i> Relawan</span>
                            @endif
                        </td>
                        <td style="font-size:12.5px; color:var(--text-tertiary);">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
