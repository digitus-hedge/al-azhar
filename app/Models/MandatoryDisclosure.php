<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class MandatoryDisclosure extends Model
{
    use SoftDeletes, LogsActivity;

    protected string $activityModule = 'Mandatory Disclosure';
    protected string $activityLabel  = 'title';
    protected array  $activityIgnore = ['file_size', 'original_name'];

    /** Groups shown on the website (CBSE mandatory public disclosure format). */
    // public const CATEGORIES = [
    //     'general'   => 'General Information',
    //     'documents' => 'Documents & Certificates',
    //     'academics' => 'Results & Academics',
    //     'staff'     => 'Staff (Teaching)',
    //     'infra'     => 'School Infrastructure',
    // ];

    // public const CATEGORY_ICONS = [
    //     'general'   => 'bi-info-circle',
    //     'documents' => 'bi-patch-check',
    //     'academics' => 'bi-mortarboard',
    //     'staff'     => 'bi-people',
    //     'infra'     => 'bi-building',
    // ];

    protected $fillable = [
        'title',  'file', 'original_name', 'file_size',
        'issued_by', 'issue_date', 'valid_until', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'issue_date'  => 'date',
        'valid_until' => 'date',
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
        'file_size'   => 'integer',
    ];

    /* ---------- Scopes ---------- */

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('title');
    }

    /* ---------- Accessors ---------- */

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst((string) $this->category);
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file ? Storage::url($this->file) : null;
    }

    /** e.g. "1.24 MB" */
    public function getFileSizeLabelAttribute(): string
    {
        if (! $this->file_size) {
            return '';
        }

        return $this->file_size >= 1048576
            ? number_format($this->file_size / 1048576, 2) . ' MB'
            : number_format($this->file_size / 1024) . ' KB';
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->valid_until !== null && $this->valid_until->lt(today());
    }

    /** Expires within the next 30 days (and not already expired). */
    public function getIsExpiringSoonAttribute(): bool
    {
        return $this->valid_until !== null
            && ! $this->is_expired
            && $this->valid_until->lte(today()->addDays(30));
    }
}
