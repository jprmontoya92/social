<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusLikeController extends Controller
{
    //este metodo recibe un parametro de tipo Status    
    public function store(Status $status){
          
        //podemos acceder a este estado y llamar la relacion likes y a traves de esta relacion creamos un nuevo like  
        $status->likes()->create([
            'user_id' => auth()->id()
        ]);

    }
}
