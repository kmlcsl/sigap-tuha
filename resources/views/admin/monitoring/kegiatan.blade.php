@extends('layouts.admin')
@section('header_title', 'Master Kegiatan Monev')

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
            <h1 class="ms-title"><i class="fas fa-calendar-check"></i> Master Kegiatan Monev</h1>
            <p class="ms-desc">Kelola daftar kegiatan yang membutuhkan form evaluasi Monev.</p>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('admin.monitoring.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i>
                Kembali</a>
            <button onclick="openModal('add')" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Kegiatan</button>
        </div>
    </div>



    <div class="card">
        <table class="ms-table">
            <thead>
                <tr>
                    <th>Nama Kegiatan</th>
                    <th>Deskripsi Singkat</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 180px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kegiatans as $k)
                    <tr>
                        <td style="font-weight:700;">{{ $k->nama_kegiatan }}</td>
                        <td>{{ Str::limit($k->deskripsi, 80) }}</td>
                        <td style="text-align: center;">
                            @if ($k->is_active)
                                <span class="badge badge--success">Aktif</span>
                            @else
                                <span class="badge badge--danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('admin.monitoring.kegiatan.soal', $k->id_kegiatan) }}"
                                    class="btn btn-success btn-sm" title="Kelola Soal">
                                    <i class="fas fa-list-check"></i> Kelola Soal
                                </a>
                                <button
                                    onclick="openModal('edit', {{ $k->id_kegiatan }}, '{{ addslashes($k->nama_kegiatan) }}', '{{ addslashes($k->deskripsi) }}', {{ $k->is_active ? 'true' : 'false' }})"
                                    class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.monitoring.kegiatan.destroy', $k->id_kegiatan) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus kegiatan ini beserta seluruh Master Soal di dalamnya?');">
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
                            <i class="fas fa-folder-open" style="font-size: 30px; margin-bottom:10px;"></i><br>
                            Belum ada data kegiatan untuk Monev.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL --}}
    <div class="ms-modal" id="kegiatanModal">
        <div class="ms-modal-content">
            <form id="kegiatanForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="ms-modal-header">
                    <h3 id="modalTitle">Tambah Kegiatan Monev</h3>
                    <button type="button" class="ms-modal-close" onclick="closeModal()">&times;</button>
                </div>
                <div class="ms-modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Kegiatan <span style="color:red">*</span></label>
                        <input type="text" name="nama_kegiatan" id="inpNama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="inpDeskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="display:flex;align-items:center;gap:8px;font-size:13.5px;cursor:pointer;">
                            <input type="checkbox" name="is_active" id="inpActive" value="1" checked>
                            Tampilkan kegiatan ini di halaman publik (Aktif)
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
        function openModal(mode, id = null, nama = '', deskripsi = '', isActive = true) {
            const modal = document.getElementById('kegiatanModal');
            const form = document.getElementById('kegiatanForm');
            const title = document.getElementById('modalTitle');
            const method = document.getElementById('formMethod');

            if (mode === 'add') {
                title.innerText = 'Tambah Kegiatan Monev';
                form.action = "{{ route('admin.monitoring.kegiatan.store') }}";
                method.value = "POST";
                document.getElementById('inpNama').value = '';
                document.getElementById('inpDeskripsi').value = '';
                document.getElementById('inpActive').checked = true;
            } else {
                title.innerText = 'Edit Kegiatan Monev';
                form.action = "/admin/monitoring/kegiatan/" + id;
                method.value = "PUT";
                document.getElementById('inpNama').value = nama;
                document.getElementById('inpDeskripsi').value = deskripsi;
                document.getElementById('inpActive').checked = isActive;
            }

            modal.classList.add('open');
        }

        function closeModal() {
            document.getElementById('kegiatanModal').classList.remove('open');
        }
    </script>
@endsection
