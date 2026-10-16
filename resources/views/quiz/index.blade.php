@extends('layouts.app')
@section('title', 'Quiz Tekanan Akademis')

@section('content')
<section class="py-6">
    <div class="container" style="max-width: 760px">
        <div id="quiz" data-questions="{{ $questions->toJson() }}">

            <div id="intro" class="quiz-card text-center">
                <h1 class="fw-bold">Cek tekanan akademismu</h1>
                <p class="text-secondary">{{ $questions->count() }} pernyataan, sekitar 5 menit. Jawab sesuai yang kamu rasakan <b>sebulan terakhir</b>. Tidak ada jawaban benar atau salah.</p>
                <p class="small text-muted">Hasil hanya gambaran awal, bukan diagnosis.</p>
                <button class="btn btn-primary btn-lg px-5" data-start>Mulai</button>
            </div>

            <div id="stage" class="quiz-card d-none">
                <div class="d-flex justify-content-between small fw-semibold mb-2">
                    <span id="qCat" class="q-cat"></span><span id="qNo"></span>
                </div>
                <div class="q-progress mb-4"><div id="bar"></div></div>
                <div id="card">
                    <p id="qText" class="q-text"></p>
                    <div id="scale" class="scale"></div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button class="btn btn-outline-primary" id="back">Kembali</button>
                    <span id="note" class="text-secondary small"></span>
                </div>
            </div>

            <form id="form" method="POST" action="{{ route('quiz.store') }}">@csrf</form>
        </div>
    </div>
</section>
@endsection