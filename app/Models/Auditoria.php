<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // Namespace oficial nuevo

class Auditoria extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'auditoria';

    protected $fillable = [
        'user_id',
        'user_name',
        'accion',
        'modulo',
        'descripcion',
        'ip_address',
        'datos_nuevos'
    ];
}
