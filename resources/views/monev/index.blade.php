@extends('layouts.sigap')
@section('title', 'Monitoring & Evaluasi — SIGAP TUHA')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .page-content {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 15% 50%, rgba(29, 78, 216, 0.08), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(124, 58, 237, 0.08), transparent 25%);
            min-height: 100vh;
            padding: 60px 20px;
        }

        .content-box {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 32px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        }

        .kegiatan-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        @media (max-width: 768px) {
            .page-content {
                padding: 20px 10px;
            }

            .content-box {
                padding: 20px 15px;
                border-radius: 20px;
            }

            .kegiatan-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .kegiatan-card {
                min-width: 0;
            }

            .kegiatan-img {
                height: 100px;
            }

            .kegiatan-img.placeholder i {
                font-size: 24px;
            }

            .kegiatan-body {
                padding: 16px 14px;
            }

            .kegiatan-body h3 {
                font-size: 15px;
                margin-bottom: 6px;
                overflow-wrap: anywhere;
            }

            .kegiatan-body p {
                font-size: 12px;
                margin-bottom: 12px;
                line-height: 1.4;
                overflow-wrap: anywhere;
            }

            .kegiatan-actions {
                display: grid;
                grid-template-columns: 1fr;
                gap: 8px;
                width: 100%;
                box-sizing: border-box;
                min-width: 0;
            }

            .btn-pre,
            .btn-post {
                box-sizing: border-box;
                width: 100%;
                min-width: 0;
                max-width: 100%;
                font-size: 11px;
                padding: 10px 8px;
                flex-direction: row;
                justify-content: center;
                gap: 5px;
                white-space: nowrap;
                line-height: 1.2;
                text-align: center;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .btn-pre i,
            .btn-post i {
                font-size: 14px;
                margin: 0;
            }

            /* Modal Responsiveness */
            .modal-body {
                padding: 16px;
            }

            .identitas-grid {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }

            .skala-options {
                gap: 8px;
            }

            .skala-options label {
                padding: 6px;
                font-size: 12px;
                flex: 1;
                justify-content: center;
            }

            .soal-item p {
                font-size: 13px;
            }
        }

        .kegiatan-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.04), inset 0 1px 0 rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.5);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            position: relative;
            min-width: 0;
        }

        .kegiatan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 100%);
            z-index: 0;
            pointer-events: none;
        }

        .kegiatan-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(29, 78, 216, 0.12), 0 0 0 2px rgba(29, 78, 216, 0.1);
        }

        .kegiatan-img {
            width: 100%;
            height: 25px;
            object-fit: cover;
            background: #e2e8f0;
            z-index: 1;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .kegiatan-img.placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: #fff;
            font-size: 54px;
            opacity: 0.9;
        }

        .kegiatan-body {
            padding: 28px;
            flex: 1;
            display: flex;
            flex-direction: column;
            z-index: 1;
            position: relative;
            min-width: 0;
        }

        .kegiatan-body h3 {
            margin: 0 0 12px;
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.4;
            letter-spacing: -0.5px;
        }

        .kegiatan-body p {
            font-size: 14px;
            color: #475569;
            margin: 0 0 24px;
            line-height: 1.7;
            flex: 1;
        }

        .kegiatan-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .btn-pre,
        .btn-post {
            padding: 12px;
            border: none;
            border-radius: 14px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .3s ease;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-pre {
            background: #eff6ff;
            color: #2563eb;
            box-shadow: inset 0 0 0 1.5px #bfdbfe;
        }

        .btn-pre:hover {
            background: #2563eb;
            color: #fff;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
            transform: translateY(-2px);
        }

        .btn-post {
            background: #f0fdf4;
            color: #16a34a;
            box-shadow: inset 0 0 0 1.5px #bbf7d0;
        }

        .btn-post:hover {
            background: #16a34a;
            color: #fff;
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.25);
            transform: translateY(-2px);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
            animation: fadein .3s ease forwards;
        }

        @keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-box {
            background: #ffffff;
            border-radius: 28px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-x: hidden;
            overflow-y: auto;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            animation: slideUp .4s cubic-bezier(.34, 1.56, .64, 1);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: scale(.95) translateY(30px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            padding: 24px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .modal-header h3 {
            font-size: 19px;
            font-weight: 800;
            color: #fff;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .modal-close {
            background: rgba(255, 255, 255, .2);
            border: none;
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            cursor: pointer;
            transition: all .2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, .4);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 32px;
            background: #f8fafc;
        }

        .section-title {
            font-size: 16px;
            font-weight: 800;
            color: #1e3a8a;
            margin: 0 0 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 12px;
        }

        .identitas-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13.5px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            padding: 12px 16px;
            border: 2px solid #94a3b8;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            transition: all .2s;
            background: #fff;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .soal-item {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s;
        }

        .soal-item:hover {
            transform: translateX(4px);
            border-color: #cbd5e1;
        }

        .soal-item p {
            margin: 0 0 16px;
            font-size: 14.5px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.6;
        }

        .skala-options {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .skala-options label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            cursor: pointer;
            color: #475569;
            font-weight: 600;
            padding: 8px 12px;
            background: #f1f5f9;
            border-radius: 8px;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .skala-options label:hover {
            background: #e2e8f0;
        }

        .skala-options input[type="radio"]:checked+label {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }

        .skala-options input[type="radio"] {
            accent-color: #3b82f6;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .btn-submit {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            border: none;
            padding: 16px 32px;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: all .2s ease;
            width: 100%;
            box-shadow: 0 10px 20px rgba(29, 78, 216, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(29, 78, 216, 0.3);
        }

        .alert {
            padding: 18px 20px;
            border-radius: 16px;
            margin-bottom: 30px;
            font-size: 14.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert.success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
        }

        .alert.danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.1);
        }
    </style>

    <div class="page-content">
        <div class="content-box">

            <a href="{{ route('beranda') }}"
                style="display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:#fff; color:#1e3a8a; border-radius:12px; font-weight:700; font-size:14px; text-decoration:none; box-shadow:0 4px 12px rgba(15,23,42,0.05); border:1px solid #e2e8f0; transition:all .2s; margin-bottom:30px;">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>

            <div style="text-align:center;margin-bottom:50px;">
                <h1
                    style="font-size:36px;font-weight:800;background:linear-gradient(135deg, #1e3a8a, #3b82f6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin:0 0 16px;letter-spacing:-1px;">
                    Monitoring & Evaluasi</h1>
                <div
                    style="width:80px;height:6px;background:linear-gradient(90deg,#3b82f6,#8b5cf6);border-radius:3px;margin:0 auto 20px;">
                </div>
                <p
                    style="color:#475569;max-width:600px;margin:0 auto;font-size:16px;line-height:1.7;font-family:'Plus Jakarta Sans', sans-serif;">
                    Pilih kegiatan yang telah Anda ikuti untuk mengisi evaluasi pemahaman sebelum <span
                        style="font-weight:700;color:#2563eb;">(Pre-Test)</span> dan sesudah <span
                        style="font-weight:700;color:#16a34a;">(Post-Test)</span> kegiatan.
                </p>
            </div>

            @if (session('success'))
                <div class="alert success"><i class="fas fa-check-circle" style="font-size:20px;"></i>
                    {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert danger"><i class="fas fa-exclamation-triangle" style="font-size:20px;"></i>
                    {{ session('error') }}</div>
            @endif

            <div class="kegiatan-grid">
                @forelse($kegiatans as $k)
                    <div class="kegiatan-card">
                        @if ($k->foto)
                            <img src="{{ asset('storage/' . $k->foto) }}" class="kegiatan-img" alt="{{ $k->nama_kegiatan }}">
                        @else
                            <div class="kegiatan-img placeholder"><i class="fas fa-calendar-alt"></i></div>
                        @endif
                        <div class="kegiatan-body">
                            <h3>{{ $k->nama_kegiatan }}</h3>
                            <p>{{ Str::limit($k->deskripsi, 80) }}</p>
                            <div class="kegiatan-actions">
                                <button
                                    onclick="openMonevModal('PRE', {{ $k->id_kegiatan }}, '{{ addslashes($k->nama_kegiatan) }}')"
                                    class="btn-pre"><i class="fas fa-file-signature"></i> Pre-Test</button>
                                <button
                                    onclick="openMonevModal('POST', {{ $k->id_kegiatan }}, '{{ addslashes($k->nama_kegiatan) }}')"
                                    class="btn-post"><i class="fas fa-check-double"></i> Post-Test</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
                        <i class="fas fa-folder-open" style="font-size: 40px; margin-bottom: 12px; opacity: 0.5;"></i>
                        <p>Belum ada kegiatan yang tersedia untuk dievaluasi.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal-overlay" id="monevModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Form Evaluasi</h3>
                <button class="modal-close" onclick="closeMonevModal()">×</button>
            </div>
            <div class="modal-body">
                <form id="monevForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="nama_kegiatan" id="inpKegiatan">

                    {{-- SECTION: Identitas --}}
                    <div class="section-title"><i class="fas fa-user-circle"></i> Identitas Diri</div>
                    <div class="identitas-grid">
                        <div class="form-group">
                            <label>Nama Lengkap <span style="color:red">*</span></label>
                            <input type="text" name="nama_user" required placeholder="Sesuai KTP/Identitas">
                        </div>
                        <div class="form-group">
                            <label>No. HP / WhatsApp <span style="color:red">*</span></label>
                            <input type="text" name="no_hp" required placeholder="08xx...">
                        </div>
                    </div>

                    {{-- Field ini hanya wajib di PRE-TEST --}}
                    <div id="extraIdentitas" class="identitas-grid">
                        <div class="form-group">
                            <label>Tanggal Lahir <span style="color:red">*</span></label>
                            <input type="date" name="tanggal_lahir" id="inpTglLahir">
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap <span style="color:red">*</span></label>
                            <input type="text" name="alamat_user" id="inpAlamat" placeholder="Nama desa/jalan">
                        </div>
                    </div>

                    @if (count($masterSoals) == 0)
                        <div class="alert danger" style="margin-top: 20px;">
                            Pertanyaan evaluasi belum diatur oleh Admin. Anda tidak dapat mengisi form ini.
                        </div>
                    @else
                        {{-- SECTION: Soal --}}
                        <div class="section-title" style="margin-top:24px;"><i class="fas fa-list-ol"></i> Pertanyaan
                            Evaluasi</div>
                        <p style="font-size:12px; color:#64748b; margin-bottom:16px;">
                            Keterangan Skala: SP (Sangat Paham), P (Paham), CP (Cukup Paham), KP (Kurang Paham), SKP (Sangat
                            Kurang Paham)
                        </p>

                        @foreach ($masterSoals as $soal)
                            <div class="soal-item" data-jenis="{{ $soal->jenis_test }}"
                                data-kegiatan="{{ $soal->id_kegiatan }}">
                                <p class="soal-text"><strong class="soal-number"></strong> {{ $soal->pertanyaan }}</p>
                                <div class="skala-options">
                                    @foreach (['SP', 'P', 'CP', 'KP', 'SKP'] as $s)
                                        <label><input type="radio" name="jawaban[{{ $soal->id_soal }}]"
                                                value="{{ $s }}" required> {{ $s }}</label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group" style="margin-top: 20px;">
                            <label id="lblDeskripsi">Deskripsi Singkat Pemahaman</label>
                            <textarea name="" id="inpDeskripsi" rows="3"
                                placeholder="Tuliskan secara singkat pemahaman/harapan Anda..."></textarea>
                        </div>

                        <div style="margin-top: 30px;">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Kirim Evaluasi
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.appendChild(document.getElementById('monevModal'));
        });

        function openMonevModal(jenis, idKegiatan, namaKegiatan) {
            const title = document.getElementById('modalTitle');
            const form = document.getElementById('monevForm');
            const inpKegiatan = document.getElementById('inpKegiatan');

            const extraIdentitas = document.getElementById('extraIdentitas');
            const inpTglLahir = document.getElementById('inpTglLahir');
            const inpAlamat = document.getElementById('inpAlamat');

            const lblDeskripsi = document.getElementById('lblDeskripsi');
            const inpDeskripsi = document.getElementById('inpDeskripsi');

            inpKegiatan.value = namaKegiatan;
            form.reset();

            if (jenis === 'PRE') {
                title.innerHTML = `<i class="fas fa-file-signature"></i> Pre-Test: ${namaKegiatan}`;
                form.action = "{{ route('monev.store_pre_test') }}";

                extraIdentitas.style.display = 'grid';
                inpTglLahir.required = true;
                inpAlamat.required = true;

                inpDeskripsi.name = 'pre_pemahaman_deskripsi';
                lblDeskripsi.innerText = 'Deskripsi Pemahaman (Sebelum Kegiatan)';
            } else {
                title.innerHTML = `<i class="fas fa-check-double"></i> Post-Test: ${namaKegiatan}`;
                form.action = "{{ route('monev.store_post_test') }}";

                // Di Post-Test, tgl lahir & alamat tidak perlu karena dicari by Nama & No HP
                extraIdentitas.style.display = 'none';
                inpTglLahir.required = false;
                inpAlamat.required = false;

                inpDeskripsi.name = 'post_pemahaman_deskripsi';
                lblDeskripsi.innerText = 'Deskripsi Pemahaman (Setelah Kegiatan)';
            }

            // Toggle pertanyaan berdasarkan jenis_test (PRE/POST/BOTH) dan kegiatan
            let visCounter = 1;
            document.querySelectorAll('.soal-item').forEach(item => {
                const itemJenis = item.getAttribute('data-jenis');
                const itemKeg = parseInt(item.getAttribute('data-kegiatan'));

                if ((itemJenis === 'BOTH' || itemJenis === jenis) && itemKeg === parseInt(idKegiatan)) {
                    item.style.display = 'block';
                    // Update nomor soal secara dinamis
                    item.querySelector('.soal-number').innerText = visCounter + '.';
                    visCounter++;

                    // Enable and require inputs
                    item.querySelectorAll('input[type="radio"]').forEach(inp => {
                        inp.disabled = false;
                        inp.required = true;
                    });
                } else {
                    item.style.display = 'none';
                    // Disable inputs so they are not submitted
                    item.querySelectorAll('input[type="radio"]').forEach(inp => {
                        inp.disabled = true;
                        inp.required = false;
                        inp.checked = false; // Reset if it was previously checked
                    });
                }
            });

            document.getElementById('monevModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeMonevModal() {
            document.getElementById('monevModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        document.getElementById('monevModal').addEventListener('click', function(e) {
            if (e.target === this) closeMonevModal();
        });
    </script>
@endsection
