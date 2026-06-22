@extends('layouts.admin')
@section('header_title', 'Manajemen Fitur')

@section('styles')
<style>
/* ── Responsive Fixes: Features ── */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    padding: 4px 0;
}

.feature-card {
    background: var(--surface-primary);
    border: 1px solid var(--border-secondary);
    border-radius: var(--radius-xl);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow-sm);
    transition: all var(--duration-base) var(--ease-out);
    position: relative;
}
.feature-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-3px);
}

.feature-card__header {
    height: 6px;
}
.feature-card__body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.feature-card__icon-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 14px;
}
.feature-card__icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #fff;
    box-shadow: var(--shadow-md);
    flex-shrink: 0;
}
.feature-card__order {
    background: var(--gray-100);
    padding: 4px 10px;
    border-radius: var(--radius-full);
    font-size: 12px;
    font-weight: 700;
    color: var(--text-secondary);
}
.feature-card__title {
    font-size: 16px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 8px;
    line-height: 1.35;
    letter-spacing: -.01em;
}
.feature-card__desc {
    font-size: 13.5px;
    color: var(--text-secondary);
    line-height: 1.65;
    flex: 1;
    margin-bottom: 18px;
}
.feature-card__actions {
    display: flex;
    gap: 10px;
    padding-top: 14px;
    border-top: 1px solid var(--border-secondary);
}
.feature-card__actions .btn { flex: 1; justify-content: center; }

/* Page header responsive */
.page-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

@media (max-width: 640px) {
    .features-grid {
        grid-template-columns: 1fr;
    }
    .page-header-row {
        flex-direction: column;
        align-items: stretch;
    }
    .page-header-row .btn {
        width: 100%;
        justify-content: center;
    }
}
@media (min-width: 641px) and (max-width: 900px) {
    .features-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header-row">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-star" style="color:var(--brand-500); margin-right:10px; font-size:22px;"></i>
            Manajemen Fitur
        </h1>
        <p class="page-header__desc">Kelola kartu fitur yang tampil di halaman utama SIGAP TUHA (maks. 5 fitur).</p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('beranda') }}" class="btn btn-outline btn-sm" target="_blank">
            <i class="fas fa-external-link-alt"></i> Lihat Beranda
        </a>
        <a href="{{ route('admin.features.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Fitur
        </a>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="flash-message success" id="flashMsg">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="document.getElementById('flashMsg').remove()" style="margin-left:auto; background:none; border:none; cursor:pointer; color:inherit; opacity:0.6; font-size:18px;">&times;</button>
    </div>
@endif

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card brand">
        <div class="stat-card__top">
            <span class="stat-card__label">Total Fitur</span>
            <div class="stat-card__icon brand"><i class="fas fa-star"></i></div>
        </div>
        <div class="stat-card__value">{{ $features->count() }}</div>
        <div class="stat-card__change up"><i class="fas fa-check" style="font-size:10px"></i> Aktif Ditampilkan</div>
    </div>
    <div class="stat-card success">
        <div class="stat-card__top">
            <span class="stat-card__label">Slot Tersisa</span>
            <div class="stat-card__icon success"><i class="fas fa-plus-circle"></i></div>
        </div>
        <div class="stat-card__value">{{ max(0, 5 - $features->count()) }}</div>
        <div class="stat-card__change up"><i class="fas fa-layer-group" style="font-size:10px"></i> dari 5 slot</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-card__top">
            <span class="stat-card__label">Terakhir Diubah</span>
            <div class="stat-card__icon warning"><i class="fas fa-clock"></i></div>
        </div>
        <div class="stat-card__value" style="font-size:18px; margin-top:4px;">
            {{ $features->sortByDesc('updated_at')->first()?->updated_at?->format('d M') ?? '—' }}
        </div>
        <div class="stat-card__change up" style="font-size:10.5px;"><i class="fas fa-sync" style="font-size:9px"></i> Diperbarui</div>
    </div>
</div>

