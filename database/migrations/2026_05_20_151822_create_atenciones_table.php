<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('atenciones', function (Blueprint $table) {
            $table->id();
            
            // CORRECCIÓN: Usamos 'integer' simple para que coincida con el INT de citas_whatsapp
            $table->integer('cita_id'); 
            $table->foreign('cita_id')->references('id')->on('citas_whatsapp')->onDelete('cascade');
            
            // Asumimos que users.id es estándar de Laravel (bigint unsigned), 
            // pero si falla, cambialo por ->integer('medico_id')
            $table->foreignId('medico_id')->constrained('users');
            
            $table->string('paciente_nombre');
            
            // Signos Vitales
            $table->string('presion_arterial')->nullable();
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->integer('frecuencia_respiratoria')->nullable();
            $table->decimal('temperatura', 4, 1)->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('talla', 5, 2)->nullable();
            $table->integer('spo2')->nullable();
            
            // Consulta
            $table->text('motivo_consulta');
            $table->text('exploracion_fisica')->nullable();
            $table->text('diagnostico');
            $table->string('cie10')->nullable();
            $table->text('receta_medica')->nullable();
            $table->text('indicaciones')->nullable();
            $table->text('notas_medicas')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atenciones');
    }
};
