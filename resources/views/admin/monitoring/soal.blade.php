@extends('layouts.admin')
@section('header_title', 'Master Soal Monev')

@section('content')
    <style>
        .ms-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .ms-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ms-title i {
            color: var(--brand-500);
        }

        .ms-desc {
            font-size: 13.5px;
            color: var(--text-secondary);
            margin: 4px 0 0 32px;
        }

        .ms-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .ms-table th {
            background: var(--gray-50);
            padding: 12px 16px;
            text-align: left;
            font-weight: 700;
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-primary);
        }

        .ms-table td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-primary);
            vertical-align: middle;
        }

        .ms-table tr:hover td {
            background: var(--gray-50);
        }

        /* Modal */
        .ms-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .ms-modal.open {
            display: flex;
        }

        .ms-modal-content {
            background: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .15);
            overflow: hidden;
        }

        .ms-modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--gray-50);
        }

        .ms-modal-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .ms-modal-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-tertiary);
        }

        .ms-modal-body {
            padding: 20px;
        }

        .ms-modal-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-primary);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: var(--gray-50);
        }

        .form-control {
            border: 2px solid #94a3b8 !important;
        }

        .form-control:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        }
    </style>

    <div class="ms-header">
        <div>
            <h1 class="ms-title"><i class="fas fa-list-check"></i> Master Soal Monev</h1>
            <p class="ms-desc">Kelola daftar pertanyaan (Pre-Test & Post-Test) untuk kegiatan
                <strong>{{ $kegiatan->nama_kegiatan }}</strong>.</p>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('admin.monitoring.kegiatan.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i>
                Kembali ke Master Kegiatan</a>
            <button onclick="openModal('add')" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Soal</button>
        </div>
    </div>

    @if (session('success'))
        <div class="flash-message success" style="margin-bottom:20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <table class="ms-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Urutan</th>
                    <th>Pertanyaan</th>
                    <th style="width: 140px; text-align: center;">Jenis Test</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($soals as $soal)
                    <tr>
                        <td style="font-weight:700; text-align:center;">{{ $soal->urutan }}</td>
                        <td>{{ $soal->pertanyaan }}</td>
                        <td style="text-align: center;">
                            @if ($soal->jenis_test == 'PRE')
                                <span class="badge" style="background:#dbeafe; color:#1d4ed8;">Pre-Test Saja</span>
                            @elseif($soal->jenis_test == 'POST')
                                <span class="badge" style="background:#dcfce7; color:#15803d;">Post-Test Saja</span>
                            @else
                                <span class="badge" style="background:#f1f5f9; color:#475569;">Keduanya</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if ($soal->is_active)
                                <span class="badge badge--success">Aktif</span>
                            @else
                                <span class="badge badge--danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <button
                                    onclick="openModal('edit', {{ $soal->id_soal }}, '{{ addslashes($soal->pertanyaan) }}', '{{ $soal->jenis_test }}', {{ $soal->urutan }}, {{ $soal->is_active ? 'true' : 'false' }})"
                                    class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.monitoring.soal.destroy', $soal->id_soal) }}" method="POST"
                                    onsubmit="return confirm('Hapus soal ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-tertiary);">
                            <i class="fas fa-file-circle-question" style="font-size: 30px; margin-bottom:10px;"></i><br>
                            Belum ada soal. Silakan tambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL --}}
    <div class="ms-modal" id="soalModal">
        <div class="ms-modal-content">
            <form id="soalForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id_kegiatan" value="{{ $kegiatan->id_kegiatan }}">
                <div class="ms-modal-header">
                    <h3 id="modalTitle">Tambah Soal</h3>
                    <button type="button" class="ms-modal-close" onclick="closeModal()">&times;</button>
                </div>
                <div class="ms-modal-body">
                    <div class="form-group">
                        <label class="form-label">Pertanyaan <span style="color:red">*</span></label>
                        <textarea name="pertanyaan" id="inpPertanyaan" class="form-control" rows="3" required></textarea>
                        <div class="form-group">
                            <label class="form-label">Jenis Test <span style="color:red">*</span></label>
                            <select name="jenis_test" id="inpJenisTest" class="form-control" required>
                                <option value="BOTH">Keduanya (Pre & Post)</option>
                                <option value="PRE">Hanya Pre-Test</option>
                                <option value="POST">Hanya Post-Test</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Urutan <span style="color:red">*</span></label>
                            <input type="number" name="urutan" id="inpUrutan" class="form-control" value="1"
                                min="1" required>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label style="display:flex;align-items:center;gap:8px;font-size:13.5px;cursor:pointer;">
                                <input type="checkbox" name="is_active" id="inpActive" value="1" checked>
                                Tampilkan soal ini (Aktif)
                            </label>
                        </div>
                    </div>
                    <div class="ms-modal-footer">
                        <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(mode, id = null, pertanyaan = '', jenisTest = 'BOTH', urutan = 1, isActive = true) {
            const modal = document.getElementById('soalModal');
            const form = document.getElementById('soalForm');
            const title = document.getElementById('modalTitle');
            const method = document.getElementById('formMethod');

            if (mode === 'add') {
                title.innerText = 'Tambah Soal';
                form.action = "{{ route('admin.monitoring.soal.store') }}";
                method.value = "POST";
                document.getElementById('inpPertanyaan').value = '';
                document.getElementById('inpJenisTest').value = 'BOTH';
                document.getElementById('inpUrutan').value = "{{ $soals->count() + 1 }}";
                document.getElementById('inpActive').checked = true;
            } else {
                title.innerText = 'Edit Soal';
                form.action = "/admin/monitoring/soal/" + id;
                method.value = "PUT";
                document.getElementById('inpPertanyaan').value = pertanyaan;
                document.getElementById('inpJenisTest').value = jenisTest;
                document.getElementById('inpUrutan').value = urutan;
                document.getElementById('inpActive').checked = isActive;
            }

            modal.classList.add('open');
        }

        function closeModal() {
            document.getElementById('soalModal').classList.remove('open');
        }
    </script>
@endsection
