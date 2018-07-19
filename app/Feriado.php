<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feriado extends Model
{
    protected $fillable = ['nombre'];
    protected $table = 'feriado';
    protected $primaryKey = 'id_fer';
    public $timestamps = false;
}
