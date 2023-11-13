<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools';
    protected $fillable = ['name'];

    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class, 'school_id', 'id');
    }
}
