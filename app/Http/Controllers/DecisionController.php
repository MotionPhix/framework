<?php

namespace App\Http\Controllers;

use App\Models\Decision;
use App\Services\DecisionScoringService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DecisionController extends Controller
{
    public function index()
    {
        $decisions = Decision::where('user_id', auth()->id())->latest()->get();
        return Inertia::render('decisions/Index', ['decisions' => $decisions]);
    }

    public function create()
    {
        return Inertia::render('decisions/Create');
    }

    public function store(Request $request, DecisionScoringService $scoringService)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:hiring,partnership,marketing,personal',
            'answers' => 'array'
        ]);

        $results = $scoringService->score($data['answers'] ?? [], $data['category']);

        $decision = Decision::create([
            ...$data,
            'user_id' => auth()->id(),
            'score' => $results['score'],
            'recommendation' => $results['recommendation']
        ]);

        return redirect()->route('decisions.index')->with('success', 'Decision logged.');
    }
}
