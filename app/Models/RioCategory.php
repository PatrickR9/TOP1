<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RioCategory extends Model
{
    use HasFactory;
    public function content_has_rio_categories(): HasMany
    {
        return $this->HasMany(ContentHasRioCategories::class);
    }
}
