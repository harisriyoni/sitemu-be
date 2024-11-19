<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function organisasis(): HasMany
    {
        return $this->hasMany(Organisasi::class, 'user_id', 'id');
    }

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class, 'user_id', 'id');
    }

    public function prestasis(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'user_id', 'id');
    }

    public function typegaleri(): HasMany
    {
        return $this->hasMany(Typegaleri::class, 'user_id', 'id');
    }
}
