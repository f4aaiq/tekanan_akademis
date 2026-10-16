<?php
namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'tugas' => [
                'Tugas dan deadline terasa menumpuk sampai sulit kuselesaikan.',
                'Aku begadang demi mengerjakan tugas atau belajar.',
                'Waktu sehari terasa tidak cukup untuk semua kewajiban sekolah.',
                'Aku kewalahan karena banyak ujian atau penilaian berdekatan.',
                'Aku menunda tugas karena terasa terlalu berat untuk dimulai.',
            ],
            'ekspektasi' => [
                'Aku takut mengecewakan orang tua atau guru jika nilaiku turun.',
                'Aku merasa harus selalu mendapat nilai tinggi.',
                'Aku merasa nilai menentukan seberapa berharga diriku.',
                'Aku dibandingkan dengan teman atau saudara soal prestasi.',
                'Aku merasa target yang diharapkan padaku terlalu tinggi.',
            ],
            'fisik' => [
                'Aku sulit tidur karena memikirkan sekolah.',
                'Aku sakit kepala atau sakit perut saat memikirkan tugas atau ujian.',
                'Aku mudah lelah meski tidak banyak beraktivitas.',
                'Nafsu makanku berubah drastis saat banyak tugas.',
                'Badanku tegang atau jantungku berdebar saat menghadapi ujian.',
            ],
            'emosi' => [
                'Aku cemas berlebihan soal nilai atau masa depan.',
                'Aku mudah marah atau sensitif karena urusan sekolah.',
                'Aku merasa sedih atau kosong setelah belajar seharian.',
                'Aku sulit berkonsentrasi karena pikiranku penuh.',
                'Aku merasa kewalahan sampai ingin berhenti belajar.',
            ],
            'sosial' => [
                'Aku malas berangkat ke sekolah.',
                'Aku menjauh dari teman atau kegiatan yang dulu kusukai.',
                'Aku merasa tertinggal dibanding teman sekelas.',
                'Aku sulit bercerita ke siapa pun soal beban sekolahku.',
                'Aku kehilangan semangat belajar.',
            ],
        ];

        Question::truncate();
        foreach ($data as $category => $items) {
            foreach ($items as $body) {
                Question::create(['category' => $category, 'body' => $body]);
            }
        }
    }
}