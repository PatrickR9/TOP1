<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ContentHasOrganisationCategory extends Model
{
    use HasFactory;
    public function organisation(): BelongsTo
    {
        return $this->BelongsTo(Organisation::class);
    }
    public function organisation_category(): BelongsTo
    {
        return $this->BelongsTo(OrganisationCategory::class);
    }

}
