<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Citas extends Model
{
    protected $table = 'citas';
    
    static $rules = [
    ];

    protected $fillable = ['id','id_doctor','id_usuario','nota','fecha','estado'];
}
