<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\CommentResource;
use App\Http\Resources\StatusResource;
use App\Models\Comment;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusResourceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     * @test
     * @return void
     */
    public function a_status_resources_must_have_the_necessary_fields()
    {
        //$this->withoutExceptionHandling();
        // en este caso queremos que nos traiga los campos necesarios osea el avatar, el nombre del usuario y la fecha de publicacion
        
        //lo primero que necesitamos es un estado
        $status = Status::factory()->create();

        Comment::factory()->create(['status_id' => $status->id]);
    

        //aca creamos el recurso API y le pasamos el estado para que lo transforme y lo devuelva como lo queremos
        //cuando tengamos este recurso, nos va a devolver un array cuando lo regresemos del controlador y para simular esa respuesta llamamos al metodo resolve.. verificar con dd oara ver trae
        $statusResource = StatusResource::make($status)->resolve();

        //asi que podemos verificar que obtenemos la lalve correcta de dicho array
        //como primer parametro le pasamos el nombre de la llave y el segundo el array del recurso
       /*  $this->assertArrayHasKey('body', $statusResource);
        //duplicamos para traer los demas campos
        $this->assertArrayHasKey('user_name', $statusResource);
        $this->assertArrayHasKey('user_avatar', $statusResource);
        $this->assertArrayHasKey('ago', $statusResource); */
       // dd($statusResource);
        //si queremos comprobar el contenido de cada campo, por ej si quueremos que elbody que hemos creado seael mismo que recibimos desde statusResource hacemos lo siguiente
        //entonces no seria necesario comprobarsi existe la llave, ya que si no existe un body en statusResource igualmante va a fallar por ende podemos quedarnos con esta verificacion
        $this->assertEquals($status->id, $statusResource['id']);
        $this->assertEquals($status->body, $statusResource['body']);
        $this->assertEquals($status->user->name, $statusResource['user_name']);
        $this->assertEquals('https://aprendible.com/images/default-avatar.jpg', $statusResource['user_avatar']);
        $this->assertEquals($status->created_at->diffForHumans(), $statusResource['ago']);
        $this->assertEquals(false, $statusResource['is_liked']);
        $this->assertEquals(0, $statusResource['likes_count']);


        //dd($statusResource['comments']);
       //dd($statusResource['comments']->first()->resource);

         $this->assertEquals(
            CommentResource::class,
            $statusResource['comments']->collects
        );


        //verificamos que sea una instancia de Modelo Comment del primer element del statusResource comment
        $this->assertInstanceOf(
            Comment::class,
            $statusResource['comments']->first()->resource);
 
    }
}
