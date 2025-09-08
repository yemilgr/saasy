<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    public const Admin = 'admin';
    public const User = 'user';
}
