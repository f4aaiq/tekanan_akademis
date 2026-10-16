<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuizResult extends Model
{
    protected $fillable = ['token', 'total', 'percent', 'level', 'category_scores'];
    protected $casts = ['category_scores' => 'array'];

    public const LABELS = [
        'tugas' => 'Beban tugas', 'ekspektasi' => 'Ekspektasi',
        'fisik' => 'Kondisi fisik', 'emosi' => 'Emosi', 'sosial' => 'Motivasi & sosial',
    ];

    public const QUOTES = [
    'rendah' => [
        ['text' => 'Kamu udah ngelakuin lebih banyak dari yang kamu sadari. Pelan-pelan juga nggak apa-apa.', 'by' => 'Pesan untukmu', 'src' => ''],
        ['text' => 'Istirahat itu bagian dari belajar, bukan hadiah setelah belajar.', 'by' => 'Pesan untukmu', 'src' => ''],
        ['text' => 'Jaga ritmemu hari ini. Besok kamu bakal berterima kasih sama dirimu sendiri.', 'by' => 'Pesan untukmu', 'src' => ''],
    ],
    'sedang' => [
        ['text' => 'Capek itu bukan tanda kamu lemah. Itu tanda kamu udah lama berusaha keras.', 'by' => 'Pesan untukmu', 'src' => ''],
        ['text' => 'Nggak semuanya harus beres hari ini. Satu langkah kecil udah cukup.', 'by' => 'Pesan untukmu', 'src' => ''],
        ['text' => 'Kamu boleh bilang "aku butuh jeda" tanpa merasa bersalah.', 'by' => 'Pesan untukmu', 'src' => ''],
    ],
    'tinggi' => [
        ['text' => 'Nilai itu angka. Kamu bukan angka, kamu jauh lebih dari itu.', 'by' => 'Pesan untukmu', 'src' => ''],
        ['text' => 'Kamu nggak harus kuat setiap saat. Minta tolong itu bukan berarti kalah.', 'by' => 'Pesan untukmu', 'src' => ''],
        ['text' => 'Hari ini berat, tapi hari ini bukan selamanya. Ceritakan ke satu orang, ya.', 'by' => 'Pesan untukmu', 'src' => ''],
    ],
];

    public const CATEGORY_TIPS = [
        'tugas' => ['Tulis semua tugas di satu tempat, lalu urutkan berdasarkan deadline.', 'Mulai dari langkah 5 menit pertama supaya tidak terasa berat.'],
        'ekspektasi' => ['Bedakan target dari orang lain dan targetmu sendiri.', 'Coba obrolkan harapan itu dengan orang tua atau guru secara tenang.'],
        'fisik' => ['Tidur di jam yang sama dan jauhkan HP 30 menit sebelum tidur.', 'Minum air dan bergerak ringan 10 menit, misalnya jalan kaki atau peregangan.'],
        'emosi' => ['Tulis perasaanmu 5 menit di buku, tanpa dinilai.', 'Coba napas 4-6: tarik napas 4 detik, buang 6 detik.'],
        'sosial' => ['Hubungi satu teman dekat hari ini, walau cuma ngobrol ringan.', 'Tulis satu alasan kamu belajar dan taruh di tempat yang terlihat.'],
    ];

    public const CHALLENGES = [
        'Tidur 30 menit lebih awal malam ini.',
        'Ceritakan satu hal yang kamu rasakan ke satu orang.',
        'Jalan kaki 10 menit tanpa HP.',
        'Minum segelas air, lalu tarik napas dalam 5 kali.',
        'Tulis 3 hal yang berhasil kamu lakukan minggu ini.',
        'Rapikan meja belajarmu selama 5 menit.',
        'Pilih satu tugas dan kerjakan hanya 10 menit.',
        'Kirim pesan ke teman yang lama tidak kamu sapa.',
    ];

    public static function fromAnswers(array $answers): self
    {
        $sum = $cnt = [];
        $total = $n = 0;

        foreach (Question::all() as $q) {
            $v = (int) ($answers[$q->id] ?? 0);
            abort_if($v < 1 || $v > 5, 422);
            $sum[$q->category] = ($sum[$q->category] ?? 0) + $v;
            $cnt[$q->category] = ($cnt[$q->category] ?? 0) + 1;
            $total += $v;
            $n++;
        }

        $pct = fn ($s, $c) => (int) round(($s - $c) / ($c * 4) * 100);
        $percent = $pct($total, $n);

        return self::create([
            'token' => Str::random(32),
            'total' => $total,
            'percent' => $percent,
            'level' => $percent < 35 ? 'rendah' : ($percent < 65 ? 'sedang' : 'tinggi'),
            'category_scores' => collect($sum)->map(fn ($s, $k) => $pct($s, $cnt[$k]))->all(),
        ]);
    }

    public function advice(): array
    {
        return match ($this->level) {
            'rendah' => [
                'title' => 'Tekananmu tergolong rendah',
                'text' => 'Kamu relatif masih bisa mengimbangi tuntutan sekolah. Pertahankan, dan jaga supaya tidak menumpuk.',
                'plan' => [
                    ['Jaga ritme', 'Pertahankan jam tidur dan belajar yang teratur. Ritme yang stabil adalah pelindung terbaik.'],
                    ['Isi tenagamu', 'Sisihkan waktu untuk hobi dan bertemu teman, minimal sekali seminggu.'],
                    ['Jadi penopang', 'Tanyakan kabar teman yang tampak kewalahan. Satu pertanyaan bisa sangat berarti.'],
                ],
            ],
            'sedang' => [
                'title' => 'Tekananmu tergolong sedang',
                'text' => 'Ada beban yang mulai terasa. Ini saat yang baik untuk mengatur ulang ritme sebelum menumpuk.',
                'plan' => [
                    ['Pecah dan urutkan', 'Tulis semua tugas, pecah jadi langkah kecil, lalu kerjakan satu per satu mulai dari deadline terdekat.'],
                    ['Atur istirahat', 'Belajar 25 menit, istirahat 5 menit. Tutup hari dengan jeda tanpa layar sebelum tidur.'],
                    ['Bagi bebanmu', 'Ceritakan bebanmu ke satu orang tepercaya. Beban yang dibagi biasanya terasa lebih ringan.'],
                ],
            ],
            default => [
                'title' => 'Tekananmu tergolong tinggi',
                'text' => 'Bebanmu terasa berat. Kamu tidak harus menghadapinya sendirian, dan mencari dukungan adalah langkah yang berani.',
                'plan' => [
                    ['Berhenti sejenak', 'Tarik napas pelan beberapa kali. Kamu tidak harus menyelesaikan semuanya hari ini.'],
                    ['Cari dukungan', 'Temui konselor sekolah atau guru BK, atau ceritakan ke orang tua atau orang dewasa yang kamu percaya.'],
                    ['Kurangi satu beban', 'Pilih satu hal yang bisa ditunda atau dibicarakan ulang, misalnya meminta perpanjangan waktu tugas.'],
                ],
            ],
        };
    }
}