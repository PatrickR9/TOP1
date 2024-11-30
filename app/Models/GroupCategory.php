<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupCategory extends Model
{
    use HasFactory;
    public function content_group(): BelongsTo
    {
        return $this->BelongsTo(Team::class);
    }    
    public function content_has_group_categories(): HasMany
    {
        return $this->HasMany(ContentHasGroupCategory::class);
    }
}
