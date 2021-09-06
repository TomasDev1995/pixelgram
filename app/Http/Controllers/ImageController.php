<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image; 
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
        $image->users_id = $user->id;
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
}
