<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * File: app/Models/Academic.php
 *
 * Represents an academic level shown on the website
 * (Preschool, LKG and UKG, Primary Level, Secondary Level, Senior Secondary Level).
 *
 * @property int    $id
 * @property string $name
 * @property string|null $subtitle
 * @property string $description
 * @property string|null $icon
 * @property int    $sort_order
 * @property bool   $is_active
 */
class Academic extends Model
{
    use HasFactory;

    protected $table = 'academics';

    protected $fillable = [
        'name',
        'subtitle',
        'description',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active'  => 'boolean',
    ];

    /* ---------- Scopes ---------- */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
