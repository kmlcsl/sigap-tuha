@extends('layouts.sigap')

@section('content')
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4 py-3">
                        <h4 class="mb-0 text-center fw-bold">Pre-Test Monitoring & Evaluasi</h4>
                    </div>
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('monev.store_pre_test') }}" method="POST">
                            @csrf
                            <h5 class="mb-3 text-primary border-bottom pb-2">A. Identitas Diri</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" name="nama_user" class="form-control" required
                                        placeholder="Masukkan nama lengkap">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                    <small class="text-muted">Umur akan dihitung otomatis.</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <textarea name="alamat_user" class="form-control" rows="2" required placeholder="Masukkan alamat lengkap"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor HP</label>
                                <input type="text" name="no_hp" class="form-control" required
                                    placeholder="Contoh: 0812xxxx">
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3 text-primary border-bottom pb-2">B. Kuesioner Pre-Test</h5>
                            <div class="alert alert-info py-2">
                                <small>
                                    <strong>Keterangan Skala:</strong><br>
                                    <strong>SP:</strong> Sangat Paham | <strong>CP:</strong> Cukup Paham |
                                    <strong>P:</strong> Paham | <strong>KP:</strong> Kurang Paham | <strong>SKP:</strong>
                                    Sangat Kurang Paham
                                </small>
                            </div>

                            @php
                                $soals = [
                                    1 => 'Pemahaman tentang tujuan kegiatan.',
                                    2 => 'Pemahaman tentang materi dasar yang diberikan.',
                                    3 => 'Pemahaman tentang manfaat kegiatan bagi masyarakat.',
                                    4 => 'Pemahaman tentang peran serta masyarakat.',
                                    5 => 'Pemahaman tentang prosedur pelaksanaan kegiatan.',
                                    6 => 'Pemahaman tentang dampak jangka panjang kegiatan.',
                                    7 => 'Pemahaman tentang cara mengatasi kendala.',
                                    8 => 'Pemahaman tentang pengelolaan sumber daya.',
                                    9 => 'Pemahaman tentang evaluasi hasil kegiatan.',
                                    10 => 'Pemahaman keseluruhan sebelum kegiatan dimulai.',
                                ];
                            @endphp

                            @foreach ($soals as $no => $soal)
                                <div class="mb-4 bg-light p-3 rounded-3">
                                    <label class="form-label mb-2"><strong>{{ $no }}.
                                            {{ $soal }}</strong></label>
                                    <div class="d-flex flex-wrap gap-4 mt-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="jawaban[{{ $no }}]" value="SP" required
                                                id="sp{{ $no }}">
                                            <label class="form-check-label" for="sp{{ $no }}">SP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="jawaban[{{ $no }}]" value="CP" required
                                                id="cp{{ $no }}">
                                            <label class="form-check-label" for="cp{{ $no }}">CP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="jawaban[{{ $no }}]" value="P" required
                                                id="p{{ $no }}">
                                            <label class="form-check-label" for="p{{ $no }}">P</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="jawaban[{{ $no }}]" value="KP" required
                                                id="kp{{ $no }}">
                                            <label class="form-check-label" for="kp{{ $no }}">KP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="jawaban[{{ $no }}]" value="SKP" required
                                                id="skp{{ $no }}">
                                            <label class="form-check-label" for="skp{{ $no }}">SKP</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <hr class="my-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Pemahaman Sebelum Kegiatan <span
                                        class="text-danger">*</span></label>
                                <textarea name="pre_pemahaman_deskripsi" class="form-control" rows="4" required
                                    placeholder="Jelaskan secara singkat pemahaman Anda sebelum mengikuti kegiatan ini..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">Kirim
                                Pre-Test</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
