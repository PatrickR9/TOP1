<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Content2MetaField extends Model
{
    protected $guarded = [];
    
    use HasFactory;
    public function content(): HasOne
    {
        return $this->HasOne(Content::class);
    }
    public function content_meta_field(): HasOne
    {
        return $this->HasOne(ContentMetaField::class);
    }

}
