<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManagementMember extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'management_members';

    protected string $activityModule = 'School Management';
    protected string $activityLabel  = 'name';

    /**
     * Seniority used ONLY to order profiles automatically.
     * If the selected designation's name matches one of these (any case), it gets that rank;
     * any other designation comes after these, sorted by name.
     */
    public const HIERARCHY = [
        'chairman', 'chairperson', 'vice chairman', 'president', 'vice president',
        'managing trustee', 'secretary', 'joint secretary', 'treasurer', 'correspondent',
        'manager', 'director', 'trustee', 'principal', 'vice principal', 'headmistress',
        'headmaster', 'academic coordinator', 'member',
    ];

    protected $fillable = [
        'name', 'designation_id', 'photo', 'bio', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'designation_id' => 'integer',
        'is_active'      => 'boolean',
        'sort_order'     => 'integer',
    ];

    /* ---------- Relations ---------- */

    /** withTrashed: the profile keeps its designation name even if the designation is later deleted. */
    public function designation(): BelongsTo
    {
        return $this->belongsTo(ManagementDesignation::class, 'designation_id')->withTrashed();
    }

    /* ---------- Scopes ---------- */

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('name');
    }

    /* ---------- Hierarchy ---------- */

    /** 0 = most senior. Unknown designations come after all known ones. */
    public static function rankOf(?string $designationName): int
    {
        $key = Str::lower(trim(preg_replace('/\s+/', ' ', (string) $designationName)));
        $i   = array_search($key, self::HIERARCHY, true);

        return $i === false ? count(self::HIERARCHY) : $i;
    }

    public function getDesignationRankAttribute(): int
    {
        return self::rankOf($this->designation_name);
    }

    /* ---------- Accessors ---------- */

    /** Designation name from management_designations, e.g. "Chairman". */
    public function getDesignationNameAttribute(): string
    {
        return $this->designation?->name ?? '—';
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }

    /** "Dr. Ahmed Khan" -> "AK" (skips titles like Dr., Mr., Mrs., Prof.) */
    public function getInitialsAttribute(): string
    {
        $words = collect(preg_split('/\s+/', trim((string) $this->name)))
            ->reject(fn ($w) => in_array(strtolower(rtrim($w, '.')), ['dr', 'mr', 'mrs', 'ms', 'prof', 'rev', 'adv', 'er'], true))
            ->values();

        return Str::upper(
            mb_substr($words->first() ?? '?', 0, 1) . ($words->count() > 1 ? mb_substr($words->last(), 0, 1) : '')
        );
    }
}
