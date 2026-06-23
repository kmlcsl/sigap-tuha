@extends('layouts.admin')

@section('header_title', 'Bantuan Darurat')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-header__title">Bantuan Darurat</h1>
        <p class="page-header__desc">Kelola kontak bantuan darurat untuk warga</p>
    </div>
    <div>
        <a href="{{ route('admin.bantuan-darurat.create') }}" class="btn btn-primary">Tambah Instansi</a>
    </div>
</div>

@if(session('success'))
<div class="flash-message success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Daftar Instansi</h3>
    </div>
    
    @if($bantuanDarurats->isEmpty())
    <div class="empty-state">
        <div class="empty-state__icon">
            <i class="fas fa-phone-alt"></i>
        </div>
        <h4 class="empty-state__title">Belum ada data</h4>
        <p class="empty-state__desc">Tambahkan kontak bantuan darurat pertama Anda.</p>
    </div>
    @else
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Instansi</th>
                    <th>Jenis</th>
                    <th>Nomor WA</th>
                    <th>Status</th>
                    <th>Urutan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bantuanDarurats as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            {{ $item->nama_instansi }}
                        </div>
                    </td>
                    <td>
                        @php
                            $badgeClass = 'neutral';
                            if($item->jenis == 'Kepolisian') $badgeClass = 'brand';
                            elseif($item->jenis == 'Damkar') $badgeClass = 'danger';
                            elseif($item->jenis == 'Basarnas') $badgeClass = 'warning';
                            elseif($item->jenis == 'Rumah Sakit') $badgeClass = 'success';
                            elseif($item->jenis == 'Puskesmas') $badgeClass = 'info';
                        @endphp
                        <span class="badge badge--{{ $badgeClass }}">
                            <span class="badge__dot"></span>
                            {{ $item->jenis }}
                        </span>
                    </td>
                    <td>
                        {{ $item->nomor_wa }}<br>
                        <a href="{{ $item->wa_link }}" target="_blank" style="font-size: 12px; color: var(--brand-500);">Test Link WA</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.bantuan-darurat.toggle', $item) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="badge badge--{{ $item->is_active ? 'success' : 'neutral' }}" style="border:none; cursor:pointer;">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td>{{ $item->urutan }}</td>
                    <td>
                        <div style="display:flex; gap:5px;">
                            <a href="{{ route('admin.bantuan-darurat.edit', $item) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.bantuan-darurat.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
