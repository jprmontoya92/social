<?php

namespace Tests\Unit\Models;

use App\Models\Like;
use App\Models\Status;
use App\Models\User;
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
    public function a_status_has_many_likes(){

        //necesitamo un estado
        $status = Status::factory()->create();

        //necesitaremos un like y le diremos que este like pertenece al estado que creamos arriba 
         Like::factory()->create(['status_id' => $status->id]);

         // una vez que tengamos lo anterior, verificamos la instancia es decir al llamar al metdo like , obtendremos un coleccion de likes y al llamar el metodo first
         //nos traera el primer registro que sera un instancia de Like
         $this->assertInstanceOf(Like::class, $status->likes->first());

    }
}
