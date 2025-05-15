<?php
//Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembeli_id',
        'user_id',
        'product_id',
        'quantity',
        'subtotal',
        'shipping_method',
        'shipping_cost',
        'total',
        'payment_id',
        'payment_type',
        'status'
    ];
};