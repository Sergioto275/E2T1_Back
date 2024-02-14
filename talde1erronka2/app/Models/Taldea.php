<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taldea extends Model
{
    // use HasFactory;
    protected $table = 'taldea';
    protected $primaryKey = 'kodea';
    public function getKeyType()
    {
        return 'string';
    }
    public $timestamps = false;
}
