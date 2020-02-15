<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeriesTv extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function Episode(): HasMany
    {
        return $this->hasMany(Episode::class,'seriesTv_id');
    }
    public function FollowSeries(): HasMany
    {
        return $this->hasMany(FollowSeries::class,'seriesTv_id');
    }
}
