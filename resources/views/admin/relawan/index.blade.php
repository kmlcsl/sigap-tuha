@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size: 14px; color: var(--muted); margin-bottom: 8px;">Admin &gt; Relawan Siaga &gt; {{ $organisasiRelawan->nama_organisasi }}</div>
        <h1 class="page-header__title">Anggota: {{ $organisasiRelawan->nama_organisasi }}</h1>
        <p class="page-header__desc">Kelola data anggota untuk organisasi ini.</p>
    </div>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin.organisasi-relawan.index') }}" class="btn btn-outline btn-sm">Kembali</a>
        <a href="{{ route('admin.organisasi-relawan.relawan.create', $organisasiRelawan) }}" class="btn btn-primary">Tambah Anggota</a>
    </div>
</div>

@if(session('success'))
<div class="flash-message success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Daftar Anggota</h3>
    </div>
    
    @if($relawans->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M16 16s-1.5-2-4-2-4 2-4 2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
            </div>
            <h4 class="empty-state__title">Belum ada anggota</h4>
            <p class="empty-state__desc">Tambahkan anggota pertama untuk organisasi ini.</p>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Keahlian</th>
                        <th>Nomor WA</th>
                        <th>Status Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($relawans as $relawan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $relawan->nama_lengkap }}</td>
                        <td>{{ $relawan->jabatan ?? '-' }}</td>
                        <td>{{ $relawan->keahlian ?? '-' }}</td>
                        <td>{{ $relawan->nomor_wa ?? '-' }}</td>
                        <td>
                            @if($relawan->is_aktif)
                                <span class="badge badge--success">Aktif</span>
                            @else
                                <span class="badge badge--neutral">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.organisasi-relawan.relawan.edit', [$organisasiRelawan, $relawan]) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form action="{{ route('admin.organisasi-relawan.relawan.destroy', [$organisasiRelawan, $relawan]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
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
