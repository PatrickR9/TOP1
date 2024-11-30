<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganisationCategory extends Model
{
    use HasFactory;
    public function content_has_organisation_categories(): HasMany
    {
        return $this->HasMany(ContentHasOrganisationCategories::class);
    }
    public function organisation(): BelongsTo
    {
        return $this->BelongsTo(Organisation::class);
    }
}
