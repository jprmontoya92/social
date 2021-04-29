<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class StatusCommentsController extends Controller
{
    public function store(Status $status){

        request()->validate([
            'body' => 'required'
        ]);
        
      $comment = Comment::create([
            'user_id' => auth()->id(),
            'status_id' => $status->id,
            'body' => request('body')
        ]);

        //aqui devolveremos el recurso API
        //llaamamos al metodo make para que realice la transformacion recien creada
        return CommentResource::make($comment);
        
    }
}
