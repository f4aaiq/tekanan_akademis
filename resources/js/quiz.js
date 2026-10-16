document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('quiz');
    if (!root) return;

    const qs = JSON.parse(root.dataset.questions);
    const LABEL = { tugas: 'Beban tugas', ekspektasi: 'Ekspektasi', fisik: 'Kondisi fisik', emosi: 'Emosi', sosial: 'Motivasi & sosial' };
    const SCALE = ['Tidak pernah', 'Jarang', 'Kadang', 'Sering', 'Sangat sering'];
    const KEY = 'ta-quiz';
    const $ = (s) => root.querySelector(s);

    let i = 0, ans = {}, lock = false;
    try { ({ i = 0, ans = {} } = JSON.parse(sessionStorage.getItem(KEY)) || {}); } catch {}

    const save = () => sessionStorage.setItem(KEY, JSON.stringify({ i, ans }));

    const scale = $('#scale');
    SCALE.forEach((t, k) => {
        const b = document.createElement('button');
        b.type = 'button';
        b.className = 'scale-btn';
        b.dataset.v = k + 1;
        b.innerHTML = `<b>${k + 1}</b><span>${t}</span>`;
        b.addEventListener('click', () => pick(k + 1));
        scale.appendChild(b);
    });

    function render(dir = 1) {
        const q = qs[i];
        $('#qNo').textContent = `${i + 1} / ${qs.length}`;
        $('#qCat').textContent = LABEL[q.category] ?? q.category;
        $('#qText').textContent = q.body;
        $('#bar').style.width = `${(i / qs.length) * 100}%`;
        $('#back').disabled = i === 0;
        $('#note').textContent = i === Math.floor(qs.length / 2) ? 'Setengah jalan, lanjut ya.' : 'Tekan 1-5 di keyboard juga bisa.';
        scale.querySelectorAll('.scale-btn').forEach((b) => b.classList.toggle('on', +b.dataset.v === ans[q.id]));

        const card = $('#card');
        card.classList.remove('slide-right', 'slide-left');
        void card.offsetWidth; // restart animasi
        card.classList.add(dir > 0 ? 'slide-right' : 'slide-left');
    }

    function pick(v) {
        if (lock) return;
        ans[qs[i].id] = v;
        save();
        render(0);
        lock = true;
        setTimeout(() => { lock = false; next(); }, 320);
    }

    function next() {
        if (i < qs.length - 1) { i++; save(); render(1); return; }
        finish();
    }

    function finish() {
        $('#bar').style.width = '100%';
        $('#qText').textContent = 'Menghitung hasilmu...';
        scale.classList.add('d-none');
        const form = $('#form');
        Object.entries(ans).forEach(([id, v]) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `answers[${id}]`;
            input.value = v;
            form.appendChild(input);
        });
        sessionStorage.removeItem(KEY);
        setTimeout(() => form.submit(), 600);
    }

    $('#back').addEventListener('click', () => { if (i > 0) { i--; save(); render(-1); } });

    document.addEventListener('keydown', (e) => {
        if ($('#stage').classList.contains('d-none')) return;
        if (/^[1-5]$/.test(e.key)) pick(+e.key);
        if (e.key === 'ArrowLeft' || e.key === 'Backspace') $('#back').click();
    });

    $('[data-start]').addEventListener('click', () => {
        $('#intro').classList.add('d-none');
        $('#stage').classList.remove('d-none');
        render(1);
    });

    // lanjut dari progres yang tersimpan
    if (Object.keys(ans).length) $('[data-start]').textContent = 'Lanjutkan';
});