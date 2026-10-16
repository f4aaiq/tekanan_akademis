<?php
namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $questions = Question::orderBy('id')->get(['id', 'category', 'body']);
        return view('quiz.index', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'answers' => ['required', 'array', 'size:' . Question::count()],
            'answers.*' => ['integer', 'between:1,5'],
        ]);

        $result = QuizResult::fromAnswers($request->input('answers'));
        return redirect()->route('quiz.result', $result->token);
    }

    public function result(string $token)
    {
        $result = QuizResult::where('token', $token)->firstOrFail();
        $labels = array_values(QuizResult::LABELS);
        $scores = collect(QuizResult::LABELS)->keys()
            ->map(fn ($k) => $result->category_scores[$k] ?? 0)->all();

        $topKey = collect($result->category_scores)->sortDesc()->keys()->first();

        return view('quiz.result', [
            'result' => $result,
            'advice' => $result->advice(),
            'labels' => $labels,
            'scores' => $scores,
            'quotes' => QuizResult::QUOTES[$result->level],
            'top' => [
                'label' => QuizResult::LABELS[$topKey] ?? '',
                'score' => $result->category_scores[$topKey] ?? 0,
                'tips' => QuizResult::CATEGORY_TIPS[$topKey] ?? [],
            ],
            'challenges' => QuizResult::CHALLENGES,
        ]);
    }
}