<?php

namespace App\Models;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id'; // Mengatur primary key menjadi 'id'
    protected $keyType = 'string'; // Mengatur tipe primary key menjadi string
    public $incrementing = false; // Menonaktifkan auto increment

    protected $fillable = [
        'id',
        'name',
        'balance',
        'user_id',
        'organization_id',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the organization that owns the wallet.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the transactions for the wallet as the source.
     */
    public function sourceTransactions()
    {
        return $this->hasMany(FinancialTransaction::class, 'from_wallet_id');
    }

    /**
     * Get the transactions for the wallet as the destination.
     */
    public function destinationTransactions()
    {
        return $this->hasMany(FinancialTransaction::class, 'to_wallet_id');
    }

    /**
     * Get all financial transactions where this wallet is either the source or destination.
     */
    public function transactions()
    {
        return FinancialTransaction::where('from_wallet_id', $this->id)
            ->orWhere('to_wallet_id', $this->id)
            ->get();
    }
}
