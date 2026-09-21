<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'staff';

    protected $fillable = [
        'name',
        'designation',
        'department',
        'description',
        'photo',
        'is_head_of_staff',
        'sort_order',
    ];

    protected $casts = [
        'is_head_of_staff' => 'boolean',
        'sort_order'        => 'integer',
    ];

    /**
     * Scope: only heads of staff.
     */
    public function scopeHeadOfStaff($query)
    {
        return $query->where('is_head_of_staff', true);
    }

    /**
     * Scope: default display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Scope: filter by department.
     */
    public function scopeInDepartment($query, $department)
    {
        return $query->where('department', $department);
    }
}
