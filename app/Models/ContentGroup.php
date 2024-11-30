<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class ContentGroup extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function editorial_has_content_groups(): HasMany
    {
        return $this->HasMany(EditorialHasContentGroup::class);
    }
    public function content_has_content_groups(): HasMany
    {
        return $this->HasMany(ContentHasContentGroup::class);
    }
    public function group_categories(): HasMany
    {
        return $this->HasMany(GroupCategories::class);
    }
}
