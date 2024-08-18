<?php

namespace App\Models;

use App\Enums\PaymentTerm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'payment_term',
        'image_attachments',
    ];

    protected function casts(): array
    {
        return [
            'payment_term' => PaymentTerm::class,
            'image_attachments' => 'array',
        ];
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_bill')
            ->using(StudentBill::class)
            ->withPivot(['id', 'product_name', 'product_price', 'validated_at', 'validated_by'])
            ->withTimestamps();
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_product')
            ->withPivot('id')
            ->withTimestamps();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->where('type', 'ILIKE', '%produk%');
    }
}
