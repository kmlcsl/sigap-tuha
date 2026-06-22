@extends('layouts.admin')
@section('header_title', 'Edit User')
@section('content')
<div class="page-header"><h1 class="page-header__title">Edit User</h1><p class="page-header__desc">Perbarui data user "{{ $user->name }}".</p></div>
<div class="card" style="max-width:700px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-user-edit"></i> Edit Data User</h3><span class="badge badge--brand"><i class="fas fa-hashtag" style="font-size:10px"></i> ID: {{ $user->id }}</span></div>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label><i class="fas fa-user" style="margin-right:4px; color:var(--text-tertiary)"></i> Nama Lengkap <span class="required">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label><i class="fas fa-envelope" style="margin-right:4px; color:var(--text-tertiary)"></i> Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label><i class="fas fa-shield-alt" style="margin-right:4px; color:var(--text-tertiary)"></i> Role <span class="required">*</span></label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ old('role', $user->role)=='admin'?'selected':'' }}>Admin</option>
                <option value="koordinator" {{ old('role', $user->role)=='koordinator'?'selected':'' }}>Koordinator</option>
                <option value="relawan" {{ old('role', $user->role)=='relawan'?'selected':'' }}>Relawan</option>
            </select>
            @error('role') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div class="grid grid-2" style="gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-lock" style="margin-right:4px; color:var(--text-tertiary)"></i> Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                @error('password') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                <div class="form-hint"><i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengubah password.</div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock" style="margin-right:4px; color:var(--text-tertiary)"></i> Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>
        </div>
        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
