<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditCard extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'cardName', //Pilihan merek nama credit card yaitu visa, mastercard, dan jcb
        'cardNumber',
        'isActive',
        'expiredDate',
        'cvv',
        'amount',
        'user_id',
    ];

    protected $hidden = [
        'cardNumber',
        'expiredDate',
        'cvv',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
};