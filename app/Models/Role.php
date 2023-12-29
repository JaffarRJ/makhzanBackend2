<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'permissions'
    ];
    /**
     * Get all of the users for the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    /**
     * The permissions that belong to the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, RolePermission::class, 'role_id', 'permission_id')->withPivot('action');
    }

    /**
     * Get all of the rolePermissions for the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rolePermissions(): HasMany
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }

}
