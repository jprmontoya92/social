<?php

namespace Tests\Feature;

use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListStatusesTest extends TestCase
{
    /**
     * A basic feature test example.
     * @test
     * @return void
     */

    use RefreshDatabase;
    
    public function can_get_all_statuses()
    {

       $this->withoutExceptionHandling();

        //primero crearemos los estados en la base de datos
      $statuses1  = Status::factory()->create(['created_at' => now()->subDays(4)]);
      $statuses2  = Status::factory()->create(['created_at' => now()->subDays(3)]);
      $statuses3  = Status::factory()->create(['created_at' => now()->subDays(2)]);
      $statuses4  = Status::factory()->create(['created_at' => now()->subDays(1)]);

      //luego haremos una paticion a l  a url sratuses y guardaremos al respuesta y ademas le indicamos al request que sea de tipo json
      $response = $this->getJson(route('statuses.index'));

      //en la verificacion, verificamos que la respuesta del servidor sea exitosa
      $response->assertSuccessful();
      
      //tambien podemos verificar el resultado del total que recibimos
      $response->assertJson([
          //indicamos que el total sea igual a la cantidad que creamos en la parte incial con factory
        'meta' => ['total' => 4]
      ]);

      //despues everificamos que recibimos una estructura json y sabemos qye vamos a paginar los resultados
      $response->assertJsonStructure([
          //llaves que recibiremos
        'data', 'links' => ['prev', 'next']
      ]);

     // dd($response->json('data.0.user_id'));

     //comparamos dos valores que sean iguales
     $this->assertEquals(
       //obtenemos el ultimo
       $statuses4->body,
      //al metodo json le podemos pasar la llave que queremos recibir ademas indicamos el primer elemento del array y de ese elemento queremos el identificador
        $response->json('data.0.body'),
        );



        // con esto tenemos testeada una url que nos devuelve todos los estados en el roden correcto
    }
}
