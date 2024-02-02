<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiala_Erabili extends Model
{
    protected $table = 'materiala_erabili';
    public $timestamps = false;

    protected $fillable = [
        'id_materiala',
        'id_langilea',
        'hasiera_data',
        'amaiera_data',
        'sortze_data',
        'eguneratze_data',
        'ezabatze_data'
    ];

    public function materiala()
    {
        return $this->belongsTo(Materiala::class, 'id_materiala');
    }
}
