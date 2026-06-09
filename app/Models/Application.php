<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company',
        'role',
        'location',
        'url',
        'status',
        'applied_at',
        'notes',
        'contact_name',
        'interview_date',
        'needs_followup',
    ];

    protected $casts = [
        'applied_at' => 'date',
        'interview_date' => 'date',
        'needs_followup' => 'boolean',
    ];
    public function activityLogs()
    {
    return $this->hasMany(ActivityLog::class)->latest();
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public static function statusColors(): array
    {
        return [
            'applied'   => 'blue',
            'interview' => 'yellow',
            'offer'     => 'green',
            'rejected'  => 'red',
        ];
    }

    public static function statusLabels(): array
    {
        return [
            'applied'   => 'Applied',
            'interview' => 'Interview',
            'offer'     => 'Offer',
            'rejected'  => 'Rejected',
        ];
    }
}
