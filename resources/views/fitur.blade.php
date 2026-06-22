@extends('layouts.sigap')

@section('title', 'Fitur: ' . $feature->title . ' - SIGAP TUHA')

@section('content')
    <div class="page-content">
        <div class="content-box">
            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                <div class="ic {{ $feature->color_class ?? 'blue' }}" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; background: var(--{{ $feature->color_class ?? 'blue' }}); flex-shrink: 0;">
                    @if(isset($feature->icon_svg))
                        {!! str_replace('<svg', '<svg style="width: 30px; height: 30px;"', $feature->icon_svg) !!}
                    @else
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width: 30px; height: 30px;"><circle cx="12" cy="12" r="10"/></svg>
                    @endif
                </div>
                <h2 style="margin-bottom: 0;">{{ $feature->title }}</h2>
            </div>
            
            <div class="feature-detail-content" style="margin-top: 30px;">
                <p style="font-size: 18px; font-weight: 600; color: var(--navy);">{{ $feature->description }}</p>
                <br>
                <p>Halaman ini menjelaskan lebih detail mengenai fitur <strong>{{ $feature->title }}</strong>. Program ini merupakan salah satu pilar penting dalam inisiatif SIGAP TUHA (Siaga, Tanggap dan Peduli untuk Lansia Pasca Bencana) yang diusung oleh Karang Taruna Kecamatan Pandrah.</p>
                <br>
                <div style="margin-top: 20px;">
                    <a href="{{ route('beranda') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
