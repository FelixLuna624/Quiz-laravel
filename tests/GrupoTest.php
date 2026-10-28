<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\EstudianteMatriculado;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GrupoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_instancia_grupo_contiene_informacion_real_y_relaciones_completas()
    {
        // 1. Crear el Curso asociado
        $curso = Curso::create([
            'sigla' => 'IF6100',
            'nombreCurso' => 'Análisis & Diseño de Sistemas',
            'creditos' => 4,
        ]);

        // 2. Crear Docente Consejero y Docentes del grupo (1 a 2 docentes por regla de negocio)
        $docenteConsejero = Docente::create([
            'codEmpleado' => 1001,
            'nombreEmpleado' => 'Carlos',
            'apellidosEmpleado' => 'Mora Pérez',
        ]);

        $docenteGrupo1 = Docente::create([
            'codEmpleado' => 1002,
            'nombreEmpleado' => 'Ana',
            'apellidosEmpleado' => 'Rojas Solís',
        ]);

        $docenteGrupo2 = Docente::create([
            'codEmpleado' => 1003,
            'nombreEmpleado' => 'Luis',
            'apellidosEmpleado' => 'Gómez Valverde',
        ]);

        // 3. Crear Instancia de Grupo con datos reales
        $grupo = Grupo::create([
            'numeroCiclo' => 2,
            'ano' => 2026,
            'numeroGrupo' => 1,
            'abierto' => true,
            'curso_id' => $curso->id,
        ]);

        // Asignar los 2 docentes al grupo
        $grupo->docentes()->attach([$docenteGrupo1->id, $docenteGrupo2->id]);

        // 4. Crear un Estudiante
        $estudiante = Estudiante::create([
            'carne' => 'C34434',
            'nombre' => 'Félix',
            'apellidos' => 'Luna Barahona',
            'docente_id' => $docenteConsejero->id,
        ]);

        // 5. Matricular al estudiante en el grupo registrando su nota
        $matricula = EstudianteMatriculado::create([
            'grupo_id' => $grupo->id,
            'estudiante_id' => $estudiante->id,
            'nota' => 95.5,
        ]);

        // --- VERIFICACIONES Y ASERCIONES ---

        // Verificar datos propios del Grupo
        $this->assertEquals(2, $grupo->numeroCiclo);
        $this->assertEquals(2026, $grupo->ano);
        $this->assertEquals(1, $grupo->numeroGrupo);
        $this->assertTrue($grupo->abierto);

        // Verificar relación con Curso
        $this->assertEquals('IF6100', $grupo->curso->sigla);
        $this->assertEquals('Análisis & Diseño de Sistemas', $grupo->curso->nombreCurso);

        // Verificar relación con Docentes (debe contener los 2 docentes asignados)
        $this->assertCount(2, $grupo->docentes);
        $this->assertEquals('Ana', $grupo->docentes->first()->nombreEmpleado);

        // Verificar estudiantes matriculados y sus notas
        $this->assertCount(1, $grupo->estudiantes);
        $this->assertEquals('C34434', $grupo->estudiantes->first()->carne);
        $this->assertEquals(95.5, $grupo->estudiantes->first()->pivot->nota);
    }
}
