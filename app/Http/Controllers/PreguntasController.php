<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Sede;

class PreguntasController extends Controller
{
    public function create(){
      return view('preguntas.create', ['sedes' => Sede::all()]);
    }

    public function store(Request $request){
      if($request->cantidadPreguntas > 0){
        for ($i=1; $i <= $request->cantidadPreguntas; $i++) { 
          $pregunta = new Pregunta();
          $pregunta->pregunta = $request->titulo[$i];
          $pregunta->save();
          $sedes = $request->sedes;
          foreach ($sedes as $sede) {
            $respuesta = new Respuesta();
            $respuesta->pregunta_id = $pregunta->id;
            $respuesta->sede_id = $sede;
            $respuesta->save();  
          }
        }
        return redirect()->route('home', ['crearPreguntas' => 'ok']);

      }
    }

    public function show($id){
      $pregunta = Pregunta::findOrFail($id);
      $data = [];
      $sedes = [];
      foreach($pregunta->respuestas as $respuesta){
        $data[] = $respuesta->respuesta;
        $sedes[] = $respuesta->sede->sede;
      }

      return view('preguntas.show', [
        'pregunta' => $pregunta,
        'prev' => Pregunta::where('id', '<', $id)->orderBy('id','desc')->first(),
        'next' => Pregunta::where('id', '>', $id)->orderBy('id')->first(),
        'data' => $data,
        'respuestas' => Respuesta::where('pregunta_id', $id)->get(),
        'sedes' => $sedes,
      ]);
    }

    public function update($id, Request $request)
    {
        $pregunta = Pregunta::where('id', $id)->first();
        $pregunta->pregunta = $request->pregunta;
        $pregunta->save();
        $data = [];
        foreach($pregunta->respuestas as $respuesta){
          $data[] = $respuesta->respuesta;
          $sedes[] = $respuesta->sede->sede;
        }

        return view('preguntas.show', [
        'pregunta' => $pregunta,
        'prev' => Pregunta::where('id', '<', $id)->orderBy('id','desc')->first(),
        'next' => Pregunta::where('id', '>', $id)->orderBy('id')->first(),
        'data' => $data,
        'respuestas' => Respuesta::where('pregunta_id', $id)->get(),
        'sedes' => $sedes,
        'update' => true,
      ]); 
    }

    public function destroy($id){
      $pregunta = Pregunta::find($id);
      $pregunta->delete();
  
      $respuestas = Respuesta::where('pregunta_id', $id)->get();
      foreach ($respuestas as $respuesta) {
        $respuesta->delete();
      }
  
      return redirect()->route('home', ['borraPregunta' => 'ok']);
    }
    
}
