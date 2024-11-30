<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class EditorialHasContentGroup extends Model
{
    use HasFactory;

    public function editorial(): BelongsTo
    {
        return $this->BelongsTo(Editorial::class);
    }
    public function content_group(): BelongsTo
    {
        return $this->BelongsTo(ContentGroup::class);
    }
}
