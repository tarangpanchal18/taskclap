<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'order_detail_id',
        'rating',
        'comment',
        'status',
    ];

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }
}
