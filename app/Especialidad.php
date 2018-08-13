<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $fillable = ['id_cu','id_ins'];
    protected $table = 'especialidad';
    protected $primaryKey = 'id_esp';
    public $timestamps = true;
}