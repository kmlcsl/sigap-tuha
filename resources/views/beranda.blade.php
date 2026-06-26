@extends('layouts.sigap')

@section('content')
    <!-- LEAFLET CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

    <!-- HERO CONTENT -->
    <div class="hero-grid">
      <div class="hero-text">
        <div class="headline-row">
          <div class="heart-logo" aria-hidden="true">
            <img src="{{ asset('images/logo-bg.png') }}" alt="SIGAP TUHA Logo" />
          </div>
          <div class="title">
            <h1>
              <span class="sigap">SIGAP</span>
              <span class="tuha">TUHA</span>
            </h1>
          </div>
        </div>

        <div class="subtitle">
          Siaga, Tanggap dan Peduli<br/>
          <span class="accent">untuk Lansia Pasca Bencana</span>
        </div>

        <p class="desc">
          Bersama Karang Taruna, kita wujudkan masyarakat yang tangguh, peduli dan
          siap menghadapi bencana.
        </p>

        <div class="cta">
          <a class="btn btn-primary" href="{{ route('profil') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v.01M11 12h1v4h1"/></svg>
            Pelajari Lebih Lanjut
          </a>
          <a class="btn btn-gold" href="{{ route('kontak') }}">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.2 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.4c.6 0 1 .4 1 1 0 1.2.2 2.4.6 3.6.1.4 0 .8-.2 1l-2.2 2.2z"/></svg>
            Hubungi Kami
          </a>
        </div>
      </div>

      <!-- kolom kanan sengaja kosong; foto/relawan ada pada background Anda -->
      <div class="hero-photo" aria-hidden="true"></div>
    </div>

    <!-- FEATURE CARDS -->
    <section class="features" style="margin-top: 25vh;">
      <div class="cards">
        @forelse($features as $feature)
          <a href="{{ route('fitur.detail', \Illuminate\Support\Str::slug($feature->title)) }}">
            <article class="card">
              <div class="ic {{ $feature->color_class }}" aria-hidden="true">
                @if($feature->icon_image)
                  <span class="icon-mask" style="-webkit-mask-image: url('{{ Storage::url($feature->icon_image) }}'); mask-image: url('{{ Storage::url($feature->icon_image) }}');"></span>
                @elseif($feature->icon_svg)
                  {!! $feature->icon_svg !!}
                @else
                  <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                @endif
              </div>
              <h3>{{ $feature->title }}</h3>
              <p>{{ $feature->description }}</p>
            </article>
          </a>
        @empty
          <!-- Fallback static content if database is empty -->
          <a href="{{ route('fitur.detail', 'pendataan-lansia') }}">
            <article class="card">
              <div class="ic blue" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="8" cy="8" r="3"/><circle cx="16" cy="8" r="3"/><path d="M2 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M14 14c3.3 0 6 2.7 6 6" fill="none" stroke="currentColor" stroke-width="2"/></svg>
              </div>
              <h3>Pendataan Lansia</h3>
              <p>Data lansia selalu terupdate dan akurat</p>
            </article>
          </a>

          <a href="{{ route('fitur.detail', 'bantuan-darurat') }}">
            <article class="card">
              <div class="ic gold" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5h6v2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 11v5M9.5 13.5h5" stroke="#fff" stroke-width="2"/></svg>
              </div>
              <h3>Bantuan Darurat</h3>
              <p>Respon cepat saat situasi darurat</p>
            </article>
          </a>

          <a href="{{ route('fitur.detail', 'edukasi-pelatihan') }}">
            <article class="card">
              <div class="ic red" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 5c3-1.5 6-1.5 9 0v14c-3-1.5-6-1.5-9 0V5z"/><path d="M21 5c-3-1.5-6-1.5-9 0v14c3-1.5 6-1.5 9 0V5z"/></svg>
              </div>
              <h3>Edukasi &amp; Pelatihan</h3>
              <p>Tingkatkan pengetahuan dan keterampilan</p>
            </article>
          </a>

          <a href="{{ route('fitur.detail', 'relawan-siaga') }}">
            <article class="card">
              <div class="ic blue" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="7" cy="8" r="2.5"/><circle cx="17" cy="8" r="2.5"/><circle cx="12" cy="7" r="3"/><path d="M2 19c0-2.8 2.2-5 5-5M22 19c0-2.8-2.2-5-5-5M6 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>
              </div>
              <h3>Relawan Siaga</h3>
              <p>Relawan terlatih, masyarakat terlindungi</p>
            </article>
          </a>

          <a href="{{ route('fitur.detail', 'monitoring-evaluasi') }}">
            <article class="card">
              <div class="ic gold" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19V5M4 19h16"/><path d="M7 15l3-4 3 2 4-6"/></svg>
              </div>
              <h3>Monitoring &amp; Evaluasi</h3>
              <p>Pantau kegiatan dan evaluasi berkelanjutan</p>
            </article>
          </a>
        @endforelse
      </div>
    </section>

    <!-- PETA SEBARAN LANSIA -->
    <style>
        .map-wrapper {
            width: 100%;
            height: 500px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(11, 44, 107, 0.15);
            z-index: 1;
            border: 1px solid #e2e8f0;
        }

        /* Penyesuaian khusus mobile */
        @media (max-width: 768px) {
            .features {
                margin-top: 50px !important; /* Jangan pakai vh terlalu besar di mobile karena layar pendek */
                padding: 0 10px;
            }
            .map-section {
                padding: 20px 0 20px !important;
                margin-top: 10px !important;
            }
            .map-wrapper {
                height: 350px; /* Peta lebih pendek di layar kecil */
            }
        }
        
        @media (max-width: 480px) {
            .map-wrapper {
                height: 300px; /* Peta lebih kecil di HP */
            }
        }

        /* Custom Popup Styles */
        .popup-wrapper {
            font-family: 'Segoe UI', sans-serif; 
            min-width: 200px; 
            max-height: 240px; 
            overflow-y: auto; 
            padding-right: 4px;
        }
        .popup-alert {
            background: #e0e7ff; padding: 6px 10px; border-radius: 6px; margin-bottom: 10px; border-left: 3px solid #3b6cf9;
            color: #1e40af; font-size: 13px;
        }
        .popup-alert strong { font-weight: 700; }
        .popup-penyakit {
            margin-top: 6px; padding: 6px 8px; background: #fee2e2; border-radius: 6px; font-size: 11.5px; border-left: 3px solid #ef4444;
        }
        .popup-penyakit strong { color:#b91c1c; }
        .popup-penyakit span { color:#7f1d1d; }
        .popup-divider { border:0; border-top:1px dashed #cbd5e1; margin:12px 0; }
        .popup-person { margin-bottom: 6px; }
        .popup-person h3 { margin: 0 0 4px 0; color: #0b2c6b; font-size: 15px; font-weight: 700; display: flex; align-items: center; gap: 6px; }
        .popup-meta { font-size: 12px; color: #475569; }

        @media (max-width: 768px) {
            .popup-wrapper { min-width: 160px; max-height: 180px; }
            .popup-alert { padding: 4px 6px; font-size: 11px; margin-bottom: 8px; }
            .popup-person h3 { font-size: 13px; gap: 4px; }
            .popup-meta { font-size: 10.5px; }
            .popup-penyakit { font-size: 10px; padding: 4px 6px; margin-top: 4px; }
            .popup-divider { margin: 8px 0; }
            
            /* Leaflet specific overrides for mobile */
            .custom-popup .leaflet-popup-content { margin: 10px 12px; }
        }
    </style>
    <section class="map-section" style="padding: 20px 0 80px; margin-top: 60px;">
        <div class="content-box" style="margin-top: 20px;">
            <h2 style="text-align: center; margin-bottom: 8px;">Peta Sebaran Lansia</h2>
            <p style="text-align: center; color: var(--muted); margin-bottom: 24px;">Pemetaan titik lokasi desa beserta informasi lansia prioritas.</p>
            <div id="map" class="map-wrapper"></div>
        </div>
    </section>

    <!-- LEAFLET JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var isMobile = window.innerWidth <= 768;
            var iconW = isMobile ? 18 : 22;
            var iconH = isMobile ? 28 : 35;
            var shadowW = isMobile ? 28 : 35; 
            
            var customMarkerIcon = L.icon({
                iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                iconSize: [iconW, iconH],
                iconAnchor: [iconW/2, iconH],
                popupAnchor: [1, -Math.floor(iconH * 0.8)],
                shadowSize: [shadowW, shadowW],
                shadowAnchor: [iconW/2, shadowW]
            });

            // Inisialisasi Peta
            // Default center ke Kecamatan Pandrah, Bireuen
            var map = L.map('map').setView([5.074190, 96.365904], 12);

            // Google Maps Tile Layer
            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Maps'
            }).addTo(map);

            // Data Titik Lansia Prioritas
            var lansiasRaw = @json($lansias ?? []);
            
            // Kelompokkan lansia berdasarkan koordinat yang persis sama
            var groupedLansias = {};
            lansiasRaw.forEach(function(lansia) {
                if (lansia.latitude && lansia.longitude) {
                    var key = lansia.latitude.trim() + ',' + lansia.longitude.trim();
                    if (!groupedLansias[key]) {
                        groupedLansias[key] = [];
                    }
                    groupedLansias[key].push(lansia);
                }
            });

            // Loop per koordinat unik
            Object.keys(groupedLansias).forEach(function(key) {
                var group = groupedLansias[key];
                var lat = parseFloat(group[0].latitude);
                var lng = parseFloat(group[0].longitude);
                
                if(!isNaN(lat) && !isNaN(lng)) {
                    // Header Popup (Jika lebih dari 1 orang di 1 rumah/titik)
                    var popupContent = `<div class="popup-wrapper">`;
                    
                    if (group.length > 1) {
                        popupContent += `
                            <div class="popup-alert">
                                <strong>🏠 Terdapat ${group.length} Lansia di Lokasi Ini</strong>
                            </div>
                        `;
                    }

                    // Loop orang-orang di titik ini
                    group.forEach(function(lansia, index) {
                        var namaDesa = lansia.desa ? lansia.desa.desa : 'Tidak Diketahui';
                        var penyakitHtml = '';
                        
                        if(lansia.riwayat_penyakit) {
                            penyakitHtml = `
                                <div class="popup-penyakit">
                                    <strong>💊 Penyakit:</strong> <span>${lansia.riwayat_penyakit}</span>
                                </div>
                            `;
                        }

                        var divider = index > 0 ? `<hr class="popup-divider">` : '';

                        popupContent += `
                            ${divider}
                            <div class="popup-person">
                                <h3>
                                    <i class="fas fa-person-cane" style="color:var(--brand-500);"></i> ${lansia.nama_lansia}
                                </h3>
                                <div class="popup-meta">
                                    <strong>📍 Desa:</strong> ${namaDesa} &nbsp;|&nbsp; <strong>⏳ Usia:</strong> ${lansia.umur} Thn
                                </div>
                                ${penyakitHtml}
                            </div>
                        `;
                    });

                    popupContent += `</div>`;

                    L.marker([lat, lng], {icon: customMarkerIcon}).addTo(map)
                        .bindPopup(popupContent, {
                            maxWidth: 320,
                            className: 'custom-popup'
                        });
                }
            });

            // Hapus blok fitBounds(bounds) karena kita ingin selalu menyorot area kecamatan secara utuh

            // Load Boundary Polygon Kecamatan Pandrah (dari OpenStreetMap)
            fetch('/data/pandrah.geojson')
                .then(response => response.json())
                .then(data => {
                    var boundaryLayer = L.geoJSON(data, {
                        style: {
                            color: '#ef4444',     // Warna garis tepi (merah)
                            weight: 2,            // Ketebalan garis
                            opacity: 0.9,
                            fillColor: '#fee2e2', // Warna isi area
                            fillOpacity: 0.35
                        }
                    }).addTo(map);

                    // Selalu fokuskan peta ke area batas kecamatan (polygon), 
                    // baik sudah ada marker lansia maupun belum, agar nampak area kecamatannya.
                    map.fitBounds(boundaryLayer.getBounds(), { padding: [20, 20] });
                })
                .catch(err => console.error("Error loading boundary:", err));
        });
    </script>
@endsection
