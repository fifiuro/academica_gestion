<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = ['id_pe'];
    protected $table = 'instructor';
    protected $primaryKey = 'id_ins';
}
