<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CommentTest extends TestCase
{
    use RefreshDatabase; 
    /** @test */
    public function a_comment_belongs_a_user()
    {
        $this->withoutExceptionHandling();

        //creamos un comentario
        $comments = Comment::factory()->create();

        //verificamos que recibe una instancia de la clase User
        $this->assertInstanceOf(User::class, $comments->user); 
    }
}
