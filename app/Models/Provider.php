<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;

    const UPLOAD_PATH = "uploads/provider";
    const UPLOAD_PATH_DOC = "uploads/provider/documents";

    protected function categoryId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    protected $fillable = [
        'category_id',
        'name',
        'email',
        'phone',
        'address',
        'image',
        'id_proof',
        'vehicle_number',
        'notes',
        'status',
    ];
}
