<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class MandatoryDisclosure extends Model
{
    use SoftDeletes, LogsActivity;

    protected string $activityModule = 'Mandatory Disclosure';
    protected string $activityLabel  = 'title';
    protected array  $activityIgnore = ['file_size', 'original_name'];

    /**
     * @deprecated Categories now come from the disclosure_categories table.
     * Kept only so the migration can map old keys to category rows.
     * Delete this after running `php artisan migrate`.
     */
  

    protected $fillable = [
        'title', 'category', 'file', 'original_name', 'file_size',
        'issued_by', 'issue_date', 'valid_until', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'category'    => 'integer',   // disclosure_categories.id
        'issue_date'  => 'date',
        'valid_until' => 'date',
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
        'file_size'   => 'integer',
    ];

    /* ---------- Relations ---------- */

    /**
     * The category row. The column `category` holds the id, so the relation
     * has a different name: use $doc->disclosureCategory->name.
     * withTrashed(): documents keep showing their category name even if
     * that category is later soft-deleted.
     */
    public function disclosureCategory(): BelongsTo
    {
        return $this->belongsTo(DisclosureCategory::class, 'category')->withTrashed();
    }

    /* ---------- Scopes ---------- */

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('title');
    }

    /** MandatoryDisclosure::inCategory($id)->get() */
    public function scopeInCategory(Builder $q, ?int $categoryId): Builder
    {
        return $categoryId ? $q->where('category', $categoryId) : $q;
    }

    /* ---------- Accessors ---------- */

    /** Category name from disclosure_categories, e.g. "Fire Safety". */
    public function getCategoryLabelAttribute(): string
    {
        return $this->disclosureCategory?->name ?? '—';
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