<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtistCounter extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artist_counter';

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
    protected $fillable = ['artist_id'];

    
}
