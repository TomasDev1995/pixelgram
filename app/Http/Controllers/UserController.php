<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File; 

class UserController extends Controller
{
    public function __construc()
    {
        $this->middleware('auth');
    }
    public function config()
    {
        return view('user.config');
    }

    public function update(Request $request)
    {         
        //conseguir usuario autenticado o identificado
        $user = \Auth::user();
        $id = $user->id;
        
        //Validar del usuario
        $validator = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
        ]);

        //Recoger los datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
        //Asignar nuevos valores al objeto del usuario 
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;
        

        
        //dd($image_path);
        if($request->hasFile('image_path')){
            //subir la imagen
            $image_path = $request->file('image_path'); 
            //Nombre unico de la imagen
            $image_path_name = time().$image_path->getClientOriginalName();
            //dd($image_path_name);
            //guardamos en el storage en la carpeta storage('storage/app/users')
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            
            //Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }


        //Ejecutar consultas y cambios en la base de datos
        $user->update();
        
        return redirect()->route('user.config')->with(['message' => 'Usuario actualizado correctamente']);

    }

    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
    
}
