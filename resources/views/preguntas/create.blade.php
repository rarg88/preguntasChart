@extends('layout')

@section('content')
  <div class="py-5 container">
    <a href="{{ route('home') }}"><button class="btn btn-info">Home</button></a>
    <h2 class="pt-5">Crear Preguntas</h2>
    <div class="row pt-3">
      <div class="col-12 col-sm-10">
        <h4>¿Cuantas preguntas quieres crear?</h4>
        <form method="post" action="/preguntas/store">
          @csrf
          <div class="form-group row pt-3">
            <label for="cantidadPreguntas" class="col-sm-2 col-form-label">Cantidad</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" name="cantidadPreguntas" id="cantidadPreguntas" value="1"><br>
            </div>
          </div>
          <div id="crearPreguntas">
            <!-- Generar Input para las preguntas -->
            <div class="form-group row">
              <label for="titulo1" class="col-sm-2 col-form-label">Titulo 1</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="titulo[1]" id="titulo1"><br>
              </div>
            </div>
          </div>
          <h6>Elige las sedes que van a responder</h6>
          @foreach ($sedes as $sede)
          <div class="form-check form-check-inline py-3">
            <input class="form-check-input" type="checkbox" id="{{ $sede->sede }}" name="sedes[]" value="{{ $sede->id }}">
            <label class="form-check-label" for="inlineCheckbox1">{{ $sede->sede }}</label>
          </div>
          @endforeach
          <div class="form-group row py-3">
            <input type="submit" class="btn btn-primary" name="sendData" value="Enviar" id="sendData">
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script>
    $('#cantidadPreguntas').change(function() {
      let cantidad = $('#cantidadPreguntas').val();
      $('#crearPreguntas').empty();
      for (var i = 1; i <= cantidad; i++) {
          $("#crearPreguntas").append('<div class="form-group row"><label for="titulo'+i+'" class="col-sm-2 col-form-label">Titulo '+i+'</label><div class="col-sm-10"><input type="text" class="form-control" name="titulo['+i+']" id="titulo'+i+'"><br></div></div>');
      }
    });
  </script>
@endsection
