<?php

namespace Tests\Unit\Models;

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
}
