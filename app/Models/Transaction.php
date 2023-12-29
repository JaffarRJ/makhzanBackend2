<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    /**
     * The party that belong to the Party
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parties(): BelongsToMany
    {
        return $this->belongsToMany(Party::class, 'party_transactions', 'transaction_id', 'party_id')->withPivot('id');
    }
}
