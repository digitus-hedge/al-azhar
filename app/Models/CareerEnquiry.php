<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * File: app/Models/CareerEnquiry.php
 *
 * Matches the existing `career_enquiries` table:
 *   id, name, email, phone, nationality, career_id, apply_for, cv, message, timestamps
 */
class CareerEnquiry extends Model
{
    use HasFactory;

    protected $table = 'career_enquiries';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'nationality',
        'career_id',
        'apply_for',
        'cv',
        'message',
    ];

    /**
     * Related career (nullable — some submissions may not be linked).
     */
    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class);
    }
}
