<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_product')
            ->using(StudentProduct::class)->withPivot('id');
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_product')->withPivot('id')->withTimestamps();
    }
}
