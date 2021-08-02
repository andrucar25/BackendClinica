<?php

namespace Tests\Unit;


use App\Models\Laboratorio;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;


class LaboratorioTest extends TestCase
{
   //Prueba Unitaria Listar
    public function testGetAllLaboratorios()
   {
        $response = $this->json('GET', 'api/v1/laboratorio/'); //rutas
        $response->assertStatus(200); //respuesta que espero

        //estructura de la respuesta
        $response->assertJsonStructure(
            [
                [
                    'idLaboratorio',
                    'idPaciente',
                    'descripcion',
                    'fecha',
                    'responsable',
                    'area'
                ]
            ]
        );
   }

   //Prueba Unitaria Guardar
   public function testCreateLaboratorios()
   {
      $data = [
                       
        
                    
                    'idPaciente' => 1,
                    'descripcion' => "Descripcion Testing",
                    'fecha' => "2020-05-10",
                    'responsable'=> "Responsable Testing",
                    'area'=> "Area Testing"
                    
                   ];

           $response = $this->json('POST', 'api/v1/laboratorio/',$data); //peticion - ruta que contiene la peticion
           $response->assertStatus(201); //respuesta que espero
           $response->assertJson(['data' => $data]);
     }

     //Prueba Unitaria Modificar
     public function testUpdateTeleconsulta()

     {

        $data = [

                'idPaciente' => 1,
                'descripcion' => "Descripcion Modificado",
                'fecha' => "2020-05-12",
                'responsable'=> "Responsable Modificado",
                'area'=> "Area Modificada"

        ];

            $response = $this->json('PUT', 'api/v1/laboratorio/1',$data);

            $response->assertStatus(200);

            $response->assertJson(['data' => $data]);

       }

}
