<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicType extends Model
{
    protected $guarded = [];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
