@extends('layouts.sigap')

@section('title', ($profil->judul ?? 'Profil') . ' - SIGAP TUHA')

@section('content')
    <div class="page-content">
        <div class="content-box">
            @if($profil)
                <h2>{{ $profil->judul }}</h2>
                @if($profil->gambar)
                    <div style="margin: 20px 0; text-align: center;">
                        <img src="{{ asset('storage/' . $profil->gambar) }}" alt="{{ $profil->judul }}" style="max-width: 100%; border-radius: 8px;">
                    </div>
                @endif
                <div style="line-height: 1.8;">
                    {!! nl2br(e($profil->konten)) !!}
                </div>
            @else
                <h2>Profil SIGAP TUHA</h2>
                <p>Belum ada data profil.</p>
            @endif
        </div>
    </div>
@endsection
