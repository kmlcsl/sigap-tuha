@extends('layouts.app')

@section('content')
    <section class="hero">
        <span class="badge badge-kuning">Modul Peta</span>
        <h1>Peta sebaran prioritas lansia</h1>
        <p class="muted">Versi awal ini masih berupa ringkasan titik prioritas. Tahap berikutnya bisa memakai Leaflet dan koordinat dari database.</p>
    </section>

    <section class="section">
        <div class="grid grid-3">
            @foreach ($titik as $item)
                <div class="card">
                    <strong>{{ $item['desa'] }}</strong>
                    <p class="muted">Jumlah prioritas: {{ $item['jumlah'] }} lansia</p>
                    <span class="badge {{ $item['status'] === 'Rujukan segera' ? 'badge-merah' : ($item['status'] === 'Perlu pemantauan' ? 'badge-kuning' : 'badge-hijau') }}">
                        {{ $item['status'] }}
                    </span>
                </div>
            @endforeach
        </div>
    </section>
@endsection