{{-- Info Bar --}}
@if($features->count() >= 5)
<div style="padding:14px 18px; background:var(--warning-50); border:1px solid #fde68a; border-radius:var(--radius-lg); display:flex; align-items:center; gap:12px; margin-bottom:20px; flex-wrap:wrap;">
    <i class="fas fa-exclamation-triangle" style="color:var(--warning-500); font-size:18px; flex-shrink:0;"></i>
    <span style="font-size:13.5px; color:var(--text-secondary); flex:1;">
        <strong>Batas 5 fitur tercapai.</strong> Hapus fitur yang ada sebelum menambahkan yang baru.
    </span>
</div>
@endif

{{-- Features Grid Card --}}
<div class="card">
    <div class="card__header">
        <h3 class="card__title">
            <i class="fas fa-th-large"></i> Kartu Fitur Halaman Utama
            <span class="badge badge--brand" style="margin-left:8px; font-size:11px;">{{ $features->count() }} / 5</span>
        </h3>
    </div>

    @if($features->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="far fa-folder-open"></i></div>
            <div class="empty-state__title">Belum Ada Fitur</div>
            <div class="empty-state__desc">Tambahkan fitur pertama yang akan ditampilkan di halaman beranda SIGAP TUHA.</div>
            <a href="{{ route('admin.features.create') }}" class="btn btn-primary" style="margin-top:4px;">
                <i class="fas fa-plus"></i> Tambah Fitur Pertama
            </a>
        </div>
    @else
        @php
            $colorMap = [
                'blue'   => ['bg' => 'linear-gradient(135deg, #3b6cf9, #1d37db)', 'light' => '#dae6ff'],
                'gold'   => ['bg' => 'linear-gradient(135deg, #f59e0b, #b45309)', 'light' => '#fef3c7'],
                'red'    => ['bg' => 'linear-gradient(135deg, #f04438, #b42318)', 'light' => '#fef3f2'],
                'green'  => ['bg' => 'linear-gradient(135deg, #12b76a, #027a48)', 'light' => '#ecfdf3'],
                'purple' => ['bg' => 'linear-gradient(135deg, #8b5cf6, #6d28d9)', 'light' => '#f5f3ff'],
            ];
        @endphp

        <div class="features-grid">
            @foreach($features->sortBy('order') as $feature)
            @php
                $colors = $colorMap[$feature->color_class] ?? $colorMap['blue'];
            @endphp
            <div class="feature-card">
                <div class="feature-card__header" style="background:{{ $colors['bg'] }};"></div>
                <div class="feature-card__body">
                    <div class="feature-card__icon-row">
                        <div class="feature-card__icon" style="background:{{ $colors['bg'] }};">
                            @if($feature->icon_svg)
                                {!! $feature->icon_svg !!}
                            @elseif($feature->icon)
                                <i class="{{ $feature->icon }}"></i>
                            @else
                                <i class="fas fa-star"></i>
                            @endif
                        </div>
                        <span class="feature-card__order">
                            <i class="fas fa-sort-numeric-down" style="font-size:10px; margin-right:3px;"></i> #{{ $feature->order }}
                        </span>
                    </div>

                    <div class="feature-card__title">{{ $feature->title }}</div>
                    <p class="feature-card__desc">{{ Str::limit($feature->description, 130) }}</p>

                    <div class="feature-card__actions">
                        <a href="{{ route('admin.features.edit', $feature) }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('admin.features.destroy', $feature) }}" method="POST" style="flex:1; display:flex;"
                            onsubmit="return confirm('Hapus fitur \'{{ addslashes($feature->title) }}\'?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" style="flex:1; justify-content:center;">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="padding:16px 4px 0; border-top:1px solid var(--border-secondary); margin-top:20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
            <span style="font-size:12.5px; color:var(--text-tertiary);">
                Menampilkan <strong>{{ $features->count() }}</strong> dari maksimal <strong>5</strong> fitur
            </span>
            @if($features->count() < 5)
                <a href="{{ route('admin.features.create') }}" class="btn btn-outline btn-sm">
                    <i class="fas fa-plus"></i> Tambah Fitur Baru
                </a>
            @endif
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
setTimeout(() => {
    const el = document.getElementById('flashMsg');
    if (el) { el.style.opacity='0'; el.style.transition='opacity .4s'; setTimeout(()=>el.remove(),400); }
}, 4000);
</script>
@endsection
