<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\CommentResource;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     * @test
     * @return void
     */
    public function a_comment_resources_must_have_the_necessary_fields()
    {
        //$this->withoutExceptionHandling();
        // en este caso queremos que nos traiga los campos necesarios osea el avatar, el nombre del usuario y la fecha de publicacion
        
        //lo primero que necesitamos es un estado
        $comment = Status::factory()->create();
    

        //aca creamos el recurso API y le pasamos el estado para que lo transforme y lo devuelva como lo queremos
        //cuando tengamos este recurso, nos va a devolver un array cuando lo regresemos del controlador y para simular esa respuesta llamamos al metodo resolve.. verificar con dd oara ver trae
        $commentResource = CommentResource::make($comment)->resolve();

        $this->assertEquals($comment->body, $commentResource['body']);

        $this->assertEquals($comment->user->name, $commentResource['user_name']);
        $this->assertEquals('https://aprendible.com/images/default-avatar.jpg', $commentResource['user_avatar']);
    }
}
