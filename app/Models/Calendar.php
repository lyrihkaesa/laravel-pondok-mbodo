<?php

namespace App\Models;

use App\Enums\SocialMediaVisibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'google_calendar_id',
        'name',
        'description',
        'color',
        'timezone',
    ];


    protected function casts(): array
    {
        return [
            'visibility' => SocialMediaVisibility::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
