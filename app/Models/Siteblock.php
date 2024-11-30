<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siteblock extends Model
{
    use HasFactory;
    use SoftDeletes; 

    protected $guarded = [];

    public function content(): BelongsTo
    {
        return $this->BelongsTo(Content::class);
    }
    public function usersite(): BelongsTo
    {
        return $this->BelongsTo(Usersite::class);
    }

}
