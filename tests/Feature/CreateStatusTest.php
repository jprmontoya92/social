<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test */
    public function guests_users_can_not_create_statuses(){

        //$this->withoutExceptionHandling();

        $response = $this->post(route('statuses.store'),['body'=>'Mi primer status']);
        //dd($response->getContent());
        $response->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_create_statuses()
    {

        //para evitar que laravel maneje las excepciones, podemos utilizar el metodo
        $this->withoutExceptionHandling();

        //mantener estructura en los test
        //1. Given => teniendo, aqui creamos el contexto, cual es el estado de la aplicacion antes de realizar la acción que queremos comprobar
        //2. When => cuando, aqui realizamos dicha accion que queremos comprobar
        //3. Then => Entonces, los resultados obtenidos son lo esperados|

        //en nuestro caso
        //1. Teniendo un usuario autenticado
        $user = User::factory()->create();
        $this->actingAs($user);
        //2. Cuando hace un post request a status
        $response = $this->post(route('statuses.store'),['body'=>'Mi primer status']); //como segundo parametro le pasamos informacion que queremos enviar
        //3. Entonces veo un nuevo estado en la base de datos

        $response->assertJson([
            'body' => 'Mi primer status'
        ]);
        //podemos guardar el resultado en una variable y hacer comprobaciones
         $this->assertDatabaseHas('statuses',[
            'user_id' => $user->id,
            'body' => 'Mi primer status'
        ]); //verifica datos en la base  de datos

    }

    /** @test */
    public function a_status_requires_a_body(){

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'),['body'=>'']);
        
        
        //ademas se puede verificar que el status code sea 422 que se traduce a entidad no procesable
        $response->assertStatus(422);
        //para verificar solo las llaves podemos utilizar assertJsonStructure
        //es decir verificame solo la estructura del Json
        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);

    }


     /** @test */
     public function a_status_requires_a_minimum_lenght()
     {

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'),['body'=>'asdf']);

        //ademas se puede verificar que el status code sea 422 que se traduce a entidad no procesable
        $response->assertStatus(422);
        //para verificar solo las llaves podemos utilizar assertJsonStructure
        //es decir verificame solo la estructura del Json
        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);

    }
}
