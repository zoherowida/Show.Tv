<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;
use App\Enums\StateSeriesTv;
class FollowSeries extends Model
{
    protected $fillable = ['user_id','seriesTv_id','case'];

    public function SeriesTv(): HasOne
    {
        return $this->hasOne(SeriesTv::class,'seriesTv_id');
    }

}
