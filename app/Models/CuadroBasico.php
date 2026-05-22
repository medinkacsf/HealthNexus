<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuadroBasico extends Model
{
    use HasFactory;
protected $table = 'cuadro_basico';
    protected $fillable = ['codigo_barras', 'nombre_medicamento', 'requiere_nivel_minimo', 'costo_unitario', 'es_controlado'];

    public function consumos()
    {
        return $this->hasMany(ConsumoInsumoEnfermeria::class);
    }
}
