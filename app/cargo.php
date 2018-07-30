<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cargo extends Model
{
    protected $fillable = ['nombre','estado'];
    protected $table = 'cargo';
    protected $primaryKey = 'id_ca';
}
