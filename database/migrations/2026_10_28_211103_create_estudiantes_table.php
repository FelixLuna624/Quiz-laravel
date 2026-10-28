<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('carne')->unique();
            $table->string('nombre');
            $table->string('apellidos');

            // Relación 1 a N: Cada estudiante tiene un único profesor consejero
            $table->foreignId('docente_id')
                  ->constrained('docentes')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
