<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
