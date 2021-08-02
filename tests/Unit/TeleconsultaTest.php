<?php

namespace Tests\Unit;

use App\Models\Teleconsulta;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class TeleconsultaTest extends TestCase
{
    
    public function testTeleconsultaHasManyArchivoTel()
    {
        $teleconsulta = new Teleconsulta;
        $this->assertInstanceOf(Collection::class, $teleconsulta->archivosTeleconsultas);
    }
  
   public function testGetAllTeleconsultas()
   {
        $response = $this->json('GET', 'api/v1/teleconsulta/');
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                [
                    'idTeleconsulta',    
                    'idPaciente',
                        'idMedico',
                        'diagnostico',
                        'receta',
                        'estadoConsulta',
                        'estadoPago',
                        'fechaHora',
                        'enlace'
                ]
            ]
        );
   }

   public function testCreateTeleconsulta()
   {
      $data = [
                       'idPaciente' => 1,
                       'idMedico' => 1,
                       //'diagnostico' => 20,
                      // 'receta' => 10,
                       'estadoConsulta' => 1,
                       'estadoPago' => 1,
                       'fechaHora' => "2021-05-14 12:00:00",
                       //'enlace' => ,
                   ];
           $response = $this->json('POST', 'api/v1/teleconsulta/',$data);
           $response->assertStatus(201);
          $response->assertJson(['data' => $data]);
     }

     public function testUpdateTeleconsulta()
     {
        $data = [
            'idPaciente' => 1,
            'idMedico' => 1,
            'diagnostico' => "Diagnostico test",
            'receta' => "receta.jpg",
            'estadoConsulta' => 2,
            'estadoPago' => 1,
            'fechaHora' => "2021-06-14 12:00:00",
            'enlace' =>"googlemeet.com" ,
        ];
            $response = $this->json('PUT', 'api/v1/teleconsulta/9',$data);
            $response->assertStatus(200);
            $response->assertJson(['data' => $data]);
       }
  



}
