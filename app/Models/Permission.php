<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        'tab_name',
        'name',
        'route'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get all of the comments for the Permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getActions($id): HasMany
    {
        return $this->hasMany(RolePermission::class, 'permission_id')->where('role_id', $id)->pluck('action')->toArray();
    }
}
