<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'promocode',
        'description',
        'disount_type',
        'validity',
        'start_date',
        'end_date',
        'type',
        'value',
        'limit',
        'status',
    ];
}
