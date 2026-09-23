<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;

class About extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'abouts';

    protected $fillable = [
        'title',
        'description',
        'vision',
        'mission',
        'history',
        'values',
        'image',
        'meta_title',
        'meta_description',
    ];
}
