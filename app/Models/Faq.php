<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    const UPLOAD_PATH = "uploads/faq";

    protected $fillable = [
        'question',
        'answer',
        'status',
        'action'
    ];
}
