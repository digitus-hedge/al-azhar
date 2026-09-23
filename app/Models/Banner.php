<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;   // ← this import

class Banner extends Model
{
    use HasFactory,LogsActivity;

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
