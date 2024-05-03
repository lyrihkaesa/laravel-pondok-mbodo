<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\StudentStatus;
use App\Enums\StudentCategory;
use App\Enums\StudentCurrentSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $with = ['user'];

    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'current_school' => StudentCurrentSchool::class,
            'category' => StudentCategory::class,
            'status' => StudentStatus::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'enrollments', 'student_id', 'classroom_id')->withTimestamps();
    }

    public function lastEnrolledClassroom(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'enrollments', 'student_id', 'classroom_id')
            ->withTimestamps()
            ->orderByPivot('created_at', 'desc')
            ->limit(1);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'student_product')
            ->using(StudentProduct::class)->withPivot(['id', 'product_name', 'product_price', 'validated_at', 'validated_by'])->withTimestamps();
    }

    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(Guardian::class);
    }
}
