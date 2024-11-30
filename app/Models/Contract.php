<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contract extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function author_contracts(): HasMany
    {
        return $this->HasMany(AuthorContract::class);
    }
    public function organisation(): BelongsTo
    {
        return $this->BelongsTo(Organisation::class);
    }
}
