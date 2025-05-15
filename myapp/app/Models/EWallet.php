<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EWallet extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'ewalletName',//pilihannya ada lima yaitu, ShoppeePay, OVO, DANA, LinkAja, dan GoPay
        'nomor_hp', //untuk nomor hp diambil dari collection users
        'isActive',
        'amount',
        'user_id',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}