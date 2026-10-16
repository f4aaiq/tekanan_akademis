@extends('layouts.app')
@section('title', 'Tekanan Akademis - Cek seberapa berat bebanmu')

@section('content')
@php $quiz = Route::has('quiz.index') ? route('quiz.index') : '#'; @endphp

{{-- HERO --}}
<header class="hero" id="beranda">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 hero-copy">
                <h1 class="display-3 fw-bold mb-3">Nilai bagus, tapi kepala terasa penuh?</h1>
                <p class="lead mb-4">
                    Jawab quiz 3 menit untuk melihat seberapa berat tekanan akademis yang kamu bawa.
                    Tanpa daftar akun, hasilnya cuma kamu yang lihat.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ $quiz }}" class="btn btn-primary btn-lg px-4">Mulai quiz</a>
                    <a href="#penyebab" class="btn btn-outline-primary btn-lg px-4">Kenali dulu penyebabnya</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="paper" id="paper">
                    <label for="load" class="paper-q">Seberapa penuh kepalamu minggu ini?</label>
                    <input type="range" class="form-range pen-range" id="load" min="0" max="100" value="15">
                    <div class="notes" id="notes" aria-hidden="true"></div>
                    <p class="pen-note" id="penNote" aria-live="polite"></p>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- PENYEBAB --}}
<section class="py-6" id="penyebab">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <h2 class="fw-bold">Yang nggak tertulis di rapor</h2>
                <p class="text-secondary">
                    Tekanan akademis datang dari banyak arah sekaligus. Sedikit tekanan bisa memotivasi,
                    tapi kalau terus-menerus, tubuh dan pikiran ikut kelelahan.
                </p>
            </div>
            <div class="col-lg-8">
                <dl class="ruled mb-0">
                    <div><dt>Tugas dan deadline</dt><dd>Beberapa tugas jatuh tempo di hari yang sama, belum lagi praktik dan laporan.</dd></div>
                    <div><dt>Harapan orang tua dan guru</dt><dd>Takut mengecewakan, jadi nilai terasa seperti harga diri.</dd></div>
                    <div><dt>Membandingkan diri</dt><dd>Peringkat dan nilai teman jadi patokan, bukan kemajuanmu sendiri.</dd></div>
                    <div><dt>Ujian dan penilaian</dt><dd>Cemas berlebihan menjelang ulangan, uji kompetensi, atau seleksi.</dd></div>
                </dl>
            </div>
        </div>
    </div>
</section>

{{-- TANDA-TANDA --}}
<section class="py-6 bg-white" id="tanda">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-5">
                <h2 class="fw-bold">Centang yang kamu rasakan</h2>
                <p class="text-secondary">Ini bukan tes resmi, cuma cara cepat melihat pola sebelum masuk ke quiz.</p>
                <div class="tick-result" id="tickResult" aria-live="polite">
                    <span class="tick-count"><b id="tickCount">0</b> dari 8</span>
                    <p class="mb-2" id="tickMsg">Belum ada yang dicentang.</p>
                    <a href="{{ $quiz }}" class="btn btn-primary btn-sm d-none" id="tickCta">Lanjut ke quiz</a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row g-2" id="tickList">
                    @foreach ([
                        'Susah tidur karena mikirin sekolah',
                        'Sering sakit kepala atau sakit perut',
                        'Cepat lelah walau tidak banyak bergerak',
                        'Overthinking soal nilai',
                        'Mudah marah atau sensitif',
                        'Malas berangkat sekolah',
                        'Menunda tugas sampai menit terakhir',
                        'Merasa tidak pernah cukup baik',
                    ] as $i => $t)
                        <div class="col-sm-6">
                            <input type="checkbox" class="btn-check" id="t{{ $i }}" autocomplete="off">
                            <label class="btn btn-tick w-100 text-start" for="t{{ $i }}">{{ $t }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CARA KERJA --}}
<section class="py-6" id="cara">
    <div class="container">
        <h2 class="fw-bold mb-4">Tiga langkah, sekitar 3 menit</h2>
        <ol class="row g-4 list-unstyled mb-0">
            <li class="col-md-4"><span class="step-no">1</span><h3 class="h5">Jawab quiz</h3><p class="text-secondary mb-0">Pilih angka 1 sampai 5 sesuai yang kamu rasakan akhir-akhir ini.</p></li>
            <li class="col-md-4"><span class="step-no">2</span><h3 class="h5">Lihat hasil</h3><p class="text-secondary mb-0">Dapat skor total dan grafik per kategori: tugas, ekspektasi, fisik, emosi.</p></li>
            <li class="col-md-4"><span class="step-no">3</span><h3 class="h5">Baca sarannya</h3><p class="text-secondary mb-0">Ada tips yang sesuai tingkat tekananmu dan daftar tempat meminta bantuan.</p></li>
        </ol>
    </div>
</section>

{{-- KARTU CURHAT --}}
<section class="py-6">
    <div class="container">
        <div class="cta-box text-start">
            <h2 class="display-6 fw-bold mb-2">Punya yang pengin diceritain?</h2>
            <p class="mb-4">Buka kartu kuning, tulis apa saja, lalu lepaskan. Tulisanmu tidak dikirim dan tidak disimpan.</p>
            <a href="{{ Route::has('kartu') ? route('kartu') : '#' }}" class="btn btn-warning btn-lg px-4">Buka kartu</a>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-6 bg-white" id="faq">
    <div class="container" style="max-width: 780px">
        <h2 class="fw-bold mb-4">Pertanyaan yang sering muncul</h2>
        <div class="accordion" id="faqAcc">
            @foreach ([
                ['Apakah quiz ini diagnosis?', 'Bukan. Hasilnya hanya gambaran awal. Untuk penilaian yang tepat, temui konselor sekolah atau psikolog.'],
                ['Apakah orang lain bisa melihat hasilku?', 'Hasil hanya bisa dibuka lewat link unik yang muncul setelah kamu selesai quiz.'],
                ['Perlu daftar akun?', 'Tidak. Daftar hanya perlu kalau kamu ingin menyimpan riwayat hasil.'],
                ['Kalau hasilnya tinggi, aku harus apa?', 'Ceritakan ke orang yang kamu percaya dan temui konselor sekolah. Halaman bantuan berisi kontak yang bisa dihubungi.'],
            ] as $i => [$q, $a])
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button {{ $i ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#f{{ $i }}">{{ $q }}</button>
                    </h3>
                    <div id="f{{ $i }}" class="accordion-collapse collapse {{ $i ? '' : 'show' }}" data-bs-parent="#faqAcc">
                        <div class="accordion-body text-secondary">{{ $a }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-6">
    <div class="container">
        <div class="cta-box">
            <h2 class="display-6 fw-bold mb-2">Mulai dari satu pertanyaan jujur.</h2>
            <p class="mb-4">Berapa berat yang sebenarnya kamu rasakan minggu ini?</p>
            <a href="{{ $quiz }}" class="btn btn-warning btn-lg px-4">Mulai quiz</a>
        </div>
    </div>
</section>

@endsection