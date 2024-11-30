<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Content extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    public function content2_meta_fields(): HasMany
    {
        return $this->HasMany(Content2MetaField::class)->orderBy('sort', 'asc');
    }
    public function content_has_rio_categories(): HasMany
    {
        return $this->HasMany(ContentHasRioCategory::class);
    }
    public function content_has_organisation_categories(): HasMany
    {
        return $this->HasMany(ContentHasOrganisationCategory::class);
    }
    public function content_has_group_categories(): HasMany
    {
        return $this->HasMany(ContentHasGroupCategory::class);
    }
    public function content_has_content_groups(): HasMany
    {
        return $this->HasMany(ContentHasContentGroup::class);
    }
    public function editorial(): BelongsTo
    {
        return $this->BelongsTo(Editorial::class);
    }
    public function organisation(): BelongsTo
    {
        return $this->BelongsTo(Organisation::class);
    }
    public function siteblocks(): HasMany
    {
        return $this->HasMany(Siteblock::class)->orderBy('sort', 'asc');
    }
    public function uservalue(): BelongsTo
    {
        return $this->BelongsTo(Uservalue::class);
    }

}
