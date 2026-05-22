<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = ['curp', 'seguro_id', 'estatus'];

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class);
    }
}