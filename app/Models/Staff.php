<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'designation',
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
        'is_head_of_staff' => 'boolean',
        'show_on_home'      => 'boolean',
        'has_login'         => 'boolean',
        'sort_order'        => 'integer',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
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
}
