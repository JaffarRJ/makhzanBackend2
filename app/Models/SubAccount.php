<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'detail'
    ];

    /**
     * The transaction that belong to the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class, 'account_sub_accounts', 'sub_account_id', 'account_id')->withPivot('id');
    }
}
