<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumoInsumoEnfermeria extends Model
{
    use HasFactory;

    protected $fillable = ['ingreso_id', 'cuadro_basico_id', 'enfermera_id', 'cantidad'];

    public function ingreso()
    {
        return $this->belongsTo(Ingreso::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(CuadroBasico::class, 'cuadro_basico_id');
    }

    public function enfermera()
    {
        return $this->belongsTo(User::class, 'enfermera_id');
    }
}