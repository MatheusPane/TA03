<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel roles (many-to-many)
     */
// app/Models/User.php

// app/Models/User.php

public function roles()
{
    return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
                ->withTimestamps()
                ->withPivot('active');
}

public function hasRole($roleName): bool
{
    $roleNames = is_array($roleName) ? $roleName : [$roleName];

    // GUNAKAN PROPERTY YANG SUDAH DI-LOAD!
    return $this->roles
        ->whereIn('nama', $roleNames)
        ->where('pivot.active', 1)
        ->isNotEmpty();
}
}
