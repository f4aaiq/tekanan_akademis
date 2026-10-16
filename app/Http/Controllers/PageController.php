<?php
namespace App\Http\Controllers;

use App\Models\QuizResult;

class PageController extends Controller
{
    public function tips()
    {
        return view('tips', ['labels' => QuizResult::LABELS, 'tips' => QuizResult::CATEGORY_TIPS]);
    }

    public function bantuan()
    {
        return view('bantuan');
    }

    public function kartu()
    {
        return view('kartu', [
            'messages' => [
                'Makasih udah mau mengeluarkan isi hatimu. Itu bukan hal kecil.',
                'Apa pun yang kamu rasakan tadi itu nyata. Kamu nggak berlebihan.',
                'Biar perasaan berat tadi ikut terbang. Kamu tetap di sini, dan itu cukup.',
                'Kamu nggak harus kuat setiap saat.',
                'Nilai itu angka. Kamu bukan angka.',
                'Kalau masih terasa berat, ceritakan ke satu orang yang kamu percaya, ya.',
            ],
            'crisis' => ['bunuh diri', 'mengakhiri hidup', 'pengen mati', 'pengin mati', 'ingin mati', 'mati aja',
                'menyakiti diri', 'melukai diri', 'self harm', 'tidak ingin hidup', 'nggak mau hidup', 'gak mau hidup'],
        ]);
    }
}