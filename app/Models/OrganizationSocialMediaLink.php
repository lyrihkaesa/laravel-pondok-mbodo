<?php

namespace App\Models;

use App\Enums\SocialMediaPlatform;
use App\Enums\SocialMediaVisibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationSocialMediaLink extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'platform' => SocialMediaPlatform::class,
            'visibility' => SocialMediaVisibility::class,
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public static function boot()
    {
        parent::boot();

        static::updated(function ($model) {
            if ($model->organization_id === 1) {
                cache()->forget('yayasan_pondok_mbodo');
            }
        });

        static::created(function ($model) {
            if ($model->organization_id === 1) {
                cache()->forget('yayasan_pondok_mbodo');
            }
        });

        static::deleted(function ($model) {
            if ($model->organization_id === 1) {
                cache()->forget('yayasan_pondok_mbodo');
            }
        });
    }
}
