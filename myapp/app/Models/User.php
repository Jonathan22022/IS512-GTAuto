<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
     * Relasi User dengan Produk (Penjual memiliki banyak Produk)
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id', '_id');
    }
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'user_id');
    }
    public function tempatService(): HasMany
    {
        return $this->hasMany(TempatService::class, 'user_id');
    }
}
