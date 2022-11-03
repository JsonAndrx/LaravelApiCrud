<?php

namespace App\Http\Controllers\Api;
use App\Models\Publicaciones;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicacionesController extends Controller
{
    public function create(Request $request){
        
        $request -> validate([
            'title' => 'required',
            'description' => 'required',
            'name' => ""
        ]);

        $publicacion = new Publicaciones();
        $publicacion -> title = $request -> title;
        $publicacion -> description = $request -> description;
        $publicacion -> name = auth()->user()->name;
        $publicacion->save();

        return response($publicacion, Response::HTTP_CREATED);

    }

    public function allpublicaciones(){
        $publicaciones = Publicaciones::all($columns=['*']);
        return response()->json([
            "message"=>$publicaciones
        ]);
    }

    public function edit(Request $request, $id){
        $query = Publicaciones::all()->where('id', '=', $id);

        foreach($query as $posts){
            if(!isset($request->title)){
                $title = $posts->title;
            }else{
                $title = $request -> title;
            }
            if(!isset($request->description)){
                $description = $posts->description;
            }else{
                $description = $request->description;
            }
        }
    
        $editarPublicacion= Publicaciones::where('id', '=', $id)->update(['title'=>"$title", 'description'=>"$description"]);
        $ediQuery = Publicaciones::all()->where('id', '=', $id);
        return response()->json([
            "message"=>"Publicacion actual",
            "edit"=>$query,
            "meessage"=>"Se edito la publicacion correctamente",
            "editsucces"=>$ediQuery
        ]);

    }

    public function delete(Request $request, $id){
        $query = Publicaciones::where('id', '=', $id)->delete();
        return response()->json([
            "message"=>"Se elimino la publicacion correctamente",
            "delete"=>$query
        ]);
    }


}
