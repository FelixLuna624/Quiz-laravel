<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EstudianteMatriculado extends Pivot
{
    use HasFactory;

    protected $table = 'estudiante_matriculados';

    public $incrementing = true;

    protected $fillable = [
        'grupo_id',
        'estudiante_id',
        'nota',
    ];

    // Relación con el Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    // Relación con el Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
