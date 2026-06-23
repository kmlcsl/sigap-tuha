@extends('layouts.sigap')

@section('title', 'Berita & Informasi - SIGAP TUHA')

@section('content')
    <style>
        .berita-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }
        @media (max-width: 600px) {
            .berita-grid {
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }
            .berita-card-title {
                font-size: 14px !important;
            }
            .berita-card-desc {
                font-size: 12px !important;
                margin-bottom: 12px !important;
            }
            .berita-card-date {
                font-size: 10px !important;
            }
            .berita-card-link {
                font-size: 12px !important;
            }
            .berita-card-img {
                height: 120px !important;
            }
        }
    </style>
    <div class="page-content">
        <div class="content-box" style="background:rgba(255,255,255,0.95);max-width:100%;padding:40px 28px;">
            <div style="margin-bottom: 30px; text-align: center;">
                <h2 style="font-size: 28px; font-weight: 800; color: var(--text-primary);">Berita & Informasi</h2>
                <div style="width: 60px; height: 4px; background: var(--brand-500); border-radius: 2px; margin: 16px auto;"></div>
                <p style="color: var(--text-secondary); max-width: 600px; margin: 10px auto;">Informasi terkini, pengumuman, dan artikel terbaru seputar program SIGAP TUHA.</p>
            </div>

            @if(isset($beritas) && $beritas->count() > 0)
                <div class="berita-grid">
                    @foreach($beritas as $berita)
                        <div style="background: #E6E6E6; border-radius: var(--radius-xl); overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #c0c0c0; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.08)';">
                            @if($berita->gambar)
                                <img src="{{ asset($berita->gambar) }}" alt="{{ $berita->judul }}" class="berita-card-img" style="width: 100%; height: 200px; object-fit: cover;">
                            @else
                                <div class="berita-card-img" style="width: 100%; height: 200px; background: var(--gray-100); display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                                    <i class="fas fa-image fa-3x"></i>
                                </div>
                            @endif
                            <div style="padding: 20px;">
                                <div class="berita-card-date" style="font-size: 12px; color: var(--text-tertiary); margin-bottom: 8px;"><i class="fas fa-calendar-alt"></i> {{ $berita->created_at->translatedFormat('d F Y') }}</div>
                                <h3 class="berita-card-title" style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 12px; line-height: 1.4;">
                                    <a href="javascript:void(0)" onclick="openBeritaModal('{{ addslashes($berita->judul) }}', '{{ $berita->created_at->translatedFormat('d F Y') }}', '{{ $berita->gambar ? asset($berita->gambar) : '' }}', `{{ addslashes(nl2br(e($berita->konten))) }}`)" style="color: inherit; text-decoration: none;">{{ $berita->judul }}</a>
                                </h3>
                                <p class="berita-card-desc" style="font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 20px;">
                                    {{ Str::limit(strip_tags($berita->konten), 100) }}
                                </p>
                                <a href="javascript:void(0)" onclick="openBeritaModal('{{ addslashes($berita->judul) }}', '{{ $berita->created_at->translatedFormat('d F Y') }}', '{{ $berita->gambar ? asset($berita->gambar) : '' }}', `{{ addslashes(nl2br(e($berita->konten))) }}`)" class="berita-card-link" style="display: inline-block; font-size: 14px; font-weight: 600; color: var(--brand-600); text-decoration: none; cursor:pointer;">Baca Selengkapnya <i class="fas fa-arrow-right" style="font-size: 12px; margin-left: 4px;"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 40px 20px;">
                    <div style="font-size: 48px; color: var(--gray-300); margin-bottom: 16px;"><i class="fas fa-newspaper"></i></div>
                    <h3>Belum Ada Berita</h3>
                    <p style="color: var(--text-secondary);">Saat ini belum ada berita atau informasi yang dipublikasikan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Berita -->
    <div class="modal-backdrop" id="beritaModal" onclick="closeBeritaModal(event)">
        <div class="modal-panel" id="modalBeritaContent" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeBeritaModal(null, true)">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="modal-img-wrap" id="beritaModalImgWrap" style="display:none;">
                <img id="beritaModalImg" src="" alt="Gambar Berita">
            </div>
            <div class="modal-body-content">
                <div style="font-size: 12px; color: var(--text-tertiary); margin-bottom: 8px;" id="beritaModalDate"><i class="fas fa-calendar-alt"></i> Tanggal</div>
                <h3 id="beritaModalTitle" style="font-size:24px; margin-bottom: 16px; line-height: 1.3;">Judul Berita</h3>
                <div class="modal-divider"></div>
                <div class="modal-text custom-scrollbar" style="max-height: 50vh; overflow-y: auto;">
                    <div id="beritaModalDesc" style="line-height: 1.8; color: var(--text-secondary); font-size: 15px;">Deskripsi lengkap...</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openBeritaModal(title, date, img, content) {
            document.getElementById('beritaModalTitle').innerText = title;
            document.getElementById('beritaModalDate').innerHTML = `<i class="fas fa-calendar-alt"></i> ${date}`;
            
            const imgWrap = document.getElementById('beritaModalImgWrap');
            const imgEl = document.getElementById('beritaModalImg');
            if(img) {
                imgEl.src = img;
                imgWrap.style.display = 'block';
            } else {
                imgWrap.style.display = 'none';
            }
            
            document.getElementById('beritaModalDesc').innerHTML = content;
            
            const modal = document.getElementById('beritaModal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeBeritaModal(e, force = false) {
            if (force || (e && e.target.id === 'beritaModal')) {
                const modal = document.getElementById('beritaModal');
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }
    </script>
@endsection
