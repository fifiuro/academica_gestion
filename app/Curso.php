<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['codigo','nombre','duracion','nom_corto','categoria','estado'];
    protected $table = 'curso';
    protected $primaryKey = 'id_cu';
    public $timestamps = false;
}
