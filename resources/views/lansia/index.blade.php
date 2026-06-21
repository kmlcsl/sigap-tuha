@extends('layouts.app')

@section('content')
    <section class="hero">
        <span class="badge badge-biru">Modul Pendataan</span>
        <h1>Data lansia</h1>
        <p class="muted">Halaman ini menjadi dasar untuk daftar, pencarian, filter, tambah, edit, dan monitoring kondisi lansia.</p>
    </section>

    <section class="section">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Desa</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftarLansia as $item)
                        <tr>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['umur'] }} tahun</td>
                            <td>{{ $item['desa'] }}</td>
                            <td>{{ $item['status'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
