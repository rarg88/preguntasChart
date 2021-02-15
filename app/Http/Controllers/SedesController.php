<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sede;
use App\Models\Respuesta;

class SedesController extends Controller
{
  public function index(){
    return view('sedes.index', ['sedes' => Sede::all()]);
  }


  public function create(){
    return view('sedes.create');
  }

  public function store(Request $request){
    if($request->cantidadSedes > 0){
      for ($i=1; $i <= $request->cantidadSedes; $i++) { 
        $sede = new Sede();
        $sede->sede = $request->sede[$i];
        $sede->save();
      }
      return redirect()->route('home', ['crearSedes' => 'ok']);

    }
  }

  public function update($id, Request $request){
    $sede = Sede::find($id);
    $sede->sede = $request->sede;
    $sede->save();

    return redirect()->route('indexSedes', ['editSede' => 'ok']);
  }

  public function destroy($id){
    $sede = Sede::find($id);
    $sede->delete();

    $respuestas = Respuesta::where('sede_id', $id)->get();
    foreach ($respuestas as $respuesta) {
      $respuesta->delete();
    }

    return redirect()->route('indexSedes', ['borraSede' => 'ok']);
  }
}
