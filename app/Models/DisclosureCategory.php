<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisclosureCategory extends Model
{
    use SoftDeletes;

    protected $table = 'disclosure_categories';

    protected $fillable = ['name'];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /* ---------- Relations ---------- */

    /** Documents in this category (mandatory_disclosures.category = this id). */
    public function documents(): HasMany
    {
        return $this->hasMany(MandatoryDisclosure::class, 'category');
    }

    /** Only the documents shown on the website, in display order. */
    public function activeDocuments(): HasMany
    {
        return $this->documents()->active()->ordered();
    }

    /* ---------- Scopes ---------- */

    /** Search by name: DisclosureCategory::search('fire')->get() */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        return $term === ''
            ? $query
            : $query->where('name', 'like', '%' . $term . '%');
    }

    /* ---------- Helpers ---------- */

    /** Dropdown helper for the Mandatory Disclosure form: [id => name] */
    public static function options(): array
    {
        return static::query()->orderBy('name')->pluck('name', 'id')->all();
    }
}