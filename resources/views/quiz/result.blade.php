@extends('layouts.app')
@section('title', 'Hasil Quiz')

@php
    $tips = Route::has('tips') ? route('tips') : '#';
    $bantuan = Route::has('bantuan') ? route('bantuan') : '#';
    $kartu = Route::has('kartu') ? route('kartu') : '#';
@endphp

@section('content')
<section class="py-6">
    <div class="container level-{{ $result->level }}" style="max-width: 860px" id="result"
         data-percent="{{ $result->percent }}"
         data-labels="{{ json_encode($labels) }}" data-values="{{ json_encode($scores) }}"
         data-quiz-url="{{ route('quiz.index') }}">

        <div id="summary" class="pb-3">
            <h1 class="fw-bold">{{ $advice['title'] }}</h1>
            <p class="text-secondary">{{ $advice['text'] }}</p>
            <div class="row g-4 align-items-center">
                <div class="col-md-5 text-center">
                    <div class="score-ring"><span id="pct">0</span><small>%</small></div>
                    <span class="level-badge">{{ ucfirst($result->level) }}</span>
                </div>
                <div class="col-md-7"><canvas id="radar" height="260"></canvas></div>
            </div>
        </div>

        <figure class="quote-card my-4" id="quote" data-quotes="{{ json_encode($quotes) }}">
            <blockquote id="qtText"></blockquote>
            <figcaption><b id="qtBy"></b> <span id="qtSrc" class="small"></span></figcaption>
            <button type="button" class="btn btn-sm btn-outline-primary" id="qtNext">Kutipan lain</button>
        </figure>

        <div class="quiz-card top-card mb-4">
            <p class="q-cat mb-1">Yang paling terasa</p>
            <h2 class="h4 fw-bold">{{ $top['label'] }} <span class="text-secondary fs-6">({{ $top['score'] }}%)</span></h2>
            <ul class="mb-0">
                @foreach ($top['tips'] as $t)<li>{{ $t }}</li>@endforeach
            </ul>
        </div>

        <h2 class="h5 fw-bold">Skor per kategori</h2>
        <div class="mb-4">
            @foreach ($labels as $i => $label)
                <div class="d-flex justify-content-between small fw-semibold mt-3">
                    <span>{{ $label }}</span><span>{{ $scores[$i] }}%</span>
                </div>
                <div class="bar-track"><div class="bar-fill" data-w="{{ $scores[$i] }}"></div></div>
            @endforeach
        </div>

        <h2 class="h5 fw-bold">Langkah yang bisa kamu coba</h2>
        <div class="row g-3 mb-4">
            @foreach ($advice['plan'] as $n => [$judul, $isi])
                <div class="col-md-4">
                    <div class="plan-card h-100">
                        <span class="step-no">{{ $n + 1 }}</span>
                        <h3 class="h6 fw-bold">{{ $judul }}</h3>
                        <p class="small text-secondary mb-0">{{ $isi }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="challenge-card mb-4" id="challenge" data-items="{{ json_encode($challenges) }}">
            <p class="q-cat mb-1">Tantangan kecil hari ini</p>
            <p class="h5 fw-bold mb-3" id="chText"></p>
            <button type="button" class="btn btn-sm btn-primary" id="chNext">Tantangan lain</button>
        </div>

        @if ($result->level !== 'rendah')
            <div class="quiz-card help-card mb-4">
                <h2 class="h5 fw-bold">Butuh teman bicara?</h2>
                <p class="mb-2">Konselor sekolah atau guru BK siap mendengarkan, dan kamu boleh minta ditemani orang tua atau teman.</p>
                @if ($result->level === 'tinggi')
                    <p class="small mb-3">Kalau muncul pikiran untuk menyakiti diri sendiri, segera hubungi orang dewasa tepercaya atau layanan kesehatan darurat terdekat.</p>
                @endif
                <a href="{{ $kartu }}" class="btn btn-warning btn-sm me-1">Tulis di kartu curhat</a>
                <a href="{{ $bantuan }}" class="btn btn-primary btn-sm me-1">Lihat halaman bantuan</a>
                <a href="{{ $tips }}" class="btn btn-outline-primary btn-sm">Baca tips</a>
            </div>
        @else
            <a href="{{ $tips }}" class="btn btn-outline-primary btn-sm mb-4">Baca tips belajar</a>
        @endif

        <p class="small text-muted">Hasil ini hanya gambaran awal dari jawabanmu, bukan diagnosis atau vonis psikologis. Untuk penilaian yang tepat, temui konselor atau psikolog.</p>

        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-primary" id="share">Ajak teman via WhatsApp</button>
            <button class="btn btn-outline-primary" id="save">Simpan sebagai gambar</button>
            <button class="btn btn-outline-primary" id="copy">Salin link hasil</button>
            <a href="{{ route('quiz.index') }}" class="btn btn-outline-primary">Ulangi quiz</a>
        </div>
        <p class="small text-muted mt-2">Link hasil bersifat pribadi. Tombol WhatsApp hanya membagikan link quiz, bukan hasilmu.</p>
    </div>

    <div class="share-wrap" aria-hidden="true">
        <div id="shareCard" class="share-card level-{{ $result->level }}">
            <p class="q-cat mb-1">Cek tekanan akademis</p>
            <h2>{{ $advice['title'] }}</h2>
            <div class="score-ring"><span>{{ $result->percent }}</span><small>%</small></div>
            <span class="level-badge">{{ ucfirst($result->level) }}</span>
            <div class="bars">
                @foreach ($labels as $i => $label)
                    <div class="d-flex justify-content-between small fw-semibold mt-2"><span>{{ $label }}</span><span>{{ $scores[$i] }}%</span></div>
                    <div class="bar-track"><div class="bar-fill" style="width: {{ $scores[$i] }}%"></div></div>
                @endforeach
            </div>
            <p class="share-msg" id="shareMsg"></p>
            <p class="small text-muted mb-0">Gambaran awal, bukan diagnosis.</p>
        </div>
    </div>
</section>
@endsection