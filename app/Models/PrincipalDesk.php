<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PrincipalDesk extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading',
        'name',
        'photo',
        'avatar_initial',
        'excerpt',
        'message',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope: only active records, ordered for display.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Full public URL to the photo, if any.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    /**
     * Fallback initial for the circular avatar when no photo is set.
     */
    public function getInitialAttribute(): string
    {
        if ($this->avatar_initial) {
            return strtoupper($this->avatar_initial);
        }

        return Str::substr($this->name ?? $this->heading, 0, 1) ?: 'P';
    }
}
