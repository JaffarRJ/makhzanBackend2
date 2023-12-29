<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Party extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cnic',
        'phone',
        'address'
    ];

    /**
     * The transaction that belong to the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'party_transactions', 'party_id', 'transaction_id')->withPivot('id');
    }
}
