<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountSubAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_id',
        'sub_account_id'
    ];

    /**
     * The transaction that belong to the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * The transaction that belong to the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subAccount(): BelongsTo
    {
        return $this->belongsTo(SubAccount::class, 'sub_account_id', 'id');
    }
}
