<?php

namespace App\Models;

use App\Enums\OrganizationCategory;
use App\Enums\SocialMediaVisibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'category' => OrganizationCategory::class,
            'phone_visibility' => SocialMediaVisibility::class,
        ];
    }

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'organization_program', 'organization_id', 'program_id');
    }

    public function extracurriculars(): BelongsToMany
    {
        return $this->belongsToMany(Extracurricular::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['role', 'position'])->withTimestamps()->with('employee');
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class);
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class);
    }

    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class, 'organization_id');
    }

    public function socialMediaLinks(): HasMany
    {
        return $this->hasMany(OrganizationSocialMediaLink::class);
    }
}
