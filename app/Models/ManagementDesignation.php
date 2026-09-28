<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Master > Designations
 * One list for both forms, split by type:
 *   - management → School Management profile form (Chairman, Secretary, Trustee, ...)
 *   - staff      → Staff form (Principal, PGT, TGT, Librarian, ...)
 */
class ManagementDesignation extends Model
{
    use SoftDeletes;

    protected $table = 'management_designations';

    /** Designation types shown in the "Designation Type" dropdown. */
    public const TYPES = [
        'management' => 'Management Designation',
        'staff'      => 'Staff Designation',
    ];

    protected $fillable = ['name', 'type'];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /* ---------- Relations ---------- */

    /** School Management profiles that use this designation. */
    public function members(): HasMany
    {
        return $this->hasMany(ManagementMember::class, 'designation_id');
    }

    /**
     * Staff members that use this designation.
     * Change Staff::class if your staff model has a different name (e.g. StaffMember::class).
     */
    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class, 'designation_id');
    }

    /* ---------- Scopes ---------- */

    /** Search by name: ManagementDesignation::search('sec')->get() */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }
        // abc

        $lower = mb_strtolower($term);

        // Match against type keys and labels, e.g. "man" / "management" → management, "staff" → staff
        $typeMatches = collect(self::TYPES)
            ->filter(fn($label, $key) => str_contains(mb_strtolower($label), $lower)
                || str_contains(mb_strtolower($key), $lower))
            ->keys()
            ->all();

        return $query->where(function ($q) use ($term, $typeMatches) {
            $q->where('name', 'like', '%' . $term . '%');

            if (! empty($typeMatches)) {
                $q->orWhereIn('type', $typeMatches);
            }
        });
    }

    /** Filter by type: ManagementDesignation::ofType('staff')->get(). Null or unknown = all. */
    public function scopeOfType(Builder $query, ?string $type): Builder
    {
        return $type && array_key_exists($type, self::TYPES)
            ? $query->where('type', $type)
            : $query;
    }

    /** ManagementDesignation::management()->get() */
    public function scopeManagement(Builder $query): Builder
    {
        return $query->where('type', 'management');
    }

    /** ManagementDesignation::staffType()->get() */
    public function scopeStaffType(Builder $query): Builder
    {
        return $query->where('type', 'staff');
    }

    /* ---------- Accessors ---------- */

    /** "Management Designation" / "Staff Designation" */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst((string) $this->type);
    }

    /* ---------- Helpers ---------- */

    /** Used by any School Management profile or Staff member? (blocks delete and type change) */
    public function isInUse(): bool
    {
        return $this->members()->exists() || $this->staff()->exists();
    }

    /**
     * Dropdown helper: [id => name]
     *   ManagementDesignation::options()             → all
     *   ManagementDesignation::options('management') → School Management form
     *   ManagementDesignation::options('staff')      → Staff form
     */
    public static function options(?string $type = null): array
    {
        return static::query()->ofType($type)->orderBy('name')->pluck('name', 'id')->all();
    }
}
