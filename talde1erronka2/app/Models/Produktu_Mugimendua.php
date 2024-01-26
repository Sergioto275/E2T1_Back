<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produktu_Mugimendua extends Model
{
    protected $table = 'produktu_mugimendua';
    public $timestamps = false;

    protected $fillable = [
        'izena',
        'id_produktua',
        'id_langilea',
        'data',
        'kopurua',
        'sortze_data',
        'eguneratze_data',
        'ezabatze_data'
    ];
}
