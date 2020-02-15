<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeEpisodes extends Model
{
    protected $fillable = ['user_id','episodes_id','case'];

}
