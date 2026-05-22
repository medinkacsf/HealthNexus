<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('tipo')->after('action')->default('accion');
            $table->text('descripcion')->after('tipo')->nullable();
            $table->string('navegador')->after('ip_address')->nullable();
            $table->boolean('exitoso')->after('navegador')->default(true);
        });
    }

    public function down()
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn(['tipo', 'descripcion', 'navegador', 'exitoso']);
        });
    }
};
