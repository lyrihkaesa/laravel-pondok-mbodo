<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
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
        'description',
        'transaction_date',
        'from_wallet_id',
        'to_wallet_id',
        // Kolom lainnya sesuai kebutuhan aplikasi Anda
    ];

    /**
     * Get the wallet where the transaction is from.
     */
    public function fromWallet()
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    /**
     * Get the wallet where the transaction is to.
     */
    public function toWallet()
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }
}
