<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    const UPLOAD_PATH = "uploads/pages";

    protected $fillable = [
        'title',
        'description',
        'seo description',
        'seo keywords',
        'image',
        'status',
        'action'
    ];
}
