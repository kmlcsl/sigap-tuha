@extends('layouts.admin')
@section('header_title', 'Detail Program & Kegiatan')

@section('content')

{{-- Page Header --}}
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
            <a href="{{ route('admin.programs.index') }}" style="font-size:13px; color:var(--text-tertiary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:color .2s;"
                onmouseover="this.style.color='var(--brand-600)'" onmouseout="this.style.color='var(--text-tertiary)'">
                <i class="fas fa-project-diagram" style="font-size:11px;"></i> Program
            </a>
            <i class="fas fa-chevron-right" style="font-size:10px; color:var(--gray-300);"></i>
            <span style="font-size:13px; color:var(--text-secondary);">{{ Str::limit($program->nama, 35) }}</span>
        </div>
        <h1 class="page-header__title">
            <i class="fas fa-folder-open" style="color:var(--brand-500); margin-right:10px; font-size:22px;"></i>
            {{ $program->nama }}
        </h1>
        <p class="page-header__desc">Detail program dan manajemen kegiatan di dalamnya.</p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('admin.programs.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Semua Program
        </a>
        <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-outline">
            <i class="fas fa-pen"></i> Edit Program
        </a>
        <a href="{{ route('admin.programs.kegiatans.create', $program) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kegiatan
        </a>
    </div>
</div>



{{-- Detail Two-Column Grid --}}
<div class="grid grid-2" style="margin-bottom:24px; align-items:start;">
    {{-- Program Info Card --}}
    <div class="card">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-info-circle"></i> Informasi Program</h3>
            <span class="badge badge--success"><span class="badge__dot"></span> Aktif</span>
        </div>

        <div style="display:flex; align-items:center; gap:16px; padding:16px; background:var(--gray-50); border-radius:var(--radius-lg); margin-bottom:20px;">
            <div style="width:56px; height:56px; border-radius:var(--radius-xl); background:linear-gradient(135deg, var(--success-500) 0%, var(--brand-600) 100%); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 4px 12px rgba(37,74,238,.2);">
                <i class="fas fa-project-diagram" style="color:#fff; font-size:22px;"></i>
            </div>
            <div>
                <div style="font-size:18px; font-weight:800; color:var(--text-primary); letter-spacing:-.02em;">{{ $program->nama }}</div>
                <div style="font-size:12px; color:var(--text-tertiary); margin-top:3px;">Program ID: #{{ $program->id }}</div>
            </div>
        </div>

        {{-- Detail Rows --}}
        <div style="display:flex; flex-direction:column; gap:0;">
            <div style="display:flex; align-items:flex-start; gap:14px; padding:12px 0; border-bottom:1px solid var(--border-secondary);">
                <div style="width:32px; height:32px; border-radius:var(--radius-md); background:var(--success-50); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-align-left" style="color:var(--success-500); font-size:12px;"></i>
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:11.5px; font-weight:600; color:var(--text-tertiary); text-transform:uppercase; letter-spacing:.04em; margin-bottom:4px;">Deskripsi</div>
                    <div style="font-size:14px; color:var(--text-primary); line-height:1.7;">
                        {{ $program->deskripsi ?: 'Tidak ada deskripsi untuk program ini.' }}
                    </div>
                </div>
            </div>

            <div style="display:flex; align-items:center; gap:14px; padding:12px 0; border-bottom:1px solid var(--border-secondary);">
                <div style="width:32px; height:32px; border-radius:var(--radius-md); background:var(--brand-50); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-tasks" style="color:var(--brand-500); font-size:12px;"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:11.5px; font-weight:600; color:var(--text-tertiary); text-transform:uppercase; letter-spacing:.04em;">Total Kegiatan</div>
                    <div style="font-size:22px; font-weight:800; color:var(--text-primary);">{{ $program->kegiatans->count() }}</div>
                </div>
                <span class="badge badge--brand">Kegiatan</span>
            </div>

            <div style="display:flex; align-items:center; gap:14px; padding:12px 0; border-bottom:1px solid var(--border-secondary);">
                <div style="width:32px; height:32px; border-radius:var(--radius-md); background:var(--warning-50); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-calendar-plus" style="color:var(--warning-500); font-size:12px;"></i>
                </div>
                <div>
                    <div style="font-size:11.5px; font-weight:600; color:var(--text-tertiary); text-transform:uppercase; letter-spacing:.04em;">Dibuat</div>
                    <div style="font-size:14px; color:var(--text-primary); font-weight:600;">{{ $program->created_at->translatedFormat('d F Y') }}</div>
                    <div style="font-size:12px; color:var(--text-tertiary);">{{ $program->created_at->diffForHumans() }}</div>
                </div>
            </div>

            <div style="display:flex; align-items:center; gap:14px; padding:12px 0;">
                <div style="width:32px; height:32px; border-radius:var(--radius-md); background:var(--info-50); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-clock" style="color:var(--info-500); font-size:12px;"></i>
                </div>
                <div>
                    <div style="font-size:11.5px; font-weight:600; color:var(--text-tertiary); text-transform:uppercase; letter-spacing:.04em;">Diperbarui</div>
                    <div style="font-size:14px; color:var(--text-primary); font-weight:600;">{{ $program->updated_at->translatedFormat('d F Y') }}</div>
                    <div style="font-size:12px; color:var(--text-tertiary);">{{ $program->updated_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div style="margin-top:20px; padding-top:16px; border-top:1px solid var(--border-secondary); display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-outline btn-sm">
                <i class="fas fa-pen"></i> Edit Program
            </a>
            <form action="{{ route('admin.programs.destroy', $program) }}" method="POST"
                onsubmit="return confirm('Hapus program ini beserta semua kegiatannya?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Quick Stats Card --}}
    <div style="display:flex; flex-direction:column; gap:16px;">
        <div class="card" style="padding:20px;">
            <div style="font-size:12px; font-weight:600; color:var(--text-tertiary); text-transform:uppercase; letter-spacing:.06em; margin-bottom:14px;">
                <i class="fas fa-chart-bar" style="margin-right:6px;"></i> Statistik Kegiatan
            </div>
            @php
                $kegiatans = $program->kegiatans;
                $withFoto  = $kegiatans->filter(fn($k) => $k->foto)->count();
                $noFoto    = $kegiatans->filter(fn($k) => !$k->foto)->count();
            @endphp
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:var(--success-50); border-radius:var(--radius-md);">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-image" style="color:var(--success-500); font-size:14px;"></i>
                        <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Dengan Foto</span>
                    </div>
                    <span style="font-size:18px; font-weight:800; color:var(--text-primary);">{{ $withFoto }}</span>
                </div>
                <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:var(--warning-50); border-radius:var(--radius-md);">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-image-slash" style="color:var(--warning-500); font-size:14px;"></i>
                        <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Tanpa Foto</span>
                    </div>
                    <span style="font-size:18px; font-weight:800; color:var(--text-primary);">{{ $noFoto }}</span>
                </div>
                <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:var(--brand-50); border-radius:var(--radius-md);">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-list" style="color:var(--brand-500); font-size:14px;"></i>
                        <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Total Kegiatan</span>
                    </div>
                    <span style="font-size:18px; font-weight:800; color:var(--text-primary);">{{ $kegiatans->count() }}</span>
                </div>
            </div>
        </div>

        {{-- Quick Add --}}
        <div class="card" style="padding:20px; background:linear-gradient(135deg, var(--brand-600), var(--brand-800)); border:none;">
            <div style="font-size:14px; font-weight:700; color:#fff; margin-bottom:8px;">
                <i class="fas fa-plus-circle" style="margin-right:6px;"></i> Tambah Kegiatan Baru
            </div>
            <p style="font-size:13px; color:rgba(255,255,255,.75); line-height:1.6; margin-bottom:16px;">
                Klik tombol di bawah untuk menambahkan kegiatan baru ke program ini.
            </p>
            <a href="{{ route('admin.programs.kegiatans.create', $program) }}" class="btn btn-sm"
                style="background:rgba(255,255,255,.15); color:#fff; border:1px solid rgba(255,255,255,.3); backdrop-filter:blur(8px);">
                <i class="fas fa-plus"></i> Tambah Kegiatan
            </a>
        </div>
    </div>
</div>

{{-- Daftar Kegiatan Table --}}
<div class="card">
    <div class="card__header" style="flex-wrap:wrap; gap:12px;">
        <h3 class="card__title">
            <i class="fas fa-tasks"></i> Daftar Kegiatan
            <span class="badge badge--brand" style="margin-left:8px; font-size:11px;">{{ $program->kegiatans->count() }}</span>
        </h3>
        <a href="{{ route('admin.programs.kegiatans.create', $program) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Kegiatan
        </a>
    </div>

    @if($program->kegiatans->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-clipboard-list"></i></div>
            <div class="empty-state__title">Belum Ada Kegiatan</div>
            <div class="empty-state__desc">Program ini belum memiliki kegiatan. Tambahkan kegiatan pertama sekarang.</div>
            <a href="{{ route('admin.programs.kegiatans.create', $program) }}" class="btn btn-primary" style="margin-top:4px;">
                <i class="fas fa-plus"></i> Tambah Kegiatan Pertama
            </a>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th style="width:80px;"><i class="fas fa-image" style="margin-right:4px;"></i> Foto</th>
                        <th><i class="fas fa-tag" style="margin-right:4px;"></i> Nama Kegiatan</th>
                        <th><i class="fas fa-align-left" style="margin-right:4px;"></i> Deskripsi Singkat</th>
                        <th style="width:160px; text-align:center;"><i class="fas fa-cogs" style="margin-right:4px;"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($program->kegiatans as $i => $kegiatan)
                    <tr>
                        <td><span style="font-weight:700; color:var(--text-tertiary);">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</span></td>
                        <td>
                            @if($kegiatan->foto)
                                <img src="{{ asset('storage/' . $kegiatan->foto) }}"
                                    alt="{{ $kegiatan->nama }}"
                                    style="width:52px; height:52px; object-fit:cover; border-radius:var(--radius-md); border:1px solid var(--border-secondary); cursor:zoom-in;"
                                    onclick="openImg('{{ asset('storage/' . $kegiatan->foto) }}', '{{ $kegiatan->nama }}')">
                            @else
                                <div style="width:52px; height:52px; border-radius:var(--radius-md); background:var(--gray-100); display:flex; align-items:center; justify-content:center; border:1px dashed var(--border-primary);">
                                    <i class="fas fa-image" style="color:var(--gray-300); font-size:18px;"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:700; color:var(--text-primary); font-size:14px; margin-bottom:2px;">{{ $kegiatan->nama }}</div>
                            <div style="font-size:11.5px; color:var(--text-tertiary);">ID: #{{ $kegiatan->id }}</div>
                        </td>
                        <td style="max-width:280px;">
                            <span style="color:var(--text-secondary); font-size:13.5px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                {{ Str::limit($kegiatan->deskripsi_lengkap, 80) ?: '—' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('admin.programs.kegiatans.edit', [$program, $kegiatan]) }}"
                                    class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('admin.programs.kegiatans.destroy', [$program, $kegiatan]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus kegiatan \'{{ addslashes($kegiatan->nama) }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 4px 0; flex-wrap:wrap; gap:8px;">
            <span style="font-size:12.5px; color:var(--text-tertiary);">
                Total <strong>{{ $program->kegiatans->count() }}</strong> kegiatan dalam program ini
            </span>
        </div>
    @endif
</div>

{{-- Image Lightbox --}}
<div id="imgLightbox" onclick="closeLightbox()"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.85); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(8px); cursor:zoom-out;">
    <div style="max-width:90vw; max-height:90vh; position:relative;">
        <img id="lightboxImg" src="" alt="" style="max-width:100%; max-height:85vh; border-radius:var(--radius-lg); box-shadow:0 24px 48px rgba(0,0,0,.5);">
        <div id="lightboxCaption" style="text-align:center; color:rgba(255,255,255,.8); font-size:14px; margin-top:12px; font-weight:600;"></div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openImg(src, caption) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxCaption').textContent = caption;
    const lb = document.getElementById('imgLightbox');
    lb.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('imgLightbox').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

// Auto dismiss flash
setTimeout(() => {
    const el = document.getElementById('flashMsg');
    if (el) { el.style.opacity='0'; el.style.transition='opacity .4s'; setTimeout(()=>el.remove(),400); }
}, 4000);
</script>
@endsection
