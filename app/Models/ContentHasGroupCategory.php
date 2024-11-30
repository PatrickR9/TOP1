<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentHasGroupCategory extends Model
{
    use HasFactory;
    public function content(): BelongsTo
    {
        return $this->BelongsTo(Content::class);
    }
    public function group_category(): BelongsTo
    {
        return $this->BelongsTo(GroupCategory::class);
    }
}
