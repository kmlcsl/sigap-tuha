@extends('layouts.admin')
@section('header_title', 'Tambah User Baru')
@section('content')
<div class="page-header"><h1 class="page-header__title">Tambah User Baru</h1><p class="page-header__desc">Buat akun pengguna baru untuk sistem SIGAP TUHA.</p></div>
<div class="card" style="max-width:700px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-user-plus"></i> Form User Baru</h3></div>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label><i class="fas fa-user" style="margin-right:4px; color:var(--text-tertiary)"></i> Nama Lengkap <span class="required">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Nama lengkap">
            @error('name') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label><i class="fas fa-envelope" style="margin-right:4px; color:var(--text-tertiary)"></i> Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@example.com">
            @error('email') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label><i class="fas fa-shield-alt" style="margin-right:4px; color:var(--text-tertiary)"></i> Role <span class="required">*</span></label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
                <option value="koordinator" {{ old('role')=='koordinator'?'selected':'' }}>Koordinator</option>
                <option value="relawan" {{ old('role')=='relawan'?'selected':'' }}>Relawan</option>
            </select>
            @error('role') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-lock" style="margin-right:4px; color:var(--text-tertiary)"></i> Password <span class="required">*</span></label>
                <input type="password" name="password" class="form-control" required placeholder="Min. 8 karakter">
                @error('password') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock" style="margin-right:4px; color:var(--text-tertiary)"></i> Konfirmasi Password <span class="required">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
            </div>
        </div>
        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
