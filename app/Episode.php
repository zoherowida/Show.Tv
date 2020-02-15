<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Episode extends Model
{
    use SoftDeletes;


    protected $dates = ['deleted_at'];

    public function SeriesTv(): HasOne
    {
        return $this->hasOne(SeriesTv::class,'id','seriesTv_id');
    }

    public function LikeEpisodes(): HasMany
    {
        return $this->hasMany(LikeEpisodes::class,'episodes_id');
    }


}
