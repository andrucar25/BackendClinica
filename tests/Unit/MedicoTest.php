<?php

namespace Tests\Unit;

use App\Models\Medico;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class MedicoTest extends TestCase
{
    public function testMedicoHasManyHorarioMed()
    {
        $medico = new Medico;
        $this->assertInstanceOf(Collection::class, $medico->horariosMedico);
    }
    public function testMedicoHasManyTeleconsulta()
    {
        $medico = new Medico;
        $this->assertInstanceOf(Collection::class, $medico->teleconsultas);
    }
    public function testMedicoHasManyComentarios()
    {
        $medico = new Medico;
        $this->assertInstanceOf(Collection::class, $medico->comentarios);
    }
    public function testMedicoHasManyChatsMed()
    {
        $medico = new Medico;
        $this->assertInstanceOf(Collection::class, $medico->chatsMedico);
    }
 
    
    

}
