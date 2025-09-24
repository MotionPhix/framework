<?php

namespace App\Services;

class DecisionScoringService
{
    public function score(array $answers, string $category): array
    {
        // Example scoring logic — later we’ll refine with CoachEngine
        $score = 0;

        foreach ($answers as $answer) {
            $score += is_numeric($answer) ? (int) $answer : 0;
        }

        $recommendation = $this->generateRecommendation($score, $category);

        return [
            'score' => $score,
            'recommendation' => $recommendation
        ];
    }

    private function generateRecommendation(int $score, string $category): string
    {
        if ($score >= 80) {
            return "Strong YES — this aligns with scale, leverage, or legacy.";
        }

        if ($score >= 50) {
            return "Conditional — clarify impact before committing.";
        }

        return "No. This is distraction disguised as opportunity.";
    }
}
