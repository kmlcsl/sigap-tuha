@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-header__title">Organisasi Relawan</h1>
        <p class="page-header__desc">Kelola data organisasi relawan siaga bencana.</p>
    </div>
    <div>
        <a href="{{ route('admin.organisasi-relawan.create') }}" class="btn btn-primary">Tambah Organisasi</a>
    </div>
</div>

@if(session('success'))
<div class="flash-message success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Daftar Organisasi</h3>
    </div>
    
    @if($organisasiRelawans->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
            </div>
            <h4 class="empty-state__title">Belum ada data</h4>
            <p class="empty-state__desc">Tambahkan organisasi relawan pertama Anda.</p>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Organisasi</th>
                        <th>Singkatan</th>
                        <th>Jumlah Relawan</th>
                        <th>Bidang Keahlian</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($organisasiRelawans as $org)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $org->nama_organisasi }}</td>
                        <td>{{ $org->singkatan ?? '-' }}</td>
                        <td>
                            <span class="badge badge--brand">
                                <span class="badge__dot"></span> {{ $org->relawans_count }} Orang
                            </span>
                        </td>
                        <td>{{ $org->bidang_keahlian ?? '-' }}</td>
                        <td>
                            @if($org->is_active)
                                <span class="badge badge--success">Aktif</span>
                            @else
                                <span class="badge badge--neutral">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.organisasi-relawan.edit', $org) }}" class="btn btn-outline btn-sm">Edit</a>
                                <a href="{{ route('admin.organisasi-relawan.relawan.index', $org) }}" class="btn btn-primary btn-sm">Kelola Anggota</a>
                                <form action="{{ route('admin.organisasi-relawan.destroy', $org) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
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
