<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'jumlahBarang',
        'gambar',
        'price',
        'description',
        'type',
        'user_id', // Foreign key ke User (Penjual)
    ];

    /**
     * Relasi Produk dengan User (Produk dimiliki oleh satu Penjual)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }
}
