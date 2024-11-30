<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Editorial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function contents(): HasMany
    {
        return $this->HasMany(Content::class);
    }
    public function organisation(): BelongsTo
    {
        return $this->BelongsTo(Organisation::class);
    }

}
