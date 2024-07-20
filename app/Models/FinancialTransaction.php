<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialTransaction extends Model
{
    use HasFactory, HasUlids;

    protected $primaryKey = 'id'; // Mengatur primary key menjadi 'id'
    protected $keyType = 'string'; // Mengatur tipe primary key menjadi string
    public $incrementing = false; // Menonaktifkan auto increment

    protected $fillable = [
        'id', // Tidak perlu diisi karena akan di-generate secara otomatis oleh UUID
        'name',
        'type',
        'amount',
        'quantity',
        'unit_price',
        'description',
        'from_wallet_id',
        'to_wallet_id',
        'student_bill_id',
        'validated_by',
        'transaction_at',
        'image_attachments',
        'file_attachments',
    ];

    protected function casts(): array
    {
        return [
            'image_attachments' => 'array',
            'file_attachments' => 'array',
        ];
    }

    public static function boot(): void
    {
        parent::boot();

        static::saving(function ($transaction) {
            $transaction->unit_price = $transaction->quantity > 0 ? $transaction->amount / $transaction->quantity : 0;
        });
    }

    public function fromWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    public function toWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }

    public function studentBill(): BelongsTo
    {
        return $this->belongsTo(StudentBill::class, 'student_bill_id');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
