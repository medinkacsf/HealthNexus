<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atencion extends Model
{
    use HasFactory;
    
    protected $table = 'atenciones';
    
    protected $fillable = [
        'cita_id',
        'medico_id',
        'paciente_nombre',
        'ta',
        'fc',
        'fr',
        'temp',
        'peso',
        'talla',
        'spo2',
        'glucemia',
        'diagnostico',
        'cie10',
        'receta',
        'indicaciones',
        'estudios',
        'proxima_cita',
        'observaciones',
    ];
    
    protected $casts = [
        'receta' => 'array',
        'proxima_cita' => 'date',
    ];
    
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
    
    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }
}
