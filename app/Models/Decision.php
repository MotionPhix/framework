<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Decision extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'answers',
        'score',
        'recommendation',
        'user_id',
        'est_revenue',
        'est_cost',
        'roi_percent',
        'impact',
        'effort',
        'time_to_value_days',
        'risk',
        'second_order_benefits',
        'second_order_risks',
        'priority',
    ];

    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'est_revenue' => 'decimal:2',
            'est_cost' => 'decimal:2',
            'roi_percent' => 'decimal:2',
            'impact' => 'integer',
            'effort' => 'integer',
            'time_to_value_days' => 'integer',
            'risk' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
