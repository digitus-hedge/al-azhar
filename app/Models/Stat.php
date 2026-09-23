<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;
class Stat extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'stats';

    protected $fillable = [
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}