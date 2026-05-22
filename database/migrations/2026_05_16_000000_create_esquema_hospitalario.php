<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PACIENTES
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('curp')->unique();
            $table->string('seguro_id');

            $table->enum('estatus', [
                'Activo',
                'Alta'
            ])->default('Activo');

            $table->text('archivo')->nullable();

            $table->timestamps();
        });


        // ACCESOS IoT
        Schema::create('accesos_iot', function (Blueprint $table) {
            $table->id();

            $table->string('area');
            $table->string('evento');

            $table->timestamps();
        });


        // CUADRO BASICO
        Schema::create('cuadro_basico', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_barras')->unique();
            $table->string('nombre_medicamento');

            $table->enum(
                'requiere_nivel_minimo',
                ['A','B','C']
            )->default('C');

            $table->decimal(
                'costo_unitario',
                10,
                2
            )->default(0);

            $table->boolean(
                'es_controlado'
            )->default(false);

            $table->text('archivo')->nullable();

            $table->timestamps();
        });


        // INGRESOS
        Schema::create('ingresos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('paciente_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->decimal(
                'monto_autorizado_seguro',
                10,
                2
            );

            $table->decimal(
                'credito_consumido',
                10,
                2
            )->default(0);

            $table->enum(
                'estatus',
                [
                    'Abierto',
                    'Archivo Bye Bye',
                    'Cerrado'
                ]
            )->default('Abierto');

            $table->text('archivo')->nullable();

            $table->timestamps();
        });


        // CONSUMO ENFERMERIA
        Schema::create('consumo_enfermeria', function (Blueprint $table){

            $table->id();

            $table->foreignId('ingreso_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('insumo');

            $table->integer('cantidad');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('consumo_enfermeria');
        Schema::dropIfExists('ingresos');
        Schema::dropIfExists('cuadro_basico');
        Schema::dropIfExists('accesos_iot');
        Schema::dropIfExists('pacientes');
    }
};