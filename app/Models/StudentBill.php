<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentBill extends Pivot
{
    protected $table = 'student_bill';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'product_id',
        'product_name',
        'product_price',
        'bill_date_time',
        'validated_at',
        'validated_by',
        "description",
        "image_attachments",
        "file_attachments",
        "created_at",
        "updated_at",
    ];

    protected $casts = [
        'validated_at' => 'datetime',
        'bill_date_time' => 'datetime',
    ];

    protected $with = [
        'validator',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id')
            ->withOut('user');
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
