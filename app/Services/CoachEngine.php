<?php

namespace App\Services;

class CoachEngine
{
    public function toughLove(string $message): string
    {
        return "Reality check: " . $message;
    }

    public function reflective(string $message): string
    {
        return "Pause and think: " . $message;
    }

    public function noBS(string $message): string
    {
        return "Cut the noise: " . $message;
    }
}
