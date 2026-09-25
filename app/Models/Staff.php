<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'designation_id',   // was 'designation' (text) → now management_designations.id (type = staff)
        'department_id',
        'class_id',
        'description',
        'photo',
        'is_head_of_staff',
        'show_on_home',
        'has_login',
        'user_id',
        'sort_order',
    ];

    protected $casts = [
        'designation_id'   => 'integer',
        'is_head_of_staff' => 'boolean',
        'show_on_home'     => 'boolean',
        'has_login'        => 'boolean',
        'sort_order'       => 'integer',
    ];

    /* ---------- Relations ---------- */

    /**
     * The staff designation (Master > Designations, type = staff).
     * withTrashed: keeps showing the name even if the designation is deleted later.
     */
    public function staffDesignation(): BelongsTo
    {
        return $this->belongsTo(ManagementDesignation::class, 'designation_id')->withTrashed();
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * The login account for this staff member (only present when
     * has_login is enabled).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* ---------- Accessors ---------- */

    /**
     * Designation NAME, e.g. "Principal".
     * Keeps every existing view working: {{ $staff->designation }} still prints the name,
     * even though the table now stores designation_id.
     */
    public function getDesignationAttribute(): string
    {
        return $this->staffDesignation?->name ?? '';
    }

    /* ---------- Scopes ---------- */

    public function scopeHeadOfStaff($query)
    {
        return $query->where('is_head_of_staff', true);
    }

    public function scopeShownOnHome($query)
    {
        return $query->where('show_on_home', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeInDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /** Staff with a given designation: Staff::withDesignation($id)->get() */
    public function scopeWithDesignation($query, $designationId)
    {
        return $query->where('designation_id', $designationId);
    }
}