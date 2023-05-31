<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    const PAYMENT_STATUS = [
        'Started',
        'Pending',
        'Completed',
        'Failed'
    ];
    const ORDER_STATUS = [
        'Placed',
        'Completed',
        'Pending',
        'Cancelled',
        'Failed',
        'Rejected'
    ];


    protected function total(): Attribute{
        return Attribute::make(get: fn (string $value) => number_format($value, 2));
    }

    protected function subtotal(): Attribute{
        return Attribute::make(get: fn (string $value) => number_format($value, 2));
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function orderDetail(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
