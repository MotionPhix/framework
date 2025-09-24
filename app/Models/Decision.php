<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'answers',
        'score',
        'recommendation',
        'user_id'
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
