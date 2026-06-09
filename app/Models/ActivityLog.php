<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'application_id',
        'user_id',
        'type',
        'body',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public static function typeLabels(): array
    {
        return [
            'note'      => '📝 Note',
            'interview' => '🎯 Interview',
            'email'     => '📧 Email',
            'offer'     => '🎉 Offer',
            'rejected'  => '❌ Rejected',
        ];
    }
}