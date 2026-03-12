<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramUnlockRequest extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'unlock_token',
        'status',
        'email',
        'instagram_username',
        'igsid',
        'is_following',
        'last_event_at',
        'unlocked_at',
        'meta_payload',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_following' => 'boolean',
            'last_event_at' => 'datetime',
            'unlocked_at' => 'datetime',
            'meta_payload' => 'array',
        ];
    }
}
