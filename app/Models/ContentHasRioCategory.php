<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentHasRioCategory extends Model
{
    use HasFactory;
    public function content(): BelongsTo
    {
        return $this->BelongsTo(Content::class);
    }
    public function rio_category(): BelongsTo
    {
        return $this->BelongsTo(RioCategory::class);
    }
}
