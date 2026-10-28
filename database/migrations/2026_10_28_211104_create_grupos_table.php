<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->integer('numeroCiclo');
            $table->integer('ano');
            $table->integer('numeroGrupo');
            $table->boolean('abierto')->default(true);

            // Relación con Curso (1 a N)
            $table->foreignId('curso_id')
                  ->constrained('cursos')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
