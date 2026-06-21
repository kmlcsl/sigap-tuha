@extends('layouts.sigap')

@section('title', 'Program - SIGAP TUHA')

@section('content')
    <div class="page-content">
        <div class="content-box" style="background:rgba(255,255,255,0.95);max-width:100%;padding:40px 28px;">
            <div>

                <!-- Header -->
                <div class="program-header">
                    <h2>Program & Kegiatan Kami</h2>
                    <div class="divider"></div>
                    <p>Berbagai program inovatif yang dijalankan oleh SIGAP TUHA beserta dokumentasi kegiatan pelaksanaannya untuk kesejahteraan lansia.</p>
                </div>

                <!-- Program Cards Grid -->
                <div class="program-grid">
                    @foreach($programs as $program)
                    <div class="program-card" id="program-{{ $program->id }}">
                        <div class="card-glow"></div>

                        <h3>{{ $program->nama }}</h3>
                        <p class="card-desc">{{ $program->deskripsi }}</p>

                        <!-- Activities Container (injected via JS) -->
                        <div class="activities-container" id="activities-container-{{ $program->id }}" style="display:none;">
                        </div>

                        <!-- Skeleton Loader -->
                        <div class="skeleton-loader" id="loader-{{ $program->id }}" style="display:none;">
                            <div class="sk-row">
                                <div class="sk-img"></div>
                                <div class="sk-lines">
                                    <div class="sk-line"></div>
                                    <div class="sk-line"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Toggle Button -->
                        <div style="margin-top:auto;position:relative;z-index:1;">
                            <button class="btn-toggle" id="btn-toggle-{{ $program->id }}" onclick="toggleProgram({{ $program->id }})">
                                <span id="btn-text-{{ $program->id }}">Lihat Kegiatan</span>
                                <svg id="btn-icon-{{ $program->id }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Kegiatan -->
    <div class="modal-backdrop" id="activityModal" onclick="closeModal(event)">
        <div class="modal-panel" id="modalContent" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeModal(null, true)">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="modal-img-wrap">
                <img id="modalImg" src="" alt="Foto Kegiatan">
            </div>
            <div class="modal-body-content">
                <h3 id="modalTitle">Judul Kegiatan</h3>
                <div class="modal-divider"></div>
                <div class="modal-text custom-scrollbar">
                    <p id="modalDesc">Deskripsi lengkap kegiatan...</p>
                </div>
            </div>
        </div>
    </div>
@endsection
