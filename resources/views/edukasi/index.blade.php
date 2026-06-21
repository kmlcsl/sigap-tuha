@extends('layouts.app')

@section('content')
    <section class="hero">
        <span class="badge badge-hijau">Modul Edukasi</span>
        <h1>Materi BHD dan panduan lapangan</h1>
        <p class="muted">Bagian ini bisa dilanjutkan menjadi artikel, video, SOP PDF, dan langkah tindakan awal untuk relawan.</p>
    </section>

    <section class="section">
        <ul class="list">
            @foreach ($materi as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </section>
@endsection
