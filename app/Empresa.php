<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = ['razon_social','sigla'];
    protected $table = 'empresa';
    protected $primaryKey = 'id_em';
    public $timestamps = true;
}
