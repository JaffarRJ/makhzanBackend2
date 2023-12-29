<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartyTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'party_id',
        'transaction_id'
    ];

    /**
     * The transaction that belong to the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    /**
     * The transaction that belong to the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class, 'party_id', 'id');
    }
}
