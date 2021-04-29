<?php

namespace Tests\Unit\Models;

use App\Models\Like;
use App\Models\Status;
use App\Models\User;
use App\Models\Comment;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class StatusTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     * @test
     * @return void
     */
    public function a_status_belongs_to_a_user()
    {

        //creamos  un estado en la base de datos
        $status  = Status::factory()->create();

        //verificamos que el onjeto sea de una determinada clase, en este caso queremos recibir una instancia de la clase User cuando llamemos a $status->user
       $this->assertInstanceOf(User::class, $status->user);
    }

     /** @test */
     public function a_status_has_many_comments(){

     // $this->withoutExceptionHandling();
      //necesitamo un estado
      $status = Status::factory()->create();

      //necesitaremos un like y le diremos que este like pertenece al estado que creamos arriba 
       Comment::factory()->create(['status_id' => $status->id]);

       // una vez que tengamos lo anterior, verificamos la instancia es decir al llamar al metdo like , obtendremos un coleccion de likes y al llamar el metodo first
       //nos traera el primer registro que sera un instancia de Like
       $this->assertInstanceOf(Comment::class, $status->comments->first());
       //$status->likes->firts  estamos accediendo a la relacion de estados y likes
     }
     
    /** @test */
    public function a_status_has_many_likes(){

        $this->withoutExceptionHandling();
        //necesitamo un estado
        $status = Status::factory()->create();

        //necesitaremos un like y le diremos que este like pertenece al estado que creamos arriba 
         Like::factory()->create(['status_id' => $status->id]);

         // una vez que tengamos lo anterior, verificamos la instancia es decir al llamar al metdo like , obtendremos un coleccion de likes y al llamar el metodo first
         //nos traera el primer registro que sera un instancia de Like
         $this->assertInstanceOf(Like::class, $status->likes->first());
         //$status->likes->firts  estamos accediendo a la relacion de estados y likes

    }

    /** @test */
    public function a_status_can_be_liked_once(){
        
        $this->withoutExceptionHandling();
        //creamos un estado 
        $status = Status::factory()->create();

        //utilizamos un usuario autenticado
        $this->actingAs(User::factory()->create());

        //una vez autenticado llamamos al metodo Like
        $status->like();

        //vericamos que uno sea la cantidad de like que tiene este estado
        $this->assertEquals(1, $status->likes->count());

        $status->like();

        //vericamos que uno sea la cantidad de like que tiene este estado

        $status->fresh();

        $this->assertEquals(1, $status->likes->count());
    }

    /** @test */
    public function a_status_can_be_liked_and_unlike(){
        $this->withoutExceptionHandling();

        //creamos un estado 
        $status = Status::factory()->create();

        //utilizamos un usuario autenticado
        $this->actingAs(User::factory()->create());

        //una vez autenticado llamamos al metodo Like
        $status->like();

        //vericamos que uno sea la cantidad de like que tiene este estado
        $this->assertEquals(1, $status->likes->count());

        $status->unlike();

        //para refrescar la cache
        $status->refresh();
        $this->assertEquals(0, $status->likes->count());
    }

      /** @test */
      public function a_status_knows_id_it_has_benn_liked(){

        //necesitamos un estado

        $status = Status::factory()->create();

        //vamos a verificar que por defecto el metodo isLiked() nos devuelva false
        //este assertFalse va verificar lo que le pasemos sea falso
        $this->assertFalse($status->isLiked());
        
        //vamos a autenticar un usuario
        $this->actingAs(User::factory()->create());
        
        //para mayor seguridad preguntamos si isLiked devuelve falso aun cuando haya sido autenticado 
        $this->assertFalse($status->isLiked());

        //vamos a dar Like al estado
        $status->like();

        //y ahora no queremos que el metodo isLiked nos retorne true

        $this->assertTrue($status->isLiked());
      }


      /** @test */
      public function a_status_knows_how_many_likes_it_has(){

        //primero necesitamos un estado
        $status = Status::factory()->create();
        //verificamos que al crear el estado tenga 0 likes
        $this->assertEquals(0,$status->likesCount());

        Like::factory(2)->create(['status_id' => $status->id]);

        //verficamos los dos likes creados
        $this->assertEquals(2,$status->likesCount());



      }


 
}
