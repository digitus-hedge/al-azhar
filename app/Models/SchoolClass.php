<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\LogsActivity;
/**
 * Named SchoolClass (not Class) because "Class" is a reserved word in PHP.
 * Still uses the "classes" table.
 */
class SchoolClass extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'code',
        'department_id',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
