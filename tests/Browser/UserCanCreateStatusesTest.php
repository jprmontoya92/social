<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanCreateStatusesTest extends DuskTestCase
{

    use DatabaseMigrations;
    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function users_can_create_statuses()
    {

        //creamos un usuario ya que la url necesita a un usuario autenticado
        $user = User::factory()->create();
       // dd($user);
       
        $this->browse(function (Browser $browser) use ($user) {
        
            $browser->loginAs($user->email)
                    ->screenshot('create')
                    ->visit('/')
                    ->type('body', 'Mi primer status') // podemos indicar el metodo type , en donde el primer parametro es el nombre del campo que queremos llenar, es decir va a buscar un input con el nombre body, el segundo parametro es el valor que queremos ingresar
                    ->press('#create-status') //para dar click en botones utilizamos el metodo el metodo press, y por parametro le pasamos un selector, de momento de le pasamos el id del elemento
                    ->assertSee('Mi primer status');// y por ultimo verificamos en la pagina vemos el texto Mi primer Status
        });
    }
}
