<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre','nivel'];
    protected $table = 'categoria';
    protected $primaryKey = 'id_cat';
    public $timestamps = false;
}
