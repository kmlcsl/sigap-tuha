@extends('layouts.admin')
@section('header_title', 'Monitoring & Evaluasi')

@section('content')
<style>
.monitor-tab {
    padding: 12px 20px;
    border: none;
    background: none;
    cursor: pointer;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-tertiary);
    border-bottom: 3px solid transparent;
    transition: all 0.2s;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 8px;
}
.monitor-tab.active, .monitor-tab:hover {
    color: var(--brand-600);
    border-bottom-color: var(--brand-500);
}
.tab-content {
    display: none;
    animation: fadeIn 0.3s ease-in-out;
}
.tab-content.active {
    display: block;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

{{-- Page Header --}}
<div class="page-header">
    <h1 class="page-header__title"><i class="fas fa-chart-line"></i> Monitoring & Evaluasi</h1>
    <p class="page-header__desc">Pantau kegiatan, catat kunjungan, rekap kasus, dan evaluasi pelatihan secara terpadu.</p>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="flash-message success" style="margin-bottom:20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="flash-message error" style="margin-bottom:20px;">
        <i class="fas fa-exclamation-circle"></i> Terdapat kesalahan pada input form.
    </div>
@endif

{{-- 5 KARTU STATISTIK --}}
<div class="stats-grid" style="margin-bottom:28px;">
  <div class="stat-card brand">
      <div class="stat-card__top">
          <div class="stat-card__icon"><i class="fas fa-users"></i></div>
      </div>
      <div class="stat-card__label">Relawan Aktif</div>
      <div class="stat-card__value">{{ $relawanAktif }}</div>
  </div>
  <div class="stat-card success">
      <div class="stat-card__top">
          <div class="stat-card__icon"><i class="fas fa-chalkboard-teacher"></i></div>
      </div>
      <div class="stat-card__label">Total Pelatihan</div>
      <div class="stat-card__value">{{ $totalPelatihan }}</div>
  </div>
  <div class="stat-card warning">
      <div class="stat-card__top">
          <div class="stat-card__icon"><i class="fas fa-home"></i></div>
      </div>
      <div class="stat-card__label">Kunjungan Rumah</div>
      <div class="stat-card__value">{{ $kunjunganRumah }}</div>
  </div>
  <div class="stat-card danger">
      <div class="stat-card__top">
          <div class="stat-card__icon"><i class="fas fa-briefcase-medical"></i></div>
      </div>
      <div class="stat-card__label">Kasus Ditangani</div>
      <div class="stat-card__value">{{ $kasusDitangani }} / {{ $totalKasus }}</div>
  </div>
  <div class="stat-card" style="background: linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; padding: 20px; border-radius: var(--radius-lg);">
      <div style="font-size: 13px; opacity: 0.9; margin-bottom: 8px;">Avg Pre/Post Test</div>
      <div style="font-size: 24px; font-weight: 700;">{{ $rataPreTest }} <i class="fas fa-arrow-right" style="font-size: 16px; margin: 0 8px;"></i> {{ $rataPostTest }}</div>
  </div>
</div>

{{-- BARIS GRAFIK --}}
<div class="grid grid-2" style="margin-bottom:28px;">
  <div class="card">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-chart-area"></i> Tren Kegiatan Pelatihan</h3></div>
    <div style="padding: 20px;">
        <canvas id="chartKegiatan" height="120"></canvas>
    </div>
  </div>
  <div class="card">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-chart-pie"></i> Rekap Jenis Kasus</h3></div>
    <div style="padding: 20px;">
        <div style="position:relative; display:flex; align-items:center; justify-content:center;">
          <canvas id="chartKasus" height="180" style="max-width:220px;"></canvas>
        </div>
        <div id="donutLegend" style="display:flex; flex-wrap:wrap; gap:8px; justify-content:center; margin-top:12px; padding:0 16px 16px;"></div>
    </div>
  </div>
</div>

{{-- 4 TAB SUBMENU --}}
<div class="card">
  {{-- Tab Navigation --}}
  <div style="display:flex; border-bottom:2px solid var(--border-primary); padding:0 20px; gap:4px; overflow-x:auto;">
    <button class="monitor-tab active" data-tab="presensi" onclick="switchTab('presensi')">
      <i class="fas fa-clipboard-list"></i> Presensi Pelatihan
    </button>
    <button class="monitor-tab" data-tab="kunjungan" onclick="switchTab('kunjungan')">
      <i class="fas fa-home"></i> Kunjungan Rumah
    </button>
    <button class="monitor-tab" data-tab="kasus" onclick="switchTab('kasus')">
      <i class="fas fa-exclamation-circle"></i> Rekap Kasus
    </button>
    <button class="monitor-tab" data-tab="evaluasi" onclick="switchTab('evaluasi')">
      <i class="fas fa-clipboard-check"></i> Evaluasi Pre/Post Test
    </button>
  </div>
  
  <div style="padding:20px;">
    
    {{-- TAB: PRESENSI --}}
    <div id="tab-presensi" class="tab-content active">
      <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">
        <div class="table-wrap">
          <table class="table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Nama Pelatihan</th>
                      <th>Tanggal</th>
                      <th>Peserta</th>
                      <th>Organisasi</th>
                      <th>Hadir</th>
                      <th>Keterangan</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse($presensiList as $p)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $p->nama_pelatihan }}</td>
                      <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                      <td>{{ $p->nama_peserta }}</td>
                      <td>{{ $p->organisasi ?? '-' }}</td>
                      <td>
                          @if($p->hadir)
                              <span class="badge badge--success"><span class="badge__dot"></span>Ya</span>
                          @else
                              <span class="badge badge--danger"><span class="badge__dot"></span>Tidak</span>
                          @endif
                      </td>
                      <td>{{ $p->keterangan ?? '-' }}</td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="7" class="text-center" style="padding:20px; color:var(--text-secondary);">Belum ada data presensi.</td>
                  </tr>
                  @endforelse
              </tbody>
          </table>
        </div>
        
        <div class="card" style="padding:20px; background:var(--gray-50); box-shadow:none; border:1px solid var(--border-primary);">
          <h4 style="margin-bottom:16px; font-size:16px; color:var(--text-primary);"><i class="fas fa-plus"></i> Tambah Presensi</h4>
          <form method="POST" action="{{ route('admin.monitoring.presensi.store') }}">
            @csrf
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Edukasi (Opsional)</label>
                <select name="edukasi_id" class="form-control">
                    <option value="">-- Pilih Edukasi --</option>
                    @foreach($edukasiList as $edu)
                        <option value="{{ $edu->id }}">{{ $edu->judul }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Nama Pelatihan</label>
                <input name="nama_pelatihan" class="form-control" required placeholder="Contoh: Pelatihan Caregiver">
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Nama Peserta</label>
                <input name="nama_peserta" class="form-control" required>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Organisasi/Lembaga</label>
                <input name="organisasi" class="form-control">
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Kehadiran</label>
                <select name="hadir" class="form-control">
                    <option value="1">Ya, Hadir</option>
                    <option value="0">Tidak Hadir</option>
                </select>
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Keterangan</label>
                <input name="keterangan" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Presensi</button>
          </form>
        </div>
      </div>
    </div>
    
    {{-- TAB: KUNJUNGAN --}}
    <div id="tab-kunjungan" class="tab-content">
      <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">
        <div class="table-wrap">
          <table class="table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Nama Lansia</th>
                      <th>Relawan</th>
                      <th>Tgl Kunjungan</th>
                      <th>Kondisi Fisik</th>
                      <th>Kondisi Psikologis</th>
                      <th>Tindak Lanjut</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse($kunjunganList as $k)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $k->nama_lansia }}</td>
                      <td>{{ $k->nama_relawan }}</td>
                      <td>{{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y') }}</td>
                      <td>
                          @php
                              $badgeFisik = match($k->kondisi_fisik) {
                                  'Baik' => 'success',
                                  'Cukup' => 'warning',
                                  'Buruk' => 'danger',
                                  default => 'neutral'
                              };
                          @endphp
                          <span class="badge badge--{{ $badgeFisik }}"><span class="badge__dot"></span>{{ $k->kondisi_fisik }}</span>
                      </td>
                      <td>
                          @php
                              $badgePsiko = match($k->kondisi_psikologis) {
                                  'Stabil' => 'success',
                                  'Perlu Pendampingan' => 'warning',
                                  'Krisis' => 'danger',
                                  default => 'neutral'
                              };
                          @endphp
                          <span class="badge badge--{{ $badgePsiko }}"><span class="badge__dot"></span>{{ $k->kondisi_psikologis }}</span>
                      </td>
                      <td>{{ \Str::limit($k->tindak_lanjut ?? '-', 30) }}</td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="7" class="text-center" style="padding:20px; color:var(--text-secondary);">Belum ada data kunjungan.</td>
                  </tr>
                  @endforelse
              </tbody>
          </table>
        </div>
        
        <div class="card" style="padding:20px; background:var(--gray-50); box-shadow:none; border:1px solid var(--border-primary);">
          <h4 style="margin-bottom:16px; font-size:16px; color:var(--text-primary);"><i class="fas fa-plus"></i> Tambah Kunjungan</h4>
          <form method="POST" action="{{ route('admin.monitoring.kunjungan.store') }}">
            @csrf
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Nama Lansia</label>
                <input name="nama_lansia" class="form-control" required>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Pilih Profil Lansia (Opsional)</label>
                <select name="lansia_id" class="form-control">
                    <option value="">-- Pilih Jika Terdaftar --</option>
                    @foreach($lansiaList as $l)
                        <option value="{{ $l->id }}">{{ $l->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Nama Relawan</label>
                <input name="nama_relawan" class="form-control" required>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Tanggal Kunjungan</label>
                <input type="date" name="tanggal_kunjungan" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Kondisi Fisik</label>
                <select name="kondisi_fisik" class="form-control" required>
                    <option value="Baik">Baik</option>
                    <option value="Cukup">Cukup</option>
                    <option value="Buruk">Buruk</option>
                </select>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Kondisi Psikologis</label>
                <select name="kondisi_psikologis" class="form-control" required>
                    <option value="Stabil">Stabil</option>
                    <option value="Perlu Pendampingan">Perlu Pendampingan</option>
                    <option value="Krisis">Krisis</option>
                </select>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Catatan Kunjungan</label>
                <textarea name="catatan" class="form-control" rows="3"></textarea>
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Tindak Lanjut</label>
                <textarea name="tindak_lanjut" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Kunjungan</button>
          </form>
        </div>
      </div>
    </div>
    
    {{-- TAB: KASUS --}}
    <div id="tab-kasus" class="tab-content">
      <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">
        <div class="table-wrap">
          <table class="table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Jenis Kasus</th>
                      <th>Nama Lansia</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>Penanganan</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse($kasusList as $kasus)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>
                          @php
                              $badgeJenis = match($kasus->jenis_kasus) {
                                  'Kesehatan' => 'brand',
                                  'Bantuan Sosial' => 'success',
                                  'Psikologis' => 'warning',
                                  'Evakuasi' => 'danger',
                                  default => 'neutral'
                              };
                          @endphp
                          <span class="badge badge--{{ $badgeJenis }}"><span class="badge__dot"></span>{{ $kasus->jenis_kasus }}</span>
                      </td>
                      <td>{{ $kasus->nama_lansia ?? '-' }}</td>
                      <td>{{ \Carbon\Carbon::parse($kasus->tanggal_kejadian)->format('d M Y') }}</td>
                      <td>
                          @php
                              $badgeStatus = match($kasus->status_penanganan) {
                                  'Ditangani' => 'success',
                                  'Dalam Proses' => 'warning',
                                  'Belum Ditangani' => 'danger',
                                  default => 'neutral'
                              };
                          @endphp
                          <span class="badge badge--{{ $badgeStatus }}"><span class="badge__dot"></span>{{ $kasus->status_penanganan }}</span>
                      </td>
                      <td>{{ \Str::limit($kasus->penanganan ?? '-', 30) }}</td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="6" class="text-center" style="padding:20px; color:var(--text-secondary);">Belum ada data kasus.</td>
                  </tr>
                  @endforelse
              </tbody>
          </table>
        </div>
        
        <div class="card" style="padding:20px; background:var(--gray-50); box-shadow:none; border:1px solid var(--border-primary);">
          <h4 style="margin-bottom:16px; font-size:16px; color:var(--text-primary);"><i class="fas fa-plus"></i> Tambah Rekap Kasus</h4>
          <form method="POST" action="{{ route('admin.monitoring.kasus.store') }}">
            @csrf
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Jenis Kasus</label>
                <select name="jenis_kasus" class="form-control" required>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Bantuan Sosial">Bantuan Sosial</option>
                    <option value="Psikologis">Psikologis</option>
                    <option value="Evakuasi">Evakuasi</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Nama Lansia (Opsional)</label>
                <input name="nama_lansia" class="form-control">
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Tanggal Kejadian</label>
                <input type="date" name="tanggal_kejadian" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Deskripsi Kasus</label>
                <textarea name="deskripsi_kasus" class="form-control" rows="3" required></textarea>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Status Penanganan</label>
                <select name="status_penanganan" class="form-control" required>
                    <option value="Belum Ditangani">Belum Ditangani</option>
                    <option value="Dalam Proses">Dalam Proses</option>
                    <option value="Ditangani">Ditangani</option>
                </select>
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Detail Penanganan</label>
                <textarea name="penanganan" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Kasus</button>
          </form>
        </div>
      </div>
    </div>
    
    {{-- TAB: EVALUASI --}}
    <div id="tab-evaluasi" class="tab-content">
      <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">
        <div class="table-wrap">
          <table class="table">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Nama Pelatihan</th>
                      <th>Peserta</th>
                      <th>Tanggal</th>
                      <th>Pre</th>
                      <th>Post</th>
                      <th>Selisih</th>
                      <th>Progress Post-test</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse($evaluasiList as $ev)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $ev->nama_pelatihan }}</td>
                      <td>{{ $ev->nama_peserta }}</td>
                      <td>{{ \Carbon\Carbon::parse($ev->tanggal)->format('d M Y') }}</td>
                      <td style="font-weight:600;">{{ $ev->nilai_pre_test }}</td>
                      <td style="font-weight:600; color:var(--brand-600);">{{ $ev->nilai_post_test ?? '-' }}</td>
                      <td>
                          @php
                              $selisih = $ev->peningkatan;
                              $color = $selisih > 0 ? 'var(--success-500)' : ($selisih < 0 ? 'var(--danger-500)' : 'var(--text-secondary)');
                              $sign = $selisih > 0 ? '+' : '';
                          @endphp
                          @if($ev->nilai_post_test !== null)
                            <span style="color:{{ $color }}; font-weight:bold;">{{ $sign }}{{ $selisih }}</span>
                          @else
                            -
                          @endif
                      </td>
                      <td style="width:150px;">
                          @php
                              $progress = $ev->nilai_post_test !== null ? $ev->nilai_post_test : $ev->nilai_pre_test;
                              $barColor = $progress >= 80 ? 'var(--success-500)' : ($progress >= 60 ? 'var(--warning-500)' : 'var(--danger-500)');
                          @endphp
                          <div style="width:100%; height:8px; background:var(--gray-50); border-radius:4px; overflow:hidden;">
                              <div style="width:{{ $progress }}%; height:100%; background:{{ $barColor }};"></div>
                          </div>
                      </td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="8" class="text-center" style="padding:20px; color:var(--text-secondary);">Belum ada data evaluasi.</td>
                  </tr>
                  @endforelse
              </tbody>
          </table>
        </div>
        
        <div class="card" style="padding:20px; background:var(--gray-50); box-shadow:none; border:1px solid var(--border-primary);">
          <h4 style="margin-bottom:16px; font-size:16px; color:var(--text-primary);"><i class="fas fa-plus"></i> Tambah Evaluasi</h4>
          <form method="POST" action="{{ route('admin.monitoring.evaluasi.store') }}">
            @csrf
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Edukasi (Opsional)</label>
                <select name="edukasi_id" class="form-control">
                    <option value="">-- Pilih Edukasi --</option>
                    @foreach($edukasiList as $edu)
                        <option value="{{ $edu->id }}">{{ $edu->judul }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Nama Pelatihan</label>
                <input name="nama_pelatihan" class="form-control" required>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Nama Peserta</label>
                <input name="nama_peserta" class="form-control" required>
            </div>
            <div style="margin-bottom:12px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Nilai Pre-Test</label>
                    <input type="number" name="nilai_pre_test" class="form-control" required min="0" max="100">
                </div>
                <div>
                    <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Nilai Post-Test</label>
                    <input type="number" name="nilai_post_test" class="form-control" min="0" max="100" placeholder="Opsional">
                </div>
            </div>
            <div style="margin-bottom:16px;">
                <label style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Keterangan</label>
                <input name="keterangan" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Evaluasi</button>
          </form>
        </div>
      </div>
    </div>
    
  </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Tab switching
function switchTab(tabId) {
    document.querySelectorAll('.monitor-tab').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    
    document.querySelector(`.monitor-tab[data-tab="${tabId}"]`).classList.add('active');
    document.getElementById(`tab-${tabId}`).classList.add('active');
}

// Inisialisasi Tab: Sembunyikan selain yang pertama
document.addEventListener('DOMContentLoaded', () => {
    switchTab('presensi');
});

// Grafik Garis
new Chart(document.getElementById('chartKegiatan'), {
    type: 'line',
    data: {
        labels: @json($grafikBulan->pluck('label')),
        datasets: [{
            label: 'Kehadiran',
            data: @json($grafikBulan->pluck('total')),
            borderColor: '#3b6cf9',
            backgroundColor: 'rgba(59,108,249,0.08)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#3b6cf9'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// Grafik Donat
const kasusLabels = @json($rekapKasusDonut->pluck('jenis_kasus'));
const kasusData = @json($rekapKasusDonut->pluck('jumlah'));
const kasusColors = ['#3b82f6','#22c55e','#8b5cf6','#f97316','#6b7280'];

if (kasusLabels.length > 0) {
    new Chart(document.getElementById('chartKasus'), {
        type: 'doughnut',
        data: {
            labels: kasusLabels,
            datasets: [{ data: kasusData, backgroundColor: kasusColors, borderWidth: 2 }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: { legend: { display: false } }
        }
    });

    // Render legend donat manual
    const legendContainer = document.getElementById('donutLegend');
    kasusLabels.forEach((label, i) => {
        const color = kasusColors[i % kasusColors.length];
        const val = kasusData[i];
        const item = document.createElement('div');
        item.style.display = 'flex';
        item.style.alignItems = 'center';
        item.style.fontSize = '12px';
        item.style.gap = '6px';
        item.innerHTML = `<span style="width:10px;height:10px;border-radius:50%;background:${color};display:inline-block;"></span> <span>${label} (${val})</span>`;
        legendContainer.appendChild(item);
    });
} else {
    // Tampilkan placeholder jika kosong
    document.getElementById('chartKasus').parentElement.innerHTML = '<div style="padding:40px 0; color:#9ca3af; font-size:13px; text-align:center;">Belum ada data kasus</div>';
}
</script>
@endsection
