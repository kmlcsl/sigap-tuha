@extends('layouts.sigap')

@section('content')
<div class="page-content">
    <div class="content-box">
<!-- BREADCRUMB -->
<div style="background:#f8fafc; border-bottom:1px solid var(--border-color); padding:16px 20px;">
    <div style="max-width:1000px; margin:0 auto; font-size:14px; color:var(--text-tertiary); font-weight:500;">
        <a href="/" style="color:var(--brand-600); text-decoration:none;">Beranda</a> 
        <i class="fas fa-chevron-right" style="font-size:10px; margin:0 8px;"></i>
        <a href="{{ url('edukasi') }}" style="color:var(--brand-600); text-decoration:none;">Edukasi & Pelatihan</a>
        <i class="fas fa-chevron-right" style="font-size:10px; margin:0 8px;"></i>
        <span style="color:var(--text-primary);">{{ Str::limit($edukasi->judul, 40) }}</span>
    </div>
</div>

<div style="max-width:1000px; margin:40px auto; padding:0 20px;">
    
    <!-- JUDUL + METADATA -->
    <div style="margin-bottom:32px;">
        <div style="display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap;">
            @php
                $katColor = ['BHD'=>'#3b82f6', 'Evakuasi'=>'#f97316', 'Pertolongan Pertama'=>'#22c55e', 'Lainnya'=>'#64748b'][$edukasi->kategori] ?? '#64748b';
            @endphp
            <span style="background:{{ $katColor }}; color:#fff; padding:4px 12px; border-radius:20px; font-size:13px; font-weight:600;">{{ $edukasi->kategori }}</span>
            <span style="background:#f1f5f9; color:var(--text-secondary); padding:4px 12px; border-radius:20px; font-size:13px; font-weight:600;"><i class="fas {{ $edukasi->jenis == 'Video' ? 'fa-video' : ($edukasi->jenis == 'SOP' ? 'fa-file-pdf' : 'fa-file-alt') }}"></i> {{ $edukasi->jenis }}</span>
            @if($edukasi->durasi_menit)
                <span style="background:#f1f5f9; color:var(--text-secondary); padding:4px 12px; border-radius:20px; font-size:13px; font-weight:600;"><i class="fas fa-clock"></i> {{ $edukasi->durasi_menit }} menit</span>
            @endif
        </div>
        <h1 style="font-size:36px; font-weight:800; color:var(--text-primary); margin-bottom:16px; line-height:1.3;">{{ $edukasi->judul }}</h1>
        <div style="display:flex; align-items:center; gap:16px; color:var(--text-tertiary); font-size:14px; font-weight:500;">
            <span><i class="far fa-calendar-alt"></i> {{ $edukasi->created_at->format('d M Y') }}</span>
            @if($edukasi->sertifikat_tersedia)
                <span style="color:#0d9488;"><i class="fas fa-certificate"></i> Sertifikat Tersedia</span>
            @endif
        </div>
    </div>

    <!-- VIDEO EMBED -->
    @if($edukasi->jenis == 'Video' && $edukasi->youtube_embed_url)
        <div style="background:#0f172a; padding:16px; border-radius:24px; margin-bottom:32px; box-shadow:0 20px 40px rgba(0,0,0,0.1);">
            <div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:12px; background:#000;">
                <iframe src="{{ $edukasi->youtube_embed_url }}" 
                        style="position:absolute; top:0; left:0; width:100%; height:100%;" 
                        frameborder="0" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                </iframe>
            </div>
            <div style="margin-top:16px; display:flex; justify-content:flex-end;">
                <a href="{{ $edukasi->url_video }}" target="_blank" style="display:inline-flex; align-items:center; gap:8px; color:#cbd5e1; text-decoration:none; font-size:14px; font-weight:500; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#cbd5e1'">
                    <i class="fab fa-youtube" style="color:#ef4444; font-size:18px;"></i> Buka di YouTube
                </a>
            </div>
        </div>
    @endif

    <div style="display:grid; grid-template-columns:1fr 300px; gap:40px; align-items:start;">
        <!-- KONTEN -->
        <div style="background:#fff; border:1px solid var(--border-color); border-radius:24px; padding:32px; box-shadow:0 4px 20px rgba(0,0,0,0.03);">
            
            @if($edukasi->materi_pembahasan)
                <div style="background:#f8fafc; border-left:4px solid var(--brand-500); padding:20px 24px; border-radius:0 12px 12px 0; margin-bottom:32px;">
                    <h3 style="font-size:16px; font-weight:700; color:var(--text-primary); margin-bottom:12px;">Poin Pembahasan:</h3>
                    <ul style="margin:0; padding-left:20px; color:var(--text-secondary); line-height:1.6;">
                        @foreach(explode("\n", str_replace("\r", "", trim($edukasi->materi_pembahasan))) as $poin)
                            @if(trim($poin))
                                <li style="margin-bottom:8px;">{{ trim($poin) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="prose" style="max-width:none; color:var(--text-secondary); line-height:1.8; font-size:16px;">
                {!! $edukasi->konten !!}
            </div>

        </div>

        <!-- SIDEBAR: SERTIFIKAT -->
        <div>
            @if($edukasi->sertifikat_tersedia)
                <div style="background:linear-gradient(135deg, #0d9488 0%, #0f766e 100%); border-radius:24px; padding:32px 24px; text-align:center; color:#fff; box-shadow:0 12px 24px rgba(13,148,136,0.2); position:sticky; top:32px;">
                    <div style="width:64px; height:64px; background:rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:32px; margin:0 auto 20px;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 style="font-size:20px; font-weight:700; margin-bottom:12px;">Sertifikat Pelatihan</h3>
                    <p style="font-size:14px; opacity:0.9; margin-bottom:24px; line-height:1.5;">Anda berhak mendapatkan e-Sertifikat setelah menyelesaikan materi ini.</p>
                    <button onclick="openModal()" style="width:100%; padding:14px; background:#fff; color:#0f766e; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:pointer; transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fas fa-print" style="margin-right:8px;"></i> Cetak Sertifikat
                    </button>
                </div>
            @endif

            <div style="margin-top:24px;">
                <a href="{{ url('edukasi') }}" style="display:inline-flex; align-items:center; gap:8px; color:var(--text-secondary); text-decoration:none; font-weight:600; font-size:15px; transition:color 0.2s;" onmouseover="this.style.color='var(--brand-600)'" onmouseout="this.style.color='var(--text-secondary)'">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Edukasi
                </a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SERTIFIKAT -->
@if($edukasi->sertifikat_tersedia)
<div id="certModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; padding:20px; backdrop-filter:blur(4px);">
    <div style="background:#fff; width:100%; max-width:400px; border-radius:24px; padding:32px; box-shadow:0 24px 48px rgba(0,0,0,0.2); position:relative; animation:modalIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        <button onclick="closeModal()" style="position:absolute; top:20px; right:20px; background:none; border:none; font-size:20px; color:var(--text-tertiary); cursor:pointer;"><i class="fas fa-times"></i></button>
        <div style="text-align:center; margin-bottom:24px;">
            <div style="width:56px; height:56px; background:#f0fdfa; color:#0d9488; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:24px; margin:0 auto 16px;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h3 style="font-size:20px; font-weight:700; color:var(--text-primary);">Data Sertifikat</h3>
            <p style="font-size:14px; color:var(--text-secondary); margin-top:4px;">Masukkan nama lengkap Anda untuk dicetak pada sertifikat.</p>
        </div>
        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:13px; font-weight:600; color:var(--text-tertiary); margin-bottom:8px;">Nama Lengkap</label>
            <input type="text" id="inputNamaCert" class="form-control" placeholder="Contoh: Budi Santoso" style="width:100%; padding:12px 16px; border:1px solid var(--border-color); border-radius:12px; font-size:15px; outline:none; transition:border-color 0.2s;" onfocus="this.style.borderColor='var(--brand-500)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>
        <button onclick="doPrint()" style="width:100%; padding:14px; background:#0d9488; color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:pointer;">
            <i class="fas fa-print" style="margin-right:8px;"></i> Buat & Cetak
        </button>
    </div>
</div>

<!-- TEMPLATE SERTIFIKAT PRINT -->
<div id="sertifikat-print" style="display:none;">
    <div style="border:8px double #0d9488; padding:60px; text-align:center; font-family:'Georgia',serif; min-height:500px; background:#fff; margin:20px;">
        <div style="color:#0d9488; font-size:14px; letter-spacing:3px; text-transform:uppercase; margin-bottom:10px;">SIGAP TUHA</div>
        <h1 style="color:#1e3a5f; font-size:40px; margin:0 0 5px;">SERTIFIKAT</h1>
        <p style="color:#666; font-size:16px; margin:0 0 30px;">Pelatihan & Edukasi</p>
        <hr style="border:2px solid #0d9488; margin:20px auto; width:60%;">
        <p style="font-size:18px; color:#333; margin-bottom:5px;">Diberikan kepada:</p>
        <h2 id="nama-sertifikat" style="font-size:48px; color:#0d9488; font-style:italic; margin:15px 0;"></h2>
        <p style="font-size:15px; color:#555;">Telah berhasil menyelesaikan materi:</p>
        <h3 style="font-size:24px; color:#1e3a5f; margin:10px 0 30px;">{{ $edukasi->judul }}</h3>
        <p style="font-size:13px; color:#888;">Kategori: {{ $edukasi->kategori }} | Tanggal: {{ now()->format('d F Y') }}</p>
        <div style="margin-top:40px; font-size:12px; color:#aaa;">Karang Taruna SIGAP TUHA &mdash; Aceh Tengah</div>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity:0; transform:scale(0.95) translateY(10px); }
    to { opacity:1; transform:scale(1) translateY(0); }
}
@media print {
    body > *:not(#sertifikat-print) { display: none !important; }
    #sertifikat-print { display: block !important; }
    @page { size: landscape; margin: 0; }
}
</style>
<script>
function openModal() {
    document.getElementById('certModal').style.display = 'flex';
    document.getElementById('inputNamaCert').focus();
}
function closeModal() {
    document.getElementById('certModal').style.display = 'none';
}
function doPrint() {
    const nama = document.getElementById('inputNamaCert').value.trim();
    if(!nama) {
        alert('Silakan masukkan nama Anda!');
        return;
    }
    document.getElementById('nama-sertifikat').innerText = nama;
    closeModal();
    window.print();
}
</script>
@endif

    </div>
</div>
@endsection
