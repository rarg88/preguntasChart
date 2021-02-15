<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respuesta;
use App\Models\Pregunta;

class RespuestasController extends Controller
{
    public function update(Request $request){
      foreach ($request->respuesta as $id => $r){
        $respuesta = Respuesta::find($id);
        $respuesta->respuesta = $r;
        $respuesta->save();
      }

      return redirect()->route('showPregunta',['id'=>$request->pregunta_id, 'updateRespuestas'=>true]);

    }
}
