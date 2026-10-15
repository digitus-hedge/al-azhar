<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * File: app/Models/Curriculum.php
 */
class Curriculum extends Model
{
    use HasFactory;

    // Explicit table name — Laravel would otherwise guess "curricula"
    // (the Latin plural), but the actual table is "curriculums".
    protected $table = 'curriculums';

    protected $fillable = [
        'title',
        'description',
        'image',       // keep for legacy if your old column still exists
        'images',      // ← MUST be present for multi-image saves to work
        'is_active',
    ];

    protected $casts = [
        'images'    => 'array',    // ← MUST be here so Laravel converts PHP array ↔ JSON automatically
        'is_active' => 'boolean',
    ];
}