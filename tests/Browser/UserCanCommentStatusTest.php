<?php

namespace Tests\Browser;

use App\Models\Comment;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanCommentStatusTest extends DuskTestCase
{
    Use DatabaseMigrations;
    

    /** @test */
    public function users_can_see_all_comments(){

        $this->withoutExceptionHandling();
        //necesistamos un estado
        $status = Status::factory()->create();
        $comments = Comment::factory(2)->create(['status_id' => $status->id]);

        //dd($comments->shift()->body);

        $this->browse(function (Browser $browser) use ($status, $comments){ 
            $browser->visit('/')
                    ->waitForText($status->body);

                    foreach($comments as $comment){
                        $browser->assertSee($comment->body)
                        ->assertSee($comment->user->name);
                    }
                    //como los comentarios son del estado que estamos declarando , verificamos el primer comentario..
                    //->assertSee($comments->shift()->body);
                    //el metodo shift lo que haces es sacar el primer comentario de la coleccion y lo borra a la vez hasta que la coleccion quede vacia
                    //->assertSee($comments->shift()->body);
        });

    }

    /** @test */
    public function authenticated_users_can_comment_statuses()
    {
        $this->withoutExceptionHandling();
        //creamos un estado 
        $status = Status::factory()->create();
        //creamos un usuario
        $user = User::factory()->create();
        
        $this->browse(function (Browser $browser) use ($status, $user){ 
            $comment = "Mi primer comentario";
            //lo primero es que el usuario haga login
            $browser->loginAs($user) 
            //visitamos el home
                    ->visit('/')
                    //y como siempre esperaremos el texto 
                    ->waitForText($status->body)
                    //vamos a escribir dentro de un campo comment ... y vamos a escribir mi primer comentario 
                    ->type('comment',$comment)
                    //luego vamos a enviar el comentario presionando el boton
                    ->press('@comment-btn')
                    ->waitForText($comment)
                    ->assertSee($comment);
        });
    }
}
