<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function user(){
        
        return $this->belongsTo(User::class);
    }

    public function comments(){
        
        return $this->hasMany(Comment::class); 
    }

    public function likes(){
        
        return $this->hasMany(Like::class); 
    }

    public function like(){

        $this->likes()->firstOrCreate([
            'user_id' => auth()->id()
        ]);
    }


    public function isLiked(){
        //vamos a acceder a todo los likes del estado y preguntaremos si dentro de estos likes exite uno con user_id igual al id del usuario actualmente autenitcado
        //es decir si este estado tiene un like del usuario actualmente autenticado y nos interesa si existe en la base de datos
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function unlike(){

        //en vez de crear uno vamos a buscar uno con el id del usuario autenticado y los vamos a quitar 
        $this->likes()->where([
            'user_id' => auth()->id()
        ])->delete();
    }

    public function likesCount(){

        return $this->likes()->count();
    }
}
