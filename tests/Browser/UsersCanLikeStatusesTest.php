<?php

namespace Tests\Browser;

use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanLikeStatusesTest extends DuskTestCase
{

    use DatabaseMigrations;
     /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function guest_users_cannot_like_statuses()
    {

   
        // y necesitamos un estado para darle like.
        $status = Status::factory()->create();

        //las variables anteriores las pasamos al clousure para tener acceso
        $this->browse(function (Browser $browser) use ($status) {
            //primero nos autenticamos con el usuario
            $browser->visit('/')
            //esperaremos por el texto
                    ->waitForText($status->body)
                    //y una vez que aparazca este text quiere decir se renderizaron los estado vuejs
                    //aqui presinamos el boton like...utilizamos el @ para indicar que es un selector de dusk
                    ->press('@like-btn')
                    ->assertPathIs('/login');
                    //despues hacemos la asercion del texto anterior osea de que vemos ese texto en realizado es lo que qeremos probar
        
        });
    }

    /**
     * A Dusk test example2.
     * @test
     * @return void
     */
    public function users_can_like_and_unlike_statuses()
    {

        //necesitamos un usuario en la base de datos 
        $user = User::factory()->create();
        // y necesitamos un estado para darle like.
        $status = Status::factory()->create();

        //las variables anteriores las pasamos al clousure para tener acceso
        $this->browse(function (Browser $browser) use ($user,$status) {
            //primero nos autenticamos con el usuario
            $browser->loginAs($user)
            //luego cuadno visitemos el hompage
                    ->visit('/')
            //esperaremos por el texto
                    ->waitForText($status->body)
                    //y una vez que aparazca este text quiere decir se renderizaron los estado vuejs
                    //al agregarle el In le estamos diciendo que el texto que estamos esperando lo vamos encontrar dentro de un elemento
                    //en este caso dentro de elemento likes-count vamos a encontrar un 0
                    ->assertSeeIn('@likes-count',0)
                    //aqui presinamos el boton like...utilizamos el @ para indicar que es un selector de dusk
                    ->press('@like-btn')
                    //luego que presionmmos el boton y como es una operacion con ajax vamos a esperar por el text TE GUSTA
                    ->waitForText('TE GUSTA')
                    //despues hacemos la asercion del texto anterior osea de que vemos ese texto en realizado es lo que qeremos probar
                    ->assertSee('TE GUSTA')
                    ->assertSeeIn('@likes-count',1)

                    ->press('@unlike-btn')
                    //luego que presionmmos el boton y como es una operacion con ajax vamos a esperar por el text TE GUSTA
                    ->waitForText('ME GUSTA')
                    //despues hacemos la asercion del texto anterior osea de que vemos ese texto en realizado es lo que qeremos probar
                    ->assertSee('ME GUSTA')
                    ->assertSeeIn('@likes-count',0);
        });
    }
}
