<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthorContract extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function contract(): BelongsTo
    {
        return $this->BelongsTo(Contract::class);
    }
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
