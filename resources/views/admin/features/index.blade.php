@extends('layouts.admin')

@section('header_title', 'Manajemen Fitur')

@section('content')
{{-- Page Header --}}
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div>
        <h1 class="page-header__title">Manajemen Fitur</h1>
        <p class="page-header__desc">Kelola fitur-fitur yang ditampilkan di halaman utama SIGAP TUHA.</p>
    </div>
    <a href="{{ route('admin.features.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Fitur
    </a>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-list"></i> Daftar Fitur Halaman Utama</h3>
        <span style="font-size:13px; color:var(--text-tertiary);">
            <i class="fas fa-info-circle"></i> Total: {{ $features->count() }} fitur
        </span>
    </div>

    @if($features->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="far fa-folder-open"></i></div>
            <div class="empty-state__title">Belum Ada Fitur</div>
            <div class="empty-state__desc">Klik tombol "+ Tambah Fitur" untuk mulai menambahkan fitur ke halaman utama.</div>
            <a href="{{ route('admin.features.create') }}" class="btn btn-primary" style="margin-top:16px;">
                <i class="fas fa-plus"></i> Tambah Fitur Pertama
            </a>
        </div>
    @else
        <div class="grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:24px; padding:24px;">
            @foreach($features as $feature)
                @php
                    // Map color class to actual hex/rgb for display
                    $colorMap = [
                        'blue' => 'var(--brand-500)',
                        'gold' => '#f59e0b',
                        'red' => 'var(--danger-500)',
                        'green' => 'var(--success-500)',
                        'purple' => '#8b5cf6'
                    ];
                    $bgColor = $colorMap[$feature->color_class] ?? 'var(--brand-500)';
                @endphp
                <div style="background:var(--surface-primary); border:1px solid var(--border-secondary); border-radius:var(--radius-xl); overflow:hidden; display:flex; flex-direction:column; box-shadow:var(--shadow-sm); transition:all 0.2s; position:relative;">
                    {{-- Decorative Header --}}
                    <div style="height:60px; background:{{ $bgColor }}; opacity:0.1; position:absolute; top:0; left:0; width:100%;"></div>
                    
                    <div style="padding:24px; position:relative; z-index:1; display:flex; flex-direction:column; flex:1;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
                            <div style="width:48px; height:48px; border-radius:var(--radius-lg); background:{{ $bgColor }}; color:#fff; display:flex; align-items:center; justify-content:center; font-size:20px; box-shadow:0 4px 12px {{ str_replace(')', ', 0.3)', str_replace('rgb', 'rgba', $bgColor)) }};">
                                <i class="{{ $feature->icon }}"></i>
                            </div>
                            <span style="background:var(--gray-50); padding:4px 10px; border-radius:var(--radius-full); font-size:12px; font-weight:700; color:var(--text-secondary); border:1px solid var(--border-secondary);">
                                Urutan: {{ $feature->order }}
                            </span>
                        </div>
                        
                        <h4 style="font-size:18px; font-weight:800; color:var(--text-primary); margin-bottom:8px; line-height:1.3;">{{ $feature->title }}</h4>
                        <p style="font-size:13.5px; color:var(--text-secondary); line-height:1.6; margin-bottom:24px; flex:1;">
                            {{ Str::limit($feature->description, 120) }}
                        </p>
                        
                        <div style="display:flex; gap:10px; margin-top:auto; padding-top:16px; border-top:1px solid var(--border-secondary);">
                            <a href="{{ route('admin.features.edit', $feature) }}" class="btn btn-outline" style="flex:1; justify-content:center;">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <form action="{{ route('admin.features.destroy', $feature) }}" method="POST" style="flex:1; display:flex;" onsubmit="return confirm('Yakin ingin menghapus fitur ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="flex:1; justify-content:center;">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
