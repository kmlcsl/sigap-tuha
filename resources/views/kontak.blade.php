@extends('layouts.sigap')

@section('title', 'Kontak - SIGAP TUHA')

@section('content')
    <div class="page-content">
        <div class="content-box">
            <h2>Hubungi Kami</h2>
            <p>Punya pertanyaan atau ingin menjadi relawan? Silakan hubungi kami melalui saluran berikut:</p>
            @if($kontak)
                <div style="margin-top: 20px;">
                    <p><strong>Alamat:</strong> {{ $kontak->alamat ?? '-' }}</p>
                    <p><strong>Email:</strong> {{ $kontak->email ?? '-' }}</p>
                    <p><strong>Telepon:</strong> {{ $kontak->telepon ?? '-' }}</p>
                </div>
                
                @if($kontak->facebook || $kontak->instagram)
                    <div style="margin-top: 20px;">
                        <p><strong>Sosial Media:</strong></p>
                        @if($kontak->facebook)
                            <a href="{{ $kontak->facebook }}" target="_blank" style="display:inline-block; margin-right:10px; color:#1877F2;"><i class="fab fa-facebook fa-2x"></i></a>
                        @endif
                        @if($kontak->instagram)
                            <a href="{{ $kontak->instagram }}" target="_blank" style="display:inline-block; color:#E4405F;"><i class="fab fa-instagram fa-2x"></i></a>
                        @endif
                    </div>
                @endif

                @if($kontak->map_embed_url)
                    <div style="margin-top: 30px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color);">
                        <iframe src="{{ $kontak->map_embed_url }}" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                @endif
            @else
                <div style="margin-top: 20px;">
                    <p><strong>Alamat:</strong> Kantor Camat Pandrah, Kabupaten Bireuen, Aceh</p>
                    <p><strong>Email:</strong> info@sigaptuha.id</p>
                    <p><strong>Telepon:</strong> 0812-XXXX-XXXX</p>
                </div>
            @endif
        </div>
    </div>
@endsection
