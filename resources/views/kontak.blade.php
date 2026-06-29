@extends('layouts.sigap')

@section('title', 'Kontak - SIGAP TUHA')

@section('content')
    <div class="page-content">
        <div class="content-box">
            <h2>Hubungi Kami</h2>
            <p>Punya pertanyaan atau ingin menjadi relawan? Silakan hubungi kami melalui form di bawah ini atau melalui saluran kontak kami.</p>
            
            @if(session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-top: 20px; border-radius: 5px; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="display: flex; flex-wrap: wrap; gap: 30px; margin-top: 30px;">
                <!-- Informasi Kontak -->
                <div style="flex: 1; min-width: 300px; background: #e6e6e6; padding: 25px; border-radius: 8px; border: 1px solid #ccc;">
                    <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.2rem;">Informasi Kontak</h3>
                    @if($kontak)
                        <p style="margin-bottom: 15px;"><i class="fas fa-map-marker-alt" style="width: 20px; color: var(--primary-color);"></i> <strong>Alamat:</strong><br>{{ $kontak->alamat ?? '-' }}</p>
                        <p style="margin-bottom: 15px;"><i class="fas fa-envelope" style="width: 20px; color: var(--primary-color);"></i> <strong>Email:</strong><br>{{ $kontak->email ?? '-' }}</p>
                        <p style="margin-bottom: 0;"><i class="fas fa-phone-alt" style="width: 20px; color: var(--primary-color);"></i> <strong>Telepon:</strong><br>{{ $kontak->telepon ?? '-' }}</p>
                    @else
                        <p style="margin-bottom: 15px;"><i class="fas fa-map-marker-alt" style="width: 20px; color: var(--primary-color);"></i> <strong>Alamat:</strong><br>Kantor Camat Pandrah, Kabupaten Bireuen, Aceh</p>
                        <p style="margin-bottom: 15px;"><i class="fas fa-envelope" style="width: 20px; color: var(--primary-color);"></i> <strong>Email:</strong><br>info@sigaptuha.id</p>
                        <p style="margin-bottom: 0;"><i class="fas fa-phone-alt" style="width: 20px; color: var(--primary-color);"></i> <strong>Telepon:</strong><br>0812-XXXX-XXXX</p>
                    @endif
                </div>

                <!-- Form Kontak -->
                <div style="flex: 2; min-width: 300px; max-width: 700px; background: #e6e6e6; padding: 25px; border-radius: 8px; border: 1px solid #ccc;">
                    <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.2rem;">Kirim Pesan</h3>
                    <form action="{{ route('kontak.kirim') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px;">
                            <div style="flex: 1; min-width: 200px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" required style="width: 100%; padding: 10px; border: 2px solid #bbb; border-radius: 4px;" value="{{ old('nama_lengkap') }}">
                                @error('nama_lengkap') <span style="color: red; font-size: 0.9em;">{{ $message }}</span> @enderror
                            </div>
                            <div style="flex: 1; min-width: 200px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 500;">No WhatsApp</label>
                                <input type="text" name="no_whatsapp" required style="width: 100%; padding: 10px; border: 2px solid #bbb; border-radius: 4px;" value="{{ old('no_whatsapp') }}">
                                @error('no_whatsapp') <span style="color: red; font-size: 0.9em;">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Isi Pesan</label>
                            <textarea name="isi_pesan" required rows="5" style="width: 100%; padding: 10px; border: 2px solid #bbb; border-radius: 4px;">{{ old('isi_pesan') }}</textarea>
                            @error('isi_pesan') <span style="color: red; font-size: 0.9em;">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" style="background: var(--primary-color, #0d6efd); color: white; padding: 10px 25px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
