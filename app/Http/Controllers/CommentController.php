<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request){

        //Validacion
        $validate = $this->validate($request, [
            'image_id' => 'required|integer',
            'content' => 'string|required'
        ]);

        //Recoger datos
        $user = \Auth::user();
        $content = $request->input('content');
        $image_id = $request->input('image_id');

        //Asigno los valores a mi objeto
        $comment = new Comment;
        //dd($comment);
        $comment->users_id = $user->id;
        $comment->images_id = $image_id;
        $comment->content = $content;
       
        //guardar en la base de datos
        $comment->save();

        return redirect()->route('image.detail', [
            'id' => $image_id
        ])->with([
            'message' => 'Haz hecho un comentario'
        ]);

    }

    public function delete($id){
        //Conseguir datos del usuario identificado
        $user = \Auth::user();

        //Conseguir objeto del comentario
        $comment = Comment::find($id);
        //Comprobar si soy el dueño del comentario o de la publicacion
        if ($user && ($comment->users_id == $user->id || $comment->images->users_id == $user->id)) {
            $comment->delete();
            return redirect()->route('image.detail', ['id' => $comment->images->id])
                        ->with([
                            'message' => 'Comentario eliminado'
                        ]);
        }else{
            return redirect()->route('image.detail', ['id' => $comment->images->id])
                        ->with([
                            'message' => 'Comentario NO eliminado!'
                        ]);
        }

    }
}
