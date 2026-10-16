@extends('layouts.app')
@section('title', 'Tips')

@section('content')
<section class="py-6">
    <div class="container">
        <h1 class="fw-bold">Tips menghadapi tekanan akademis</h1>
        <p class="text-secondary">Pilih bagian yang paling terasa buatmu. Mulai dari satu saja.</p>
        <div class="row g-3 mt-1">
            @foreach ($labels as $key => $label)
                <div class="col-md-6">
                    <div class="plan-card h-100">
                        <h2 class="h5 fw-bold">{{ $label }}</h2>
                        <ul class="mb-0">
                            @foreach ($tips[$key] as $t)<li>{{ $t }}</li>@endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection