<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentProduct extends Pivot
{
    public $incrementing = true;
    protected $table = 'student_product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_id',
        'product_id',
        'product_name',
        'product_price',
        'validated_at',
        'validated_by',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'validated_at' => 'datetime',
    ];

    // public function isValidated(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => $this->validated_at === null ? false : true
    //     );
    // }

    protected $with = [
        'validator',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
