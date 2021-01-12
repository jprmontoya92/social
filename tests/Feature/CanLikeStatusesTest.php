<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanLikeStatusesTest extends TestCase
{
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    use DatabaseMigrations;
    
    public function an_authenticated_user_can_like_statuses()
    {
        $this->withoutExceptionHandling();
        //que queremos probar, qu eun usuario autentucado pueda dar like
        //creamos el usuario

        $user = User::factory()->create();
        //tambien creamos el estado al cual se le va dar like
        $status = Status::factory()->create();

        //accion que queremos verificar
        //actuando como este usuario hacemos un postJson a la ruta y como segundo parametro le pasamos el estado
        $this->actingAs($user)->postJson(route('statuses.likes.store', $status));

        //una vez sucedido lo anterior, verificamos en la base de datos que hay una tabla llamada likes y qeu aqui exite un registro con el user_id igual al usuario creado anteriormente que realiza la accion (actionAs)
        //y verficamos el campo status_id que sera igual al estado que el usuario le dio like postJson.....
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'status_id' => $status->id
        ]);

        
    }
}
