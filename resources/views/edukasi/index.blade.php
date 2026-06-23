@extends('layouts.sigap')

@section('title', 'Edukasi & Pelatihan - SIGAP TUHA')

@section('content')
<style>
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #f1f5f9;
    color: var(--navy);
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: 0.2s;
    margin-bottom: 20px;
}
.btn-back:hover {
    background: #e2e8f0;
    color: var(--blue);
}

.edu-tab {
    padding:8px 20px; background:#f1f5f9; border:1px solid transparent; border-radius:30px; font-size:14px; font-weight:600; color:var(--muted); cursor:pointer; transition:all 0.2s;
}
.edu-tab:hover { background:#e2e8f0; color:var(--ink); }
.edu-tab.active { background:#0d9488; color:#fff; box-shadow:0 4px 12px rgba(13,148,136,0.2); }

.edu-card {
    background: #E6E6E6; 
    border-radius: 24px; 
    overflow: hidden; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.08); 
    border: 1px solid #c0c0c0; 
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
}
.edu-card:hover { transform:translateY(-4px); box-shadow:0 8px 25px rgba(0,0,0,0.15); }
.edu-card:hover .play-overlay { opacity: 1 !important; }
.edu-card:hover .btn-tonton { background:#0d9488 !important; color:#fff !important; border-color:#0d9488 !important; }

/* Modal Edukasi */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(5px);
    z-index: 1050;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.modal-overlay.active { display: flex; }
.modal-box {
    background: #fff;
    border-radius: 24px;
    max-width: 800px;
    width: 100%;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 24px 64px rgba(0,0,0,0.3);
    animation: modalIn .3s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes modalIn {
    from { opacity:0; transform: scale(.96) translateY(20px); }
    to   { opacity:1; transform: scale(1) translateY(0); }
}
.modal-header {
    background: #0d9488;
    color: #fff;
    padding: 20px 24px;
    border-radius: 24px 24px 0 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}
.modal-header h3 { font-size: 18px; font-weight: 800; margin: 0; padding-right: 16px; line-height: 1.4; }
.modal-close {
    background: rgba(255,255,255,0.2);
    border: none;
    color: #fff;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
    flex-shrink: 0;
}
.modal-close:hover { background: rgba(255,255,255,0.3); }
.modal-body {
    padding: 0;
    overflow-y: auto;
    flex: 1;
    border-radius: 0 0 24px 24px;
}
.modal-video-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 */
    height: 0;
    overflow: hidden;
    background: #000;
}
.modal-video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}
.modal-article-content {
    padding: 32px;
    color: var(--ink);
    font-size: 15px;
    line-height: 1.8;
}
.modal-article-content img { max-width: 100%; border-radius: 12px; margin: 16px 0; }
.modal-article-content h1, .modal-article-content h2, .modal-article-content h3 { color: var(--ink); margin-top: 24px; margin-bottom: 12px; font-weight: 800; }
.modal-article-content p { margin-bottom: 16px; }
.modal-article-content ul, .modal-article-content ol { padding-left: 20px; margin-bottom: 16px; }
</style>

<div class="page-content">
    <div class="content-box" style="background:rgba(255,255,255,0.95);max-width:100%;padding:40px 28px;">
        
        <a href="{{ route('beranda') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>

        <div style="margin-bottom: 30px; text-align: center;">
            <div style="font-size: 48px; color: #0d9488; margin-bottom: 16px;"><i class="fas fa-graduation-cap"></i></div>
            <h2 style="font-size: 28px; font-weight: 800; color: var(--ink);">Edukasi & Pelatihan</h2>
            <div style="width: 60px; height: 4px; background: #0d9488; border-radius: 2px; margin: 16px auto;"></div>
            <p style="color: var(--muted); max-width: 600px; margin: 10px auto;">Tingkatkan pengetahuan dan kesiapsiagaan Anda dengan materi pelatihan komprehensif dari SIGAP TUHA.</p>
        </div>

        <div style="text-align: center; color: var(--muted); font-size: 14px; font-weight: 500; margin-bottom: 40px;">
            <span style="display: inline-block; padding: 8px 20px; background: rgba(13,148,136,0.1); color: #0d9488; border-radius: 20px;">
                <strong>{{ \App\Models\Edukasi::where('is_published', true)->count() }}</strong> Total Materi &nbsp;&nbsp;&bull;&nbsp;&nbsp; 
                <strong>{{ \App\Models\Edukasi::where('is_published', true)->where('jenis', 'Video')->count() }}</strong> Video Tersedia &nbsp;&nbsp;&bull;&nbsp;&nbsp; 
                <strong>{{ \App\Models\Edukasi::where('is_published', true)->where('sertifikat_tersedia', true)->count() }}</strong> Sertifikat Tersedia
            </span>
        </div>

        @php
            $edukasis = \App\Models\Edukasi::where('is_published', true)->orderBy('order')->orderBy('created_at', 'desc')->get();
            // Data untuk modal
            $eduData = $edukasis->mapWithKeys(function($edu) {
                return [$edu->id => [
                    'id' => $edu->id,
                    'judul' => $edu->judul,
                    'jenis' => $edu->jenis,
                    'kategori' => $edu->kategori,
                    'embed_url' => $edu->youtube_embed_url,
                    'konten' => $edu->konten,
                ]];
            });
        @endphp

        @if($edukasis->isEmpty())
            <div style="text-align:center; padding:60px 20px;">
                <div style="font-size:48px; color:#cbd5e1; margin-bottom:16px;"><i class="fas fa-folder-open"></i></div>
                <h3 style="font-size:20px; font-weight:700; color:var(--ink); margin-bottom:8px;">Belum Ada Materi Edukasi</h3>
                <p style="color:var(--muted);">Materi edukasi dan pelatihan sedang dalam tahap persiapan.</p>
            </div>
        @else
            <!-- FILTER TABS -->
            <div style="display:flex; justify-content:center; gap:8px; margin-bottom:32px; flex-wrap:wrap;">
                <button class="edu-tab active" data-filter="all">Semua</button>
                <button class="edu-tab" data-filter="BHD">BHD</button>
                <button class="edu-tab" data-filter="Evakuasi">Evakuasi</button>
                <button class="edu-tab" data-filter="Pertolongan Pertama">Pertolongan Pertama</button>
                <button class="edu-tab" data-filter="Lainnya">Lainnya</button>
            </div>

            <!-- GRID -->
            <div class="edu-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(320px, 1fr)); gap:24px;">
                @foreach($edukasis as $edu)
                    <div class="edu-card" data-kategori="{{ $edu->kategori }}" style="display:flex; flex-direction:column; height:100%;" onclick="openEduModal({{ $edu->id }})">
                        <!-- Thumbnail -->
                        <div style="position:relative; padding-bottom:56.25%; background:#f8fafc; border-bottom:1px solid #c0c0c0;">
                            @if($edu->youtube_thumbnail)
                                <img src="{{ $edu->youtube_thumbnail }}" alt="{{ $edu->judul }}" style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">
                                <div style="position:absolute; inset:0; background:rgba(0,0,0,0.1); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity 0.3s;" class="play-overlay">
                                    <div style="width:64px; height:64px; background:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#ef4444; font-size:24px; box-shadow:0 8px 16px rgba(0,0,0,0.1);">
                                        <i class="fas fa-play" style="margin-left:4px;"></i>
                                    </div>
                                </div>
                            @else
                                <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; color:#64748b; font-size:48px;">
                                    @if($edu->jenis == 'Artikel') <i class="fas fa-file-alt"></i> @else <i class="fas fa-file-pdf"></i> @endif
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div style="position:absolute; top:12px; left:12px; display:flex; gap:8px;">
                                @php
                                    $katColor = ['BHD'=>'#3b82f6', 'Evakuasi'=>'#f97316', 'Pertolongan Pertama'=>'#22c55e', 'Lainnya'=>'#64748b'][$edu->kategori] ?? '#64748b';
                                @endphp
                                <span style="background:{{ $katColor }}; color:#fff; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; box-shadow:0 2px 4px rgba(0,0,0,0.1);">{{ $edu->kategori }}</span>
                                @if($edu->jenis == 'Video')
                                    <span style="background:rgba(255,255,255,0.9); color:#0f172a; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; display:flex; align-items:center; gap:4px; box-shadow:0 2px 4px rgba(0,0,0,0.1);"><i class="fas fa-video text-red-500"></i> Video</span>
                                @elseif($edu->jenis == 'SOP')
                                    <span style="background:rgba(255,255,255,0.9); color:#0f172a; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; display:flex; align-items:center; gap:4px; box-shadow:0 2px 4px rgba(0,0,0,0.1);"><i class="fas fa-file-pdf text-blue-500"></i> SOP</span>
                                @else
                                    <span style="background:rgba(255,255,255,0.9); color:#0f172a; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; display:flex; align-items:center; gap:4px; box-shadow:0 2px 4px rgba(0,0,0,0.1);"><i class="fas fa-file-alt text-green-500"></i> Artikel</span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div style="padding:20px; display:flex; flex-direction:column; flex:1;">
                            <h3 style="font-size:18px; font-weight:700; color:var(--ink); margin-bottom:8px; line-height:1.4;">{{ $edu->judul }}</h3>
                            
                            <div style="font-size:14px; color:var(--muted); margin-bottom:20px; flex:1; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                {{ $edu->materi_pembahasan ?: Str::limit(strip_tags($edu->konten), 100) }}
                            </div>

                            <button style="display:inline-flex; align-items:center; justify-content:center; width:100%; padding:10px; background:rgba(255,255,255,0.7); border:1px solid #c0c0c0; color:#0d9488; border-radius:10px; font-weight:600; transition:all 0.2s;" class="btn-tonton">
                                @if($edu->jenis == 'Video') Tonton Video @else Baca Materi @endif <i class="fas fa-arrow-right" style="margin-left:8px; font-size:12px;"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- MODAL EDUKASI --}}
