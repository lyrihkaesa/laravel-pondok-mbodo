<?php

namespace App\Models;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'wallet_code',
        'name',
        'balance',
        'user_id',
        'organization_id',
        'policy',
    ];

    protected function casts(): array
    {
        return [
            'policy' => 'array',
        ];
    }

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
    public function sourceTransactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class, 'from_wallet_id');
    }

    /**
     * Get the transactions for the wallet as the destination.
     */
    public function destinationTransactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class, 'to_wallet_id');
    }

    /**
     * Get all financial transactions where this wallet is either the source or destination.
     */
    public function transactions(): FinancialTransaction
    {
        return FinancialTransaction::where('from_wallet_id', $this->id)
            ->orWhere('to_wallet_id', $this->id);
    }

    public function scopeYayasan(Builder $query): Builder
    {
        return $query->where('wallet_code', 'YAYASAN');
    }

    public function scopeIncome(Builder $query): Builder
    {
        return $query->where('wallet_code', 'INCOME');
    }

    public function scopeExpense(Builder $query): Builder
    {
        return $query->where('wallet_code', 'EXPENSE');
    }

    public function scopeDanaBos(Builder $query): Builder
    {
        return $query->where('wallet_code', 'DANA_BOS');
    }

    public function scopeSystem(Builder $query): Builder
    {
        return $query->where('wallet_code', 'SYSTEM');
    }
}
