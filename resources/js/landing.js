import { ScrollSpy } from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Navbar: garis tipis saat di-scroll + scrollspy menu aktif
    const nav = document.getElementById('siteNav');
    if (nav) {
        const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 10);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
        if (document.getElementById('beranda')) {
            new ScrollSpy(document.body, { target: '#siteNav', rootMargin: '-30% 0px -60% 0px' });
        }
    }

    // 2. Hero: slider "kepala penuh" memunculkan sticky note
    const load = document.getElementById('load');
    const notes = document.getElementById('notes');
    const penNote = document.getElementById('penNote');
    if (load && notes && penNote) {
        const items = [
            'Tugas Sejarah', 'Remedial MTK', 'PTS hari Senin', 'Laporan praktik',
            'Organisasi', 'Harus dapat 90', 'Ekskul', 'Dibandingin teman',
        ];
        items.forEach((text) => {
            const el = document.createElement('span');
            el.className = 'note';
            el.textContent = text;
            el.style.setProperty('--r', `${(Math.random() * 8 - 4).toFixed(1)}deg`);
            notes.appendChild(el);
        });

        const messages = [
            [25, 'Masih lega. Jaga ritme belajarmu.'],
            [60, 'Mulai menumpuk. Saatnya cek kondisimu.'],
            [101, 'Terasa berat ya. Coba quiz-nya, lalu ceritakan ke orang yang kamu percaya.'],
        ];

        const update = () => {
            const v = Number(load.value);
            const count = Math.round((v / 100) * items.length);
            notes.querySelectorAll('.note').forEach((el, i) => el.classList.toggle('on', i < count));
            penNote.textContent = messages.find(([max]) => v < max)[1];
        };
        load.addEventListener('input', update);
        update();
    }

    // 3. Centang tanda-tanda: hitung dan beri pesan
    const list = document.getElementById('tickList');
    if (list) {
        const count = document.getElementById('tickCount');
        const msg = document.getElementById('tickMsg');
        const cta = document.getElementById('tickCta');
        const boxes = list.querySelectorAll('input[type=checkbox]');

        const refresh = () => {
            const n = [...boxes].filter((b) => b.checked).length;
            count.textContent = n;
            cta.classList.toggle('d-none', n === 0);
            msg.textContent =
                n === 0 ? 'Belum ada yang dicentang.'
                : n <= 2 ? 'Beberapa tanda muncul. Quiz bisa membantu melihat polanya.'
                : n <= 5 ? 'Cukup banyak tanda. Sebaiknya cek lewat quiz dan bicarakan dengan orang terdekat.'
                : 'Banyak tanda yang kamu rasakan. Coba quiz, lalu temui konselor sekolah.';
        };
        boxes.forEach((b) => b.addEventListener('change', refresh));
        refresh();
    }

    // 4. Scroll reveal: elemen muncul perlahan saat masuk layar
    const targets = document.querySelectorAll('section:not(#beranda) .container > *');
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    io.unobserve(entry.target); // sekali saja, tidak diulang
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });

        targets.forEach((el) => {
            const index = [...el.parentElement.children].indexOf(el);
            el.style.setProperty('--d', `${index * 90}ms`); // muncul berurutan
            io.observe(el);
        });
    } else {
        targets.forEach((el) => el.classList.add('show')); // browser lama: langsung tampil
    }
});