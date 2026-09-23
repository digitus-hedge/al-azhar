<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\LogsActivity;
class Department extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'department_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
        /**
     * All staff members in this department.
     */
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}
