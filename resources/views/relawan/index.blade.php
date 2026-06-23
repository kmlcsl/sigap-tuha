@extends('layouts.sigap')

@section('title', 'Relawan Siaga - SIGAP TUHA')

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

    .relawan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }
    @media (max-width: 600px) {
        .relawan-grid {
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .relawan-card-title {
            font-size: 14px !important;
        }
        .relawan-card-desc {
            font-size: 12px !important;
            margin-bottom: 12px !important;
        }
        .relawan-card-date {
            font-size: 10px !important;
        }
        .relawan-card-link {
            font-size: 12px !important;
        }
        .accordion-btn {
            font-size: 12px !important;
            padding: 10px 12px !important;
        }
    }
    
    .accordion-btn {
        width: 100%;
        padding: 16px 20px;
        background: rgba(255,255,255,0.5);
        border: none;
        border-top: 1px solid #c0c0c0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        font-weight: 700;
        color: var(--brand-600);
        cursor: pointer;
        transition: background 0.2s;
    }
    .accordion-btn:hover {
        background: rgba(255,255,255,0.8);
    }
    .accordion-content {
        display: none;
        padding: 0 20px 20px;
        background: rgba(255,255,255,0.5);
    }
    .accordion-content.show {
        display: block;
    }
    .member-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 8px;
        margin-top: 10px;
    }
    .member-card {
        background: white;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
    }
    .member-name {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .member-role {
        font-size: 10px;
        color: #64748b;
        font-weight: 600;
    }
</style>

<div class="page-content">
    <div class="content-box" style="background:rgba(255,255,255,0.95);max-width:100%;padding:40px 28px;">
        
        <a href="{{ route('beranda') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>

        <div style="margin-bottom: 30px; text-align: center;">
            <div style="font-size: 48px; color: #12b76a; margin-bottom: 16px;"><i class="fas fa-hands-helping"></i></div>
            <h2 style="font-size: 28px; font-weight: 800; color: var(--ink);">Relawan Siaga</h2>
            <div style="width: 60px; height: 4px; background: #12b76a; border-radius: 2px; margin: 16px auto;"></div>
            @php
                $organisasiRelawans = $organisasi ?? collect();
                $totalRelawan = $organisasiRelawans->sum(function($org) {
                    return $org->relawans->where('is_aktif', true)->count();
                });
            @endphp
            <p style="color: var(--muted); max-width: 600px; margin: 10px auto;">Mereka yang berdedikasi melindungi lansia pasca bencana. Saat ini terdapat <strong>{{ $totalRelawan ?? 0 }} relawan aktif</strong> dari <strong>{{ $organisasiRelawans->count() ?? 0 }} organisasi</strong>.</p>
        </div>

        @if(isset($organisasiRelawans) && $organisasiRelawans->count() > 0)
            <div class="relawan-grid">
                @foreach($organisasiRelawans as $org)
                    <div style="background: #E6E6E6; border-radius: var(--radius-xl); overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #c0c0c0; transition: transform 0.2s, box-shadow 0.2s; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.08)';">
                        
                        <div style="padding: 20px; flex-grow: 1;">
                            <div class="relawan-card-date" style="font-size: 12px; color: var(--text-tertiary); margin-bottom: 8px;">
                                <i class="fas fa-tag"></i> {{ $org->singkatan ?? 'Organisasi' }}
                            </div>
                            
                            <h3 class="relawan-card-title" style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 12px; line-height: 1.4;">{{ $org->nama_organisasi }}</h3>
                            
                            <p class="relawan-card-desc" style="font-size: 14px; color: var(--text-secondary); line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 20px;">
                                {{ $org->deskripsi }}
                            </p>
                            
                            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                                @if($org->kontak_wa)
                                    <a href="{{ $org->wa_link }}" target="_blank" class="relawan-card-link" style="display: inline-block; font-size: 14px; font-weight: 600; color: #25D366; text-decoration: none;">
                                        <i class="fab fa-whatsapp"></i> Hubungi WA <i class="fas fa-arrow-right" style="font-size: 12px; margin-left: 4px;"></i>
                                    </a>
                                @endif
                                @if($org->kontak_telepon)
                                    <a href="tel:{{ $org->kontak_telepon }}" class="relawan-card-link" style="display: inline-block; font-size: 14px; font-weight: 600; color: var(--brand-600); text-decoration: none;">
                                        <i class="fas fa-phone-alt"></i> Telepon <i class="fas fa-arrow-right" style="font-size: 12px; margin-left: 4px;"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div style="margin-top: auto;">
                            <button class="accordion-btn" onclick="toggleMembers('org-{{ $org->id }}')">
                                <span>Lihat Anggota ({{ $org->relawans->where('is_aktif', true)->count() }})</span>
                                <i class="fas fa-chevron-down" id="icon-{{ $org->id }}" style="transition: transform 0.3s;"></i>
                            </button>
                            <div class="accordion-content" id="org-{{ $org->id }}">
                                <div class="member-grid">
                                    @foreach($org->relawans->where('is_aktif', true) as $relawan)
                                        <div class="member-card">
                                            <div class="member-name">{{ $relawan->nama_lengkap }}</div>
                                            @if($relawan->jabatan)
                                                <div class="member-role">{{ $relawan->jabatan }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 40px 20px;">
                <div style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"><i class="fas fa-users-slash"></i></div>
                <h3 style="color: var(--ink);">Belum Ada Relawan</h3>
                <p style="color: var(--muted);">Saat ini belum ada data organisasi relawan yang terdaftar.</p>
            </div>
        @endif
    </div>
</div>

<script>
    function toggleMembers(id) {
        const content = document.getElementById(id);
        const iconId = id.replace('org-', 'icon-');
        const icon = document.getElementById(iconId);
        
        if (content.classList.contains('show')) {
            content.classList.remove('show');
            icon.style.transform = 'rotate(0deg)';
        } else {
            content.classList.add('show');
            icon.style.transform = 'rotate(180deg)';
        }
    }
</script>
@endsection
