<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    public function save(Request $request){

        // Validación
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|image'
        ]);

        //recoger datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');
        //dd($image_path, $description);

        //Asginar valores
        $user = \Auth::user();
        $image = new Image;
        $image->user_id = $user->id;
        $image->description = $description;

        //Pregunta si es true lo que trae el request en el campo image_path
        if($request->hasFile('image_path')){
            $image_path = $request->file('image_path');
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->imagen_path = $image_path_name;
        }
        $image->save();

        return redirect()->route('home')->with(['message' => 'La foto ha sido subida correctamente!']);
    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function detail($id){
        $image = Image::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if ($user && $image && $image->user_id == $user->id){
            //Eliminar Comentarios
            if ($comments && count($comments) >= 1){
                foreach ($comments as $comment){
                    $comment->delete();
                }
            }

            //Eliminar Likes
            if ($likes && count($likes) >= 1){
                foreach ($likes as $like){
                    $like->delete();
                }
            }

            //Eliminar ficheros de imagen
            Storage::disk('images')->delete($image->image_path);

            //Eliminar registro de imagen
            $image->delete();

        }else{
            return redirect()->route('home')->with('status', 'La imagen no se ha borrado');
        }

        return redirect()->route('home')->with('status', 'La imagen se ha borrado correctamente');
    }

    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);

        if ($user && $image && $image->user_id == $user->id){
            return view('image.edit', ['image' => $image]);
        }else{
            return redirect()->route('home');
        }
    }

    public function update(Request $request){
        // Validación
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'image'
        ]);
        //Recoge los datos
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //Consigue imagen objeto
        $image = Image::find($image_id);
        $image->description = $description;

        //Subir fichero al storage
        if($request->hasFile('image_path')){
            $image_path = $request->file('image_path');
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->imagen_path = $image_path_name;
        }

        //Actualiza el objeto imagen en la base de datos
        $image->update();

        return redirect()->route('image.detail', [
            'id' => $image_id
        ])->with(['message' => 'Imagen actualizada']);
    }
}
