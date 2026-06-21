@extends('layouts.app')

@section('content')
    <section class="hero">
        <span class="badge badge-merah">Modul Laporan Darurat</span>
        <h1>Daftar laporan cepat</h1>
        <p class="muted">Nanti halaman ini dapat diperluas menjadi form laporan, status penanganan, riwayat perubahan, dan notifikasi WhatsApp.</p>
    </section>

    <section class="section">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Nama Lansia</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $item)
                        <tr>
                            <td>{{ $item['waktu'] }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['kondisi'] }}</td>
                            <td>{{ $item['status'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
