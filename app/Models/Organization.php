<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'vision',
        'mission',
        'description',
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }

    public function extracurriculars()
    {
        return $this->belongsToMany(Extracurricular::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }
}
