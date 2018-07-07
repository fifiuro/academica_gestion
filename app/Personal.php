<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $fillable = ['id_pe','id_ca','estado'];
    protected $table = 'personal';
    protected $primaryKey = 'id_per';
}
