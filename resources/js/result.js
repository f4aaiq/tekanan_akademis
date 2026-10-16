document.addEventListener('DOMContentLoaded', () => {
    const r = document.getElementById('result');
    if (!r) return;
    const $ = (s) => r.querySelector(s);

    // skor naik perlahan
    const target = +r.dataset.percent, el = $('#pct'), t0 = performance.now();
    const tick = (t) => {
        const p = Math.min((t - t0) / 1200, 1);
        el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
        if (p < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);

    // bar kategori
    r.querySelectorAll('[data-w]').forEach((b) => setTimeout(() => (b.style.width = b.dataset.w + '%'), 200));

    // radar chart
    const color = getComputedStyle(r).getPropertyValue('--lv').trim() || '#17233B';
    new window.Chart($('#radar'), {
        type: 'radar',
        data: {
            labels: JSON.parse(r.dataset.labels),
            datasets: [{ data: JSON.parse(r.dataset.values), borderColor: color, backgroundColor: color + '33', pointBackgroundColor: color }],
        },
        options: { plugins: { legend: { display: false } }, scales: { r: { min: 0, max: 100, ticks: { display: false } } } },
    });

    // pemutar teks bergantian (kutipan dan tantangan)
    const rotator = (box, items, paint, btn) => {
        let n = Math.floor(Math.random() * items.length);
        paint(items[n]);
        $(btn).addEventListener('click', () => {
            box.classList.add('swap');
            setTimeout(() => { n = (n + 1) % items.length; paint(items[n]); box.classList.remove('swap'); }, 250);
        });
    };

    const qc = $('#quote');
    if (qc) rotator(qc, JSON.parse(qc.dataset.quotes), (q) => {
        $('#qtText').textContent = `\u201C${q.text}\u201D`;
        $('#qtBy').textContent = q.by;
        $('#qtSrc').textContent = q.src ? `(${q.src})` : '';
    }, '#qtNext');

    const ch = $('#challenge');
    if (ch) rotator(ch, JSON.parse(ch.dataset.items), (t) => ($('#chText').textContent = t), '#chNext');

    // bagikan ke WhatsApp (hanya link quiz, bukan hasil)
    $('#share').addEventListener('click', () => {
        const text = `Aku baru cek tekanan akademis lewat web ini. Coba juga: ${new URL(r.dataset.quizUrl, location.origin)}`;
        window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank', 'noopener');
    });

    // simpan ringkasan sebagai gambar
        const save = $('#save');
    save.addEventListener('click', async () => {
        save.disabled = true;
        save.textContent = 'Menyiapkan...';
        try {
            const { default: html2canvas } = await import('html2canvas');
            document.getElementById('shareMsg').textContent = $('#qtText').textContent;
            const canvas = await html2canvas(document.getElementById('shareCard'), { backgroundColor: null, scale: 2 });
            const a = document.createElement('a');
            a.download = 'hasil-tekanan-akademis.png';
            a.href = canvas.toDataURL('image/png');
            a.click();
            save.textContent = 'Tersimpan';
        } catch {
            save.textContent = 'Gagal, coba lagi';
        }
        setTimeout(() => { save.disabled = false; save.textContent = 'Simpan sebagai gambar'; }, 2000);
    });

    // salin link hasil
    const copy = $('#copy');
    copy.addEventListener('click', async () => {
        try { await navigator.clipboard.writeText(location.href); copy.textContent = 'Link tersalin'; }
        catch { copy.textContent = 'Salin manual dari address bar'; }
    });
});