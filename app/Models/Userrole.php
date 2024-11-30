<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Userrole extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    public function user2role(): HasMany
    {
        return $this->HasMany(User2role::class);
    }
}
