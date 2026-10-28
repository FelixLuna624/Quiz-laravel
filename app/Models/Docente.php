<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $fillable = [
        'codEmpleado',
        'nombreEmpleado',
        'apellidosEmpleado',
    ];

    // Relación 1 a N: Un docente es consejero de muchos estudiantes
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'docente_id');
    }

    // Relación N a M: Un docente puede impartir varios grupos (1..2 docentes por grupo)
    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'docente_grupo');
    }
}
