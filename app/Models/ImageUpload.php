<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageUpload extends Model
{
    protected $fillable = [
        'path',
        'formats',
        'processed'
    ];

    protected $casts = [
        'formats' => 'array',
        'processed' => 'boolean'
    ];
}
