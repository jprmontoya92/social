<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //retornaremos los datos que necesitemos por aqui 
        return [
            //para acceder al estado o para cualquiera que sea el modelo del recurso  lo haccemos a traves de resource  $this->resource 
            'id' => $this->id,
            'body' => $this->body,
            //aqui vamos accder a la relacion user y luego al nombre del usuario
            'user_name' => $this->user->name,
            'user_avatar' => 'https://aprendible.com/images/default-avatar.jpg',
            'ago' => $this->created_at->diffForHumans(),
            'is_liked' => $this->isLiked(),
            'likes_count' => $this->likesCount(),
            'comments' => CommentResource::collection($this->comments)
            //de esta manera evitamos pasar un recurso o coleccion distinta
        ];
    }
}
