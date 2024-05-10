<?php

namespace App\Models;

use App\Enums\SocialMediaPlatform;
use App\Enums\SocialMediaVisibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMediaLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'username',
        'url',
        'visibility',
    ];

    protected function casts(): array
    {
        return [
            'platform' => SocialMediaPlatform::class,
            'visibility' => SocialMediaVisibility::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
