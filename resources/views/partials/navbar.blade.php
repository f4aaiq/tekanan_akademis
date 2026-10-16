<nav class="navbar navbar-expand-lg sticky-top site-nav" id="siteNav">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">Tekanan Akademis</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#penyebab">Penyebab</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#tanda">Tanda-tanda</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#cara">Cara kerja</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#faq">FAQ</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ Route::has('kartu') ? route('kartu') : '#' }}">Kartu curhat</a></li>
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-primary btn-sm px-3" href="{{ Route::has('quiz.index') ? route('quiz.index') : '#' }}">Mulai quiz</a>
                </li>
            </ul>
        </div>
    </div>
</nav>