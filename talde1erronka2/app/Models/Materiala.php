<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiala extends Model
{
    protected $table = 'materiala';
    public $timestamps = false;

    protected $fillable = [
        'etiketa',
        'izena',
        'sortze_data',
        'eguneratze_data',
        'ezabatze_data'
    ];

    public function erabilis()
    {
        return $this->hasMany(MaterialaErabili::class, 'id_materiala');
    }
}
