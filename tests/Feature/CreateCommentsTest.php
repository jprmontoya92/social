<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function guest_user_cannot_create_comments(){
        //necesitatermos un estado 
        $status = Status::factory()->create();
        $comment = ['body'=> 'Mi primer comentario'];

        $response = $this->postJson(route('statuses.comments.store',$status),$comment);
        //401 no autorizado
        $response->assertStatus(401);
    }


    /** @test */

   public function authenticated_users_can_comment_statuses(){
        //necesitatermos un estado 
        $status = Status::factory()->create();
        //ademas del estado necesitamos un usuario que haga la acccion 
        $user = User::factory()->create();
        $comment = ['body'=> 'Mi primer comentario'];

        //entonces, actuando como un usuario, hacesmos un postJSon, como segundo parametro de postJson le pasamos el coemntario
       $response =  $this->actingAs($user)->postJson(route('statuses.comments.store',$status),$comment);

       //vamos a verificar que recibimos el comentario como respuesta.
       //utilizaremos un recurso API

       $response->assertJson([
           'data' => ['body' => $comment['body']]
       ]);

        //verificamos en la base de datos que exista una tabla llamada comments 
        //el comentario debe tener un dueño
        $this->assertDatabaseHas('comments',[
            'user_id' => $user->id,
            'status_id' => $status->id,
            'body' => $comment['body']
        ]);

    }

     /** @test */
     public function a_comment_requires_a_body(){

         $status = Status::factory()->create();
         $user = User::factory()->create();
         $this->actingAs($user);

        $response = $this->postJson(route('statuses.comments.store',$status),['body'=>'']);
        
        
        //ademas se puede verificar que el status code sea 422 que se traduce a entidad no procesable
        $response->assertStatus(422);
        //para verificar solo las llaves podemos utilizar assertJsonStructure
        //es decir verificame solo la estructura del Json
        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);

    }
}