<div class="modal-overlay" id="eduModalOverlay" onclick="closeEduModalOutside(event)">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="eduModalTitle">Detail Edukasi</h3>
            <button class="modal-close" onclick="closeEduModal()">×</button>
        </div>
        <div class="modal-body" id="eduModalBody">
            <!-- Content will be injected here -->
        </div>
    </div>
</div>

<script>
const eduData = @json($eduData ?? []);

function openEduModal(id) {
    const data = eduData[id];
    if(!data) return;

    document.getElementById('eduModalTitle').textContent = data.judul;
    const body = document.getElementById('eduModalBody');
    body.innerHTML = ''; // Reset

    let html = '';

    // Jika ada video embed (jenis Video dan punya embed_url)
    if (data.jenis === 'Video' && data.embed_url) {
        html += `
            <div class="modal-video-container">
                <iframe src="${data.embed_url}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        `;
    }

    // Selalu tampilkan konten artikel jika ada di bawahnya (atau sebagai konten utama jika bukan video)
    if (data.konten && data.konten.trim() !== '') {
        html += `<div class="modal-article-content">${data.konten}</div>`;
    } else if (data.jenis !== 'Video') {
        html += `<div class="modal-article-content"><p style="color:#64748b;text-align:center;padding:40px;">Belum ada konten tulisan untuk materi ini.</p></div>`;
    }

    body.innerHTML = html;

    document.getElementById('eduModalOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeEduModal() {
    document.getElementById('eduModalOverlay').classList.remove('active');
    document.body.style.overflow = '';
    // Stop video playing by clearing innerHTML
    document.getElementById('eduModalBody').innerHTML = '';
}

function closeEduModalOutside(e) {
    if (e.target === document.getElementById('eduModalOverlay')) {
        closeEduModal();
    }
}

document.addEventListener('keydown', e => { 
    if (e.key === 'Escape' && document.getElementById('eduModalOverlay').classList.contains('active')) {
        closeEduModal(); 
    }
});

// TAB FILTER LOGIC
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.edu-tab');
    const cards = document.querySelectorAll('.edu-card');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            cards.forEach(card => {
                if (filter === 'all' || card.dataset.kategori === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection
