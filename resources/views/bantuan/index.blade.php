@extends('layouts.sigap')

@section('title', 'Bantuan Darurat - SIGAP TUHA')

@section('content')
<style>
    .bantuan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }
    @media (max-width: 600px) {
        .bantuan-grid {
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .bantuan-card-title {
            font-size: 14px !important;
        }
        .bantuan-card-desc {
            font-size: 12px !important;
            margin-bottom: 12px !important;
        }
        .bantuan-card-date {
            font-size: 10px !important;
        }
        .bantuan-card-link {
            font-size: 12px !important;
        }
    }
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
</style>
<div class="page-content">
    <div class="content-box" style="background:rgba(255,255,255,0.95);max-width:100%;padding:40px 28px;">
        
        <a href="{{ route('beranda') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>

        <div style="margin-bottom: 30px; text-align: center;">
            <div style="font-size: 48px; color: var(--red); margin-bottom: 16px;"><i class="fas fa-ambulance"></i></div>
            <h2 style="font-size: 28px; font-weight: 800; color: var(--ink);">Bantuan Darurat</h2>
            <div style="width: 60px; height: 4px; background: var(--red); border-radius: 2px; margin: 16px auto;"></div>
            <p style="color: var(--muted); max-width: 600px; margin: 10px auto;">Hubungi langsung via WhatsApp — Satu klik, bantuan segera datang.</p>
            <div style="background: rgba(209,32,39,0.1); border: 1px solid rgba(209,32,39,0.2); border-radius: 8px; padding: 10px 15px; display: inline-block; color: var(--red); font-size: 14px; font-weight: 600; margin-top: 10px;">⚠️ Gunakan hanya pada situasi darurat yang memerlukan bantuan segera</div>
        </div>

        <div class="bantuan-grid">
            @if(isset($bantuan) && $bantuan->count() > 0)
                @foreach($bantuan as $item)
                <div style="background: #E6E6E6; border-radius: var(--radius-xl); overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #c0c0c0; transition: transform 0.2s, box-shadow 0.2s; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.08)';">
                    <div style="padding: 20px; flex-grow: 1;">
                        <div class="bantuan-card-date" style="font-size: 12px; color: var(--text-tertiary); margin-bottom: 8px;">
                            <i class="fas fa-tag"></i> {{ $item->jenis }}
                        </div>
                        <h3 class="bantuan-card-title" style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 12px; line-height: 1.4;">{{ $item->nama_instansi }}</h3>
                        <p class="bantuan-card-desc" style="font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 20px;">
                            {{ $item->deskripsi ?? 'Siap memberikan bantuan darurat untuk warga.' }}
                        </p>
                        <a href="{{ $item->wa_link }}" target="_blank" class="bantuan-card-link" style="display: inline-block; font-size: 14px; font-weight: 600; color: #25D366; text-decoration: none;">
                            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp <i class="fas fa-arrow-right" style="font-size: 12px; margin-left: 4px;"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Fallback Statis Jika Kosong -->
                @php
                    $fallbacks = [
                        ['nama' => 'Polres / Polsek', 'nomor' => '110', 'jenis' => 'Kepolisian'],
                        ['nama' => 'Pemadam Kebakaran', 'nomor' => '113', 'jenis' => 'Damkar'],
                        ['nama' => 'Ambulans', 'nomor' => '118', 'jenis' => 'Kesehatan'],
                        ['nama' => 'Basarnas', 'nomor' => '115', 'jenis' => 'Basarnas'],
                    ];
                @endphp
                @foreach($fallbacks as $item)
                <div style="background: #E6E6E6; border-radius: var(--radius-xl); overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #c0c0c0; transition: transform 0.2s, box-shadow 0.2s; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.08)';">
                    <div style="padding: 20px; flex-grow: 1;">
                        <div class="bantuan-card-date" style="font-size: 12px; color: var(--text-tertiary); margin-bottom: 8px;">
                            <i class="fas fa-tag"></i> {{ $item['jenis'] }}
                        </div>
                        <h3 class="bantuan-card-title" style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 12px; line-height: 1.4;">{{ $item['nama'] }}</h3>
                        <p class="bantuan-card-desc" style="font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 20px;">
                            Layanan darurat resmi. Klik tombol di bawah untuk menghubungi via WhatsApp (jika tersedia) atau telepon biasa.
                        </p>
                        <a href="https://wa.me/{{ $item['nomor'] }}" target="_blank" class="bantuan-card-link" style="display: inline-block; font-size: 14px; font-weight: 600; color: #25D366; text-decoration: none;">
                            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp <i class="fas fa-arrow-right" style="font-size: 12px; margin-left: 4px;"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

    </div>
</div>
@endsection
