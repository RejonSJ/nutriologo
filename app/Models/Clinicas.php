<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Clinicas extends Model
{
    protected $table = 'clinicas';
    
    static $rules = [
    ];

    protected $fillable = ['id','nombre','direccion'];
}

?>