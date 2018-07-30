<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombre','apellidos','ci','expedido','celular','email'];
    protected $table = 'persona';
    protected $primaryKey = 'id_pe';
}
