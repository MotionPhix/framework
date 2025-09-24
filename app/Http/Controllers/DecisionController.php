<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDecisionRequest;
use App\Models\Decision;
use App\Services\DecisionScoringService;
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

    public function store(StoreDecisionRequest $request, DecisionScoringService $scoringService)
    {
        $data = $request->validated();

        $roiPercent = null;
        if (!empty($data['est_revenue']) && isset($data['est_cost']) && (float) $data['est_cost'] > 0) {
            $roiPercent = ((float) $data['est_revenue'] - (float) $data['est_cost']) / (float) $data['est_cost'] * 100.0;
        }

        $results = $scoringService->score(
            $data['answers'] ?? [],
            $data['category'],
            [
                'roi_percent' => $roiPercent,
                'impact' => $data['impact'] ?? null,
                'effort' => $data['effort'] ?? null,
                'time_to_value_days' => $data['time_to_value_days'] ?? null,
                'risk' => $data['risk'] ?? null,
            ]
        );

        $decision = Decision::create([
            ...$data,
            'user_id' => auth()->id(),
            'roi_percent' => $roiPercent,
            'score' => $results['score'],
            'recommendation' => $results['recommendation'],
        ]);

        return redirect()->route('decisions.index')->with('success', 'Decision logged.');
    }
}
