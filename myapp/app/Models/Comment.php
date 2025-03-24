<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'gambar',
        'waktu',
        'rating',
        'job_id',
        'tempatService_id',
        'product_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function jobs(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
    public function tempatService(): BelongsTo
    {
        return $this->belongsTo(TempatService::class, 'tempatService_id');
    }
}
