<?php

namespace App\Services;

class DecisionScoringService
{
    public function score(array $answers, string $category, array $signals = []): array
    {
        $scoreParts = [];
        $weights = [];

        // Base answers additive score (0-100 scale)
        $base = 0;
        foreach ($answers as $answer) {
            $base += is_numeric($answer) ? (int) $answer : 0;
        }
        $base = max(0, min(100, $base));
        $scoreParts['base'] = $base; $weights['base'] = 20;

        // ROI percent contribution (-inf..+inf) mapped to 0..100 where 0% -> 50
        if (isset($signals['roi_percent']) && $signals['roi_percent'] !== null) {
            $roi = (float) $signals['roi_percent'];
            $roiScore = max(0.0, min(100.0, 50.0 + ($roi / 2.0))); // +2 ROI -> +1 point
            $scoreParts['roi'] = $roiScore; $weights['roi'] = 25;
        }

        if (isset($signals['impact'])) {
            $impact = (int) $signals['impact'];
            $scoreParts['impact'] = max(0, min(100, $impact * 10)); $weights['impact'] = 20;
        }

        if (isset($signals['effort'])) {
            $effort = (int) $signals['effort'];
            $scoreParts['effort'] = max(0, min(100, (10 - $effort) * 10)); $weights['effort'] = 10; // lower is better
        }

        if (isset($signals['time_to_value_days'])) {
            $days = max(0, (int) $signals['time_to_value_days']);
            // 0 days -> 100, 30 days -> ~80, 90 days -> ~40, 180+ -> ~0 (clamped)
            $timeScore = max(0.0, 100.0 - min(100.0, ($days / 30.0) * 20.0));
            $scoreParts['time'] = $timeScore; $weights['time'] = 10;
        }

        if (isset($signals['risk'])) {
            $risk = (int) $signals['risk'];
            $scoreParts['risk'] = max(0, min(100, (10 - $risk) * 10)); $weights['risk'] = 15; // lower is better
        }

        // Normalize weighted average of available parts
        $totalWeight = array_sum($weights) ?: 1;
        $weighted = 0.0;
        foreach ($scoreParts as $key => $value) {
            $w = $weights[$key] ?? 0;
            $weighted += $value * ($w / $totalWeight);
        }
        $finalScore = (int) round($weighted);

        $recommendation = $this->generateRecommendation($finalScore, $category);

        return [
            'score' => $finalScore,
            'recommendation' => $recommendation,
        ];
    }

    private function generateRecommendation(int $score, string $category): string
    {
        if ($score >= 80) {
            return "Strong YES — high leverage ${category} move aligned with scale, leverage, or legacy.";
        }

        if ($score >= 55) {
            return 'Conditional YES — reduce risk, clarify ROI, or shorten time-to-value before proceeding.';
        }

        return 'No — politely decline. Protect focus and redirect resources to compounding bets.';
    }
}
