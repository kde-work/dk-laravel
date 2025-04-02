<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiltersType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'validation'];

    public function filters()
    {
        return $this->hasMany(Filter::class);
    }
}
