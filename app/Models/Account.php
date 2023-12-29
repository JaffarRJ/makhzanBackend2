<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Account extends Model
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
    public function sub_accounts(): BelongsToMany
    {
        return $this->belongsToMany(SubAccount::class, 'account_sub_accounts', 'account_id', 'sub_account_id')->withPivot('id');
    }
}
