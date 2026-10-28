<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'carne',
        'nombre',
        'apellidos',
        'docente_id',
    ];

    // Relación N a 1: Cada estudiante tiene un único profesor consejero
    public function consejero()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    // Relación N a M mediante la clase asociativa
    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'estudiante_matriculados')
                    ->using(EstudianteMatriculado::class)
                    ->withPivot('nota')
                    ->withTimestamps();
    }

    // Acceso directo a los registros de matricula
    public function matriculas()
    {
        return $this->hasMany(EstudianteMatriculado::class);
    }
}
