<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use HasFactory;

    protected $table = 'academic_years';
    protected $fillable = ['name'];

    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class, 'academic_year_id', 'id');
    }
}
