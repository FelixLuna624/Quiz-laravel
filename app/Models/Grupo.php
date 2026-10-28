<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'numeroCiclo',
        'ano',
        'numeroGrupo',
        'abierto',
        'curso_id',
    ];

    protected $casts = [
        'abierto' => 'boolean',
    ];

    // Relación N a 1: Pertenece a un curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Relación N a M: Cada grupo puede ser impartido por 1 o 2 docentes
    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'docente_grupo');
    }

    // Relación N a M con Estudiantes mediante la tabla/modelo asociativo
    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_matriculados')
                    ->using(EstudianteMatriculado::class)
                    ->withPivot('nota')
                    ->withTimestamps();
    }

    // Acceso directo a las matrículas del grupo
    public function estudiantesMatriculados()
    {
        return $this->hasMany(EstudianteMatriculado::class);
    }
}
