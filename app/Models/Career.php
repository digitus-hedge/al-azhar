<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * File: app/Models/Career.php
 *
 * @property int    $id
 * @property string $title
 * @property string $description
 * @property int    $sort_order
 * @property bool   $is_active
 */
class Career extends Model
{
    use HasFactory;

    protected $table = 'careers';

    protected $fillable = [
        'title',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active'  => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
