<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classroom extends Model
{
    use HasFactory;
    protected $table = 'classrooms';
    protected $fillable = [
        'name',
        'combined_name',
        'academic_year_id',
        'homeroom_teacher_id',
        'organization_id',
        'end_date',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id')
            ->orderByDesc('name');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'classroom_id', 'student_id')
            ->using(Enrollment::class)
            ->withTimestamps();
    }

    public function homeroomTeacher(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'homeroom_teacher_id', 'id')
            ->without('user');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (): String => $this->name . ' - ' . $this->academicYear->name,
            set: function (String $value): array {
                $names = explode(' - ', $value);
                return [
                    'name' => $names[0],
                    'academic_year_id' => AcademicYear::where('name', $names[1])->first()->id ?? null,
                ];
            }
        );
    }
}
