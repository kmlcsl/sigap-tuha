@extends('layouts.admin')
@section('header_title', 'Pengaturan Kontak')
@section('content')
    <div class="page-header">
        <h1 class="page-header__title">Pengaturan Kontak</h1>
        <p class="page-header__desc">Kelola informasi kontak, alamat, dan media sosial.</p>
    </div>


    <div style="margin-bottom: 30px;">
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-inbox"></i> Pesan Masuk</h3>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead>
                        <tr style="background: var(--surface-secondary); border-bottom: 2px solid var(--border-primary);">
                            <th
                                style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); white-space: nowrap;">
                                Tanggal</th>
                            <th
                                style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); white-space: nowrap;">
                                Pengirim</th>
                            <th
                                style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); white-space: nowrap;">
                                WhatsApp</th>
                            <th
                                style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); min-width: 200px;">
                                Pesan</th>
                            <th
                                style="padding: 12px 16px; font-weight: 600; color: var(--text-secondary); text-align: left; white-space: nowrap;">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesan_masuks as $pesan)
                            <tr
                                style="border-bottom: 1px solid var(--border-secondary); background: {{ $pesan->is_read ? 'transparent' : 'var(--warning-50)' }};">
                                <td style="padding: 12px 16px; color: var(--text-secondary); white-space: nowrap;">
                                    {{ $pesan->created_at->format('d M Y H:i') }}</td>
                                <td
                                    style="padding: 12px 16px; font-weight: {{ $pesan->is_read ? 'normal' : 'bold' }}; white-space: nowrap;">
                                    {{ $pesan->nama_lengkap }}
                                    @if (!$pesan->is_read)
                                        <span
                                            style="margin-left: 6px; padding: 2px 6px; background: var(--danger-500); color: white; border-radius: 10px; font-size: 10px; font-weight: bold;">BARU</span>
                                    @endif
                                </td>
                                @php
                                    $clean_wa = preg_replace('/[^0-9]/', '', $pesan->no_whatsapp);
                                    if (str_starts_with($clean_wa, '0')) {
                                        $clean_wa = '62' . substr($clean_wa, 1);
                                    }
                                    $wa_text = urlencode(
                                        'Halo Sdr/i ' .
                                            $pesan->nama_lengkap .
                                            ",\n\nTerima kasih telah menghubungi SIGAP TUHA. Menanggapi pesan Anda sebelumnya:\n\n\"" .
                                            Str::limit($pesan->isi_pesan, 100) .
                                            "\"",
                                    );
                                @endphp
                                <td style="padding: 12px 16px; white-space: nowrap;"><a
                                        href="https://wa.me/{{ $clean_wa }}?text={{ $wa_text }}" target="_blank"
                                        style="color: var(--success-500);"><i class="fab fa-whatsapp"></i>
                                        {{ $pesan->no_whatsapp }}</a></td>
                                <td style="padding: 12px 16px; min-width: 200px; max-width: 300px;">
                                    <div style="white-space: pre-wrap; font-size: 13px; color: var(--text-secondary);">{{ Str::limit($pesan->isi_pesan, 60) }}</div>
                                </td>
                                <td style="padding: 12px 16px; text-align: left; white-space: nowrap;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-start;">
                                        <div id="pesan-data-{{ $pesan->id }}" style="display:none;"
                                            data-nama="{{ $pesan->nama_lengkap }}" data-wa="{{ $clean_wa }}">
                                            {{ $pesan->isi_pesan }}</div>
                                        <button type="button" class="btn btn-sm"
                                            onclick="showPesanModal({{ $pesan->id }})"
                                            style="background: var(--brand-50); color: var(--brand-700); padding: 6px 12px; border-radius: 4px; border: none; font-size: 12px; font-weight: 600;"
                                            title="Lihat Pesan">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if (!$pesan->is_read)
                                            <form action="{{ route('admin.kontak.pesan.read', $pesan->id) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm"
                                                    style="background: var(--info-50); color: var(--info-700); padding: 6px 12px; border-radius: 4px; border: none; font-size: 12px; font-weight: 600;"
                                                    title="Tandai Sudah Dibaca">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.kontak.pesan.destroy', $pesan->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm"
                                                style="background: var(--danger-50); color: var(--danger-700); padding: 6px 12px; border-radius: 4px; border: none; font-size: 12px; font-weight: 600;"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    style="padding: 24px; text-align: center; color: var(--text-placeholder);">Belum ada
                                    pesan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card" style="max-width:800px;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-cog"></i> Form Informasi Kontak</h3>
        </div>
        <form action="{{ route('admin.kontak.update') }}" method="POST">
            @csrf
            <div class="grid grid-2" style="gap:20px;">
                <div class="form-group">
                    <label><i class="fas fa-envelope" style="margin-right:4px; color:var(--text-tertiary)"></i> Alamat
                        Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $kontak->email ?? '') }}" placeholder="contoh: info@sigaptuha.com"
                        style="border: 2px solid #bbb; border-radius: 6px; padding: 10px 12px;">
                    @error('email')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label><i class="fas fa-phone" style="margin-right:4px; color:var(--text-tertiary)"></i> Nomor
                        Telepon</label>
                    <input type="text" name="telepon" class="form-control"
                        value="{{ old('telepon', $kontak->telepon ?? '') }}" placeholder="contoh: 08123456789"
                        style="border: 2px solid #bbb; border-radius: 6px; padding: 10px 12px;">
                    @error('telepon')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-map-marker-alt" style="margin-right:4px; color:var(--text-tertiary)"></i> Alamat
                    Lengkap</label>
                <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap organisasi..."
                    style="border: 2px solid #bbb; border-radius: 6px; padding: 10px 12px;">{{ old('alamat', $kontak->alamat ?? '') }}</textarea>
                @error('alamat')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div
                style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <!-- Modal Component -->
    <div id="pesanModal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(16, 24, 40, 0.55); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; transition: opacity 0.3s ease;">
        <div
            style="background: var(--surface-primary); width: 550px; max-width: 95%; border-radius: var(--radius-xl); box-shadow: var(--shadow-2xl); overflow: hidden; display: flex; flex-direction: column;">

            <div
                style="padding: 20px 24px; border-bottom: 1px solid var(--border-secondary); display: flex; justify-content: space-between; align-items: center; background: var(--gray-50);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div
                        style="width: 32px; height: 32px; border-radius: 8px; background: var(--brand-100); color: var(--brand-700); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: var(--text-primary);">Detail Pesan</h3>
                </div>
                <button type="button" onclick="closePesanModal()"
                    style="background: transparent; border: none; font-size: 16px; color: var(--text-tertiary); cursor: pointer; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                    onmouseover="this.style.background='var(--gray-200)'"
                    onmouseout="this.style.background='transparent'">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div style="padding: 24px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                    <div
                        style="background: var(--gray-50); padding: 12px 16px; border-radius: var(--radius-md); border: 1px solid var(--border-secondary);">
                        <p
                            style="margin: 0 0 4px 0; font-size: 11px; font-weight: 700; color: var(--text-placeholder); text-transform: uppercase; letter-spacing: 0.5px;">
                            Pengirim</p>
                        <p id="modalPengirim"
                            style="margin: 0; font-size: 14px; font-weight: 600; color: var(--text-primary);"></p>
                    </div>
                    <div
                        style="background: var(--gray-50); padding: 12px 16px; border-radius: var(--radius-md); border: 1px solid var(--border-secondary);">
                        <p
                            style="margin: 0 0 4px 0; font-size: 11px; font-weight: 700; color: var(--text-placeholder); text-transform: uppercase; letter-spacing: 0.5px;">
                            WhatsApp</p>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i class="fab fa-whatsapp" style="color: var(--success-500); font-size: 16px;"></i>
                            <span id="modalWhatsApp"
                                style="font-size: 14px; font-weight: 600; color: var(--text-primary);"></span>
                        </div>
                    </div>
                </div>

                <p style="margin: 0 0 8px 0; font-size: 13px; font-weight: 700; color: var(--text-primary);">Isi Pesan:</p>
                <div id="modalIsi"
                    style="background: var(--surface-primary); padding: 16px; border-radius: var(--radius-md); border: 1px solid var(--border-primary); white-space: pre-wrap; min-height: 120px; color: var(--text-secondary); font-size: 14px; line-height: 1.6; max-height: 300px; overflow-y: auto;">
                </div>
            </div>

            <div
                style="padding: 16px 24px; border-top: 1px solid var(--border-secondary); display: flex; justify-content: flex-end; gap: 12px; background: var(--gray-50);">
                <a id="modalWaLink" href="#" target="_blank" class="btn btn-sm"
                    style="background: var(--success-500); color: white; padding: 8px 16px; border-radius: var(--radius-md); text-decoration: none; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 6px; box-shadow: var(--shadow-sm);">
                    <i class="fab fa-whatsapp" style="font-size: 14px;"></i> Balas via WhatsApp
                </a>
                <button type="button" onclick="closePesanModal()" class="btn btn-sm"
                    style="background: var(--surface-primary); color: var(--text-primary); padding: 8px 16px; border-radius: var(--radius-md); border: 1px solid var(--border-primary); font-size: 13px; font-weight: 600; cursor: pointer; box-shadow: var(--shadow-xs);">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function showPesanModal(id) {
            var dataEl = document.getElementById('pesan-data-' + id);
            var nama = dataEl.getAttribute('data-nama');
            var wa = dataEl.getAttribute('data-wa');
            var isi = dataEl.textContent.trim();

            document.getElementById('modalPengirim').textContent = nama;
            document.getElementById('modalWhatsApp').textContent = wa;
            document.getElementById('modalIsi').textContent = isi;

            var cleanWa = wa.replace(/[^0-9]/g, '');

            // Buat template pesan balasan
            var shortIsi = isi.length > 100 ? isi.substring(0, 100) + '...' : isi;
            // var defaultText = "Halo Sdr/i " + nama + ",\n\nTerima kasih telah menghubungi SIGAP TUHA. Menanggapi pesan Anda sebelumnya:\n\"" + shortIsi + "\"";
            var defaultText = "Halo Bapak/Ibu " + nama +
                ",\n\nTerima kasih telah menghubungi SIGAP TUHA. Kami telah menerima pesan Anda sebagai berikut:\n\n\"" +
                shortIsi +
                "\"\n\nAdmin SIGAP TUHA akan segera menghubungi Anda melalui WhatsApp ini. Terima kasih atas perhatian dan kepercayaan Anda.\n\nHormat kami,\nTim SIGAP TUHA";
            var encodedText = encodeURIComponent(defaultText);

            document.getElementById('modalWaLink').href = 'https://wa.me/' + cleanWa + '?text=' + encodedText;

            document.getElementById('pesanModal').style.display = 'flex';
        }

        function closePesanModal() {
            document.getElementById('pesanModal').style.display = 'none';
        }
    </script>
@endsection
