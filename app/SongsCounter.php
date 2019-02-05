<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongsCounter extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'song_counter';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['song_id'];

    
}
