<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionEnquiry extends Model
{
    use SoftDeletes, LogsActivity;

    protected string $activityModule = 'Admission Enquiries';
    protected string $activityLabel  = 'student_name';
    protected array  $activityIgnore = ['ip_address'];

   public const STATUSES = [
    'new'        => 'New',
    'contacted'  => 'Contacted',
    'in_process' => 'In Process',
    'admitted'   => 'Admitted',
];

public const STATUS_ICONS = [
    'new'        => 'bi-envelope-fill',
    'contacted'  => 'bi-telephone-fill',
    'in_process' => 'bi-hourglass-split',
    'admitted'   => 'bi-check-circle-fill',
];

    protected $fillable = [
        'student_name', 'parent_name', 'parent_phone', 'parent_email',
        'grade', 'needs_hostel', 'message',
        'status', 'admin_notes', 'contacted_at', 'ip_address',
    ];

    protected $casts = [
        'needs_hostel' => 'boolean',
        'contacted_at' => 'datetime',
    ];

    /* ---------- Filters ---------- */

    public function scopeFilter(Builder $q, array $f): Builder
    {
        return $q
            ->when($f['q'] ?? null, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('student_name', 'like', "%{$search}%")
                      ->orWhere('parent_name', 'like', "%{$search}%")
                      ->orWhere('parent_phone', 'like', "%{$search}%")
                      ->orWhere('parent_email', 'like', "%{$search}%")
                      ->orWhere('grade', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->when($f['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when(($f['hostel'] ?? null) !== null, fn ($q) => $q->where('needs_hostel', $f['hostel'] === 'yes'))
            ->when($f['grade'] ?? null, fn ($q, $v) => $q->where('grade', $v))
            ->when($f['from'] ?? null, fn ($q, $v) => $q->where('created_at', '>=', $v . ' 00:00:00'))
            ->when($f['to'] ?? null, fn ($q, $v) => $q->where('created_at', '<=', $v . ' 23:59:59'));
    }

    /* ---------- Accessors ---------- */

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }

    public function getStatusIconAttribute(): string
    {
        return self::STATUS_ICONS[$this->status] ?? 'bi-dot';
    }

    /** Digits only, with India code, for wa.me / tel: links. */
    public function getWhatsappNumberAttribute(): string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->parent_phone);

        return strlen($digits) === 10 ? '91' . $digits : ltrim($digits, '0');
    }
}
