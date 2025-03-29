<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageUpload extends Model
{
    protected $fillable = [
        'path',
        'processed_paths',
        'processed',
    ];

    protected $casts = [
        'processed_paths' => 'array',
        'processed' => 'boolean',
    ];
}
