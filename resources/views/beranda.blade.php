@extends('layouts.sigap')

@section('content')
    <!-- HERO CONTENT -->
    <div class="hero-grid">
      <div class="hero-text">
        <div class="headline-row">
          <div class="heart-logo" aria-hidden="true">
            <img src="{{ asset('images/logo-bg.png') }}" alt="SIGAP TUHA Logo" />
          </div>
          <div class="title">
            <h1>
              <span class="sigap">SIGAP</span>
              <span class="tuha">TUHA</span>
            </h1>
          </div>
        </div>

        <div class="subtitle">
          Siaga, Tanggap dan Peduli<br/>
          <span class="accent">untuk Lansia Pasca Bencana</span>
        </div>

        <p class="desc">
          Bersama Karang Taruna, kita wujudkan masyarakat yang tangguh, peduli dan
          siap menghadapi bencana.
        </p>

        <div class="cta">
          <a class="btn btn-primary" href="{{ route('profil') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v.01M11 12h1v4h1"/></svg>
            Pelajari Lebih Lanjut
          </a>
          <a class="btn btn-gold" href="{{ route('kontak') }}">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.2 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.4c.6 0 1 .4 1 1 0 1.2.2 2.4.6 3.6.1.4 0 .8-.2 1l-2.2 2.2z"/></svg>
            Hubungi Kami
          </a>
        </div>
      </div>

      <!-- kolom kanan sengaja kosong; foto/relawan ada pada background Anda -->
      <div class="hero-photo" aria-hidden="true"></div>
    </div>

    <!-- FEATURE CARDS (di dalam hero -> satu layar) -->
    <section class="features">
      <div class="cards">
        @forelse($features as $feature)
          <a href="{{ route('fitur.detail', \Illuminate\Support\Str::slug($feature->title)) }}">
            <article class="card">
              <div class="ic {{ $feature->color_class }}" aria-hidden="true">
                @if($feature->icon_image)
                  <span class="icon-mask" style="-webkit-mask-image: url('{{ Storage::url($feature->icon_image) }}'); mask-image: url('{{ Storage::url($feature->icon_image) }}');"></span>
                @elseif($feature->icon_svg)
                  {!! $feature->icon_svg !!}
                @else
                  <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                @endif
              </div>
              <h3>{{ $feature->title }}</h3>
              <p>{{ $feature->description }}</p>
            </article>
          </a>
        @empty
          <!-- Fallback static content if database is empty -->
          <a href="{{ route('fitur.detail', 'pendataan-lansia') }}">
            <article class="card">
              <div class="ic blue" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="8" cy="8" r="3"/><circle cx="16" cy="8" r="3"/><path d="M2 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M14 14c3.3 0 6 2.7 6 6" fill="none" stroke="currentColor" stroke-width="2"/></svg>
              </div>
              <h3>Pendataan Lansia</h3>
              <p>Data lansia selalu terupdate dan akurat</p>
            </article>
          </a>

          <a href="{{ route('fitur.detail', 'bantuan-darurat') }}">
            <article class="card">
              <div class="ic gold" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5h6v2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 11v5M9.5 13.5h5" stroke="#fff" stroke-width="2"/></svg>
              </div>
              <h3>Bantuan Darurat</h3>
              <p>Respon cepat saat situasi darurat</p>
            </article>
          </a>

          <a href="{{ route('fitur.detail', 'edukasi-pelatihan') }}">
            <article class="card">
              <div class="ic red" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 5c3-1.5 6-1.5 9 0v14c-3-1.5-6-1.5-9 0V5z"/><path d="M21 5c-3-1.5-6-1.5-9 0v14c3-1.5 6-1.5 9 0V5z"/></svg>
              </div>
              <h3>Edukasi &amp; Pelatihan</h3>
              <p>Tingkatkan pengetahuan dan keterampilan</p>
            </article>
          </a>

          <a href="{{ route('fitur.detail', 'relawan-siaga') }}">
            <article class="card">
              <div class="ic blue" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="7" cy="8" r="2.5"/><circle cx="17" cy="8" r="2.5"/><circle cx="12" cy="7" r="3"/><path d="M2 19c0-2.8 2.2-5 5-5M22 19c0-2.8-2.2-5-5-5M6 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>
              </div>
              <h3>Relawan Siaga</h3>
              <p>Relawan terlatih, masyarakat terlindungi</p>
            </article>
          </a>

          <a href="{{ route('fitur.detail', 'monitoring-evaluasi') }}">
            <article class="card">
              <div class="ic gold" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19V5M4 19h16"/><path d="M7 15l3-4 3 2 4-6"/></svg>
              </div>
              <h3>Monitoring &amp; Evaluasi</h3>
              <p>Pantau kegiatan dan evaluasi berkelanjutan</p>
            </article>
          </a>
        @endforelse
      </div>
    </section>
@endsection
