<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\LogsActivity;

class HostelApplication extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'hostel_applications';

    protected $fillable = [
        'student_name',
        'age',
        'class_id',
        'class_name_snapshot',
        'gender',
        'parent_name',
        'parent_phone',
        'parent_email',
        'address',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'age' => 'integer',
    ];

    public const STATUSES = [
        'pending'   => 'Pending',
        'contacted' => 'Contacted',
        'approved'  => 'Approved',
        'rejected'  => 'Rejected',
    ];

    public const GENDERS = [
        'male'   => 'Male',
        'female' => 'Female',
        'other'  => 'Other',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}