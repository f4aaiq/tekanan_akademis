@extends('layouts.app')
@section('title', 'Bantuan')

@php
    // Isi dengan kontak resmi yang sudah diverifikasi (tanya guru BK). Contoh:
    // ['nama' => 'Nama layanan', 'info' => 'Nomor/alamat dan jam layanan']
    $kontak = [];
@endphp

@section('content')
<section class="py-6">
    <div class="container">
        <h1 class="fw-bold">Kamu tidak sendirian</h1>
        <p class="text-secondary">Meminta bantuan itu langkah berani. Mulai dari orang yang paling dekat.</p>
        <div class="row g-3 mt-1">
            <div class="col-md-4"><div class="plan-card h-100"><h2 class="h5 fw-bold">Guru BK / konselor</h2><p class="small mb-0">Datangi ruang BK di sekolah. Kamu boleh minta ditemani teman.</p></div></div>
            <div class="col-md-4"><div class="plan-card h-100"><h2 class="h5 fw-bold">Orang tua atau wali</h2><p class="small mb-0">Pilih waktu yang tenang. Mulai dengan "aku lagi capek banget sama sekolah".</p></div></div>
            <div class="col-md-4"><div class="plan-card h-100"><h2 class="h5 fw-bold">Puskesmas / psikolog</h2><p class="small mb-0">Banyak puskesmas punya layanan konseling. Tanyakan ke petugas.</p></div></div>
        </div>

        <div class="quiz-card help-card mt-4">
            <h2 class="h5 fw-bold">Kalau terasa sangat berat atau muncul pikiran menyakiti diri</h2>
            <p class="mb-0">Segera hubungi orang dewasa tepercaya, atau datang ke IGD/puskesmas terdekat dan layanan darurat setempat. Jangan tunggu sampai besok.</p>
        </div>

        @if ($kontak)
            <h2 class="h5 fw-bold mt-4">Kontak layanan</h2>
            <ul>@foreach ($kontak as $k)<li><b>{{ $k['nama'] }}</b>: {{ $k['info'] }}</li>@endforeach</ul>
        @endif
    </div>
</section>
@endsection