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
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
                    ->withTimestamps()
                    ->withPivot(['active']);
    }

    /**
     * Cek apakah user punya role tertentu (bisa satu atau lebih)
     *
     * Contoh:
     * - $user->hasRole('Admin')
     * - $user->hasRole(['Admin', 'Kader'])
     */
    public function hasRole($roleName): bool
    {
        if (is_array($roleName)) {
            return $this->roles()->whereIn('nama', $roleName)->exists();
        }

        return $this->roles()->where('nama', $roleName)->exists();
    }
}
