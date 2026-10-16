@extends('layouts.app')
@section('title', 'Kartu Curhat')

@php $bantuan = Route::has('bantuan') ? route('bantuan') : '#'; $tips = Route::has('tips') ? route('tips') : '#'; @endphp

@section('content')
<section class="py-6">
    <div class="container" style="max-width: 720px">
        <div id="kartu" data-messages="{{ json_encode($messages) }}" data-crisis="{{ json_encode($crisis) }}">
            <p class="q-cat text-center mb-1">Kartu curhat</p>
            <h1 class="fw-bold text-center">Ada yang pengin kamu ceritain?</h1>
            <p class="text-secondary text-center">Tulis apa saja. Tulisanmu tidak dikirim ke server dan tidak disimpan. Isinya hanya ada di layarmu sampai kamu lepaskan.</p>

            {{-- 1. kartu tergantung --}}
            <div id="stHang" class="hang">
                <div class="sway">
                    <div class="string"></div>
                    <button type="button" class="note-card" id="openCard" aria-label="Buka kartu curhat">
                        <span class="pin"></span>
                        <b>Tarik talinya</b>
                        <small>untuk membuka kartu</small>
                    </button>
                </div>
            </div>

            {{-- 2. menulis --}}
            <div id="stWrite" class="d-none">
                <div class="write-card" id="writeCard">
                    <textarea id="text" rows="9" maxlength="2000" spellcheck="false" autocomplete="off"
                              placeholder="Tulis di sini. Nggak perlu rapi, nggak perlu benar."></textarea>
                    <div class="d-flex justify-content-between small">
                        <span id="count">0 / 2000</span>
                        <span>Ini ruang menulis, bukan percakapan. Tidak ada yang membalas.</span>
                    </div>
                </div>

                <div class="sheet-wrap" id="sheetWrap" aria-hidden="true"><div class="sheet"></div></div>

                <div id="care" class="care d-none">
                    <b>Ada hal yang kedengarannya berat banget. Kamu penting.</b>
                    <p class="mb-2">Tolong ceritakan ke orang dewasa yang kamu percaya sekarang, atau datangi IGD atau puskesmas terdekat.</p>
                    <a href="{{ $bantuan }}" class="btn btn-sm btn-primary">Lihat halaman bantuan</a>
                </div>

                <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                    <button class="btn btn-primary" id="release" disabled>Lepaskan</button>
                    <button class="btn btn-outline-primary" id="clear">Hapus semua</button>
                </div>
            </div>

            {{-- 3. selesai --}}
            <div id="stDone" class="text-center d-none">
                <h2 class="fw-bold">Sudah kamu lepaskan.</h2>
                <p id="msg" class="fs-5 fw-bold my-3"></p>
                <p class="text-secondary">Tulisanmu sudah hilang dari layar ini. Kalau masih terasa berat, ceritakan ke satu orang yang kamu percaya.</p>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <button class="btn btn-primary" id="again">Tulis lagi</button>
                    <a href="{{ $tips }}" class="btn btn-outline-primary">Baca tips</a>
                    <a href="{{ $bantuan }}" class="btn btn-outline-primary">Cari teman bicara</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection