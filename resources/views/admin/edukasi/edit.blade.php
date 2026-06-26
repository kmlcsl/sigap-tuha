@extends('layouts.admin')
@section('header_title', 'Edit Materi Edukasi')
@section('content')
    <style>
        .form-control {
            border: 2px solid #94a3b8 !important;
        }

        .form-control:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        }
    </style>

    <div class="page-header">
        <h1 class="page-header__title">Edit Materi Edukasi</h1>
        <p class="page-header__desc">Perbarui materi "{{ $edukasi->judul }}".</p>
    </div>
    <div class="card" style="max-width:900px;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-edit"></i> Edit Materi</h3><span class="badge badge--brand"><i
                    class="fas fa-hashtag" style="font-size:10px"></i> ID: {{ $edukasi->id }}</span>
        </div>
        <form action="{{ route('admin.edukasi.update', $edukasi) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label><i class="fas fa-heading" style="margin-right:4px; color:var(--text-tertiary)"></i> Judul Materi
                    <span class="required">*</span></label>
                <input type="text" name="judul" id="judul" class="form-control"
                    value="{{ old('judul', $edukasi->judul) }}" required>
                @error('judul')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-link" style="margin-right:4px; color:var(--text-tertiary)"></i> Slug</label>
                <input type="text" name="slug" id="slug" class="form-control"
                    value="{{ old('slug', $edukasi->slug) }}" placeholder="contoh: dasar-bantuan-hidup">
                <div class="form-hint"><i class="fas fa-info-circle"></i> Dibuat otomatis dari judul jika kosong.</div>
                @error('slug')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary)"></i> Konten <span
                        class="required">*</span></label>
                <textarea name="konten" class="form-control" style="min-height:160px;" required>{{ old('konten', $edukasi->konten) }}</textarea>
                @error('konten')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-list-ul" style="margin-right:4px; color:var(--text-tertiary)"></i> Materi
                    Pembahasan</label>
                <textarea name="materi_pembahasan" class="form-control" style="min-height:120px;" rows="5"
                    placeholder="1. Pengenalan BHD&#10;2. Teknik kompresi dada&#10;3. Pemberian nafas buatan">{{ old('materi_pembahasan', $edukasi->materi_pembahasan) }}</textarea>
                @error('materi_pembahasan')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>
            <div class="grid grid-3" style="gap:20px;">
                <div class="form-group">
                    <label><i class="fas fa-tag" style="margin-right:4px; color:var(--text-tertiary)"></i> Kategori <span
                            class="required">*</span></label>
                    <select name="kategori" class="form-control" required>
                        @foreach (['BHD', 'Evakuasi', 'Pertolongan Pertama', 'Lainnya'] as $k)
                            <option value="{{ $k }}"
                                {{ old('kategori', $edukasi->kategori) == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-file" style="margin-right:4px; color:var(--text-tertiary)"></i> Jenis <span
                            class="required">*</span></label>
                    <select name="jenis" class="form-control" required>
                        @foreach (['Artikel', 'Video', 'SOP'] as $j)
                            <option value="{{ $j }}" {{ old('jenis', $edukasi->jenis) == $j ? 'selected' : '' }}>
                                {{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-sort-numeric-down" style="margin-right:4px; color:var(--text-tertiary)"></i>
                        Urutan</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $edukasi->order) }}"
                        min="0">
                </div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-video" style="margin-right:4px; color:var(--text-tertiary)"></i> URL Video</label>
                <input type="url" name="url_video" id="url_video" class="form-control"
                    value="{{ old('url_video', $edukasi->url_video) }}">
                <div id="youtube-preview" style="max-width:320px;"></div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-clock" style="margin-right:4px; color:var(--text-tertiary)"></i> Durasi
                    (menit)</label>
                <input type="number" name="durasi_menit" class="form-control"
                    value="{{ old('durasi_menit', $edukasi->durasi_menit) }}" placeholder="30" min="1">
                @error('durasi_menit')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="hidden" name="sertifikat_tersedia" value="0">
                    <input type="checkbox" name="sertifikat_tersedia" value="1"
                        {{ old('sertifikat_tersedia', $edukasi->sertifikat_tersedia) ? 'checked' : '' }}
                        style="width:18px; height:18px; accent-color:var(--brand-600);">
                    <span><i class="fas fa-certificate" style="margin-right:4px; color:var(--text-tertiary)"></i> Peserta
                        dapat mencetak sertifikat setelah menonton</span>
                </label>
            </div>
            <div class="form-group">
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1"
                        {{ old('is_published', $edukasi->is_published) ? 'checked' : '' }}
                        style="width:18px; height:18px; accent-color:var(--brand-600);">
                    <span><i class="fas fa-eye" style="margin-right:4px; color:var(--text-tertiary)"></i>
                        Publikasikan</span>
                </label>
            </div>
            <div
                style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Materi</button>
                <a href="{{ route('admin.edukasi.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i>
                    Batal</a>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        function extractYoutubeId(url) {
            const patterns = [
                /youtu\.be\/([^#&?]*)/,
                /youtube\.com\/watch\?v=([^#&?]*)/,
                /youtube\.com\/embed\/([^#&?]*)/
            ];
            for (const p of patterns) {
                const m = url.match(p);
                if (m) return m[1];
            }
            return null;
        }

        document.getElementById('url_video')?.addEventListener('input', function() {
            const id = extractYoutubeId(this.value);
            const preview = document.getElementById('youtube-preview');
            if (id && preview) {
                preview.innerHTML =
                    `<img src="https://img.youtube.com/vi/${id}/hqdefault.jpg" style="width:100%;border-radius:8px;margin-top:8px;" alt="Thumbnail">`;
            } else if (preview) {
                preview.innerHTML = '';
            }
        });

        document.getElementById('judul')?.addEventListener('input', function() {
            const slugField = document.getElementById('slug');
            if (slugField && !slugField.dataset.manualEdit) {
                slugField.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            }
        });
        document.getElementById('slug')?.addEventListener('input', function() {
            this.dataset.manualEdit = 'true';
        });

        if (document.getElementById('url_video')?.value) {
            document.getElementById('url_video').dispatchEvent(new Event('input'));
        }
    </script>
@endsection
