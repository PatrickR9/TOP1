<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetGroupType extends Model
{
    protected $guarded = [];

    public function targetGroups()
    {
        return $this->hasMany(TargetGroup::class);
    }
}
