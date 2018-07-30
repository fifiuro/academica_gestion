<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = ['nombre','sigla'];
    protected $table = 'departamento';
    protected $primaryKey = 'id_dep';
}
