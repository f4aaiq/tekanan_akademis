document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('kartu');
    if (!root) return;
    const $ = (s) => root.querySelector(s);

    const messages = JSON.parse(root.dataset.messages);
    const crisis = JSON.parse(root.dataset.crisis);
    const text = $('#text'), release = $('#release'), care = $('#care'), wrap = $('#sheetWrap');
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const show = (id) => {
        ['#stHang', '#stWrite', '#stDone'].forEach((s) => $(s).classList.toggle('d-none', s !== id));
        const el = $(id);
        el.classList.remove('slide-right');
        void el.offsetWidth;
        el.classList.add('slide-right');
    };

    // tali ditarik, kartu terbuka
    $('#openCard').addEventListener('click', () => {
        $('#stHang').classList.add('open');
        setTimeout(() => { show('#stWrite'); text.focus(); }, reduce ? 0 : 650);
    });

    // mengetik (semua dicek di browser, tidak dikirim ke mana pun)
    const onInput = () => {
        $('#count').textContent = `${text.value.length} / 2000`;
        release.disabled = !text.value.trim();
        const v = text.value.toLowerCase();
        care.classList.toggle('d-none', !crisis.some((w) => v.includes(w)));
    };
    text.addEventListener('input', onInput);
    $('#clear').addEventListener('click', () => { text.value = ''; onInput(); text.focus(); });

    const finish = () => {
        $('#msg').textContent = messages[Math.floor(Math.random() * messages.length)];
        show('#stDone');
    };

    // lepaskan: kertas dilipat jadi pesawat, lalu terbang
    release.addEventListener('click', () => {
        release.disabled = true;
        if (reduce) { text.value = ''; onInput(); finish(); return; }

        $('#writeCard').classList.add('fold');                       // kartu menciut
        setTimeout(() => wrap.classList.add('show'), 350);          // selembar kertas muncul
        setTimeout(() => { text.value = ''; onInput(); }, 600);     // tulisan dihapus
        setTimeout(() => wrap.classList.add('f1'), 750);            // lipat 1: ujung meruncing
        setTimeout(() => wrap.classList.add('f2'), 1400);           // lipat 2: sayap terbuka
        setTimeout(() => wrap.classList.add('go'), 2200);           // terbang
        setTimeout(finish, 3900);
    });

    // tulis lagi: kembalikan semuanya
    $('#again').addEventListener('click', () => {
        $('#stHang').classList.remove('open');
        $('#writeCard').classList.remove('fold');
        wrap.className = 'sheet-wrap';
        show('#stHang');
    });

    // cegah tulisan hilang tanpa sengaja
    window.addEventListener('beforeunload', (e) => {
        if (text.value.trim()) e.preventDefault();
    });
});