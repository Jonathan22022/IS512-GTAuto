<?php
//Cart.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembeli_id',  // ID of the buyer (user with role 'user')
        'product_id', //menampung multiple ObjectID dari products
        'name',
        'price',
        'quantity',
        'gambar',
        'user_id',     // ID of the seller (user with role 'penjual')
        'created_at',
        'updated_at'
    ];

    // Relationship with buyer
    public function pembeli()
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }

    // Relationship with product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relationship with seller
    public function penjual()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
