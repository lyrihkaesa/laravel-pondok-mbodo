<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $with = ['user'];

    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function homeroomClassrooms()
    {
        return $this->hasMany(Classroom::class, 'homeroom_teacher_id', 'id');
    }
}
