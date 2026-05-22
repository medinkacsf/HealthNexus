<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;

    protected $fillable = ['paciente_id', 'monto_autorizado_seguro', 'credito_consumido', 'estatus'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function consumos()
    {
        return $this->hasMany(ConsumoInsumoEnfermeria::class);
    }
}