<?php

namespace Tests\Browser;

use App\Models\Status;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Carbon\Carbon;

class UsersCanSeeAllStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function users_can_see_all_statuses_on_homepage()
    {
        //para este test necesitamos tener estados en la base de datos

        $statuses = Status::factory(3)->create([
            'created_at' => now()->subMinute() 
        ]);

        $this->browse(function (Browser $browser) use ($statuses){
            $browser->visit('/')
            //cuando visitimos el home, le indicamos que espere por el texto
            ->waitForText($statuses->first()->body)
            //luego que nos haga la asercion osea verificamos en la pagina el texto
            ->assertSee($statuses->first()->body);
     
        //por ultimo podemos asegurarnos de ver todos los estados en pantalla

        foreach($statuses as $status){
            $browser->assertSee($status->body)
            //aparte de ver los estados queremos ver el nombre del usuario que creo el estado 
            ->assertSee($status->user->name)
            ->assertSee($status->created_at->diffForHumans());
            
        }
        
        });

       
    }
}
