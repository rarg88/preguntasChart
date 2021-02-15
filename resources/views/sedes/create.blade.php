@extends('layout')

@section('content')
  <div class="py-5 container">
    <a href="{{ route('home') }}"><button class="btn btn-info">Home</button></a>
    <h2 class="pt-5">Crear Sedes</h2>
    <div class="row pt-3">
      <div class="col-12 col-sm-10">
        <h4>¿Cuantas sedes quieres crear?</h4>
        <form method="post" action="/sedes/store">
          @csrf
          <div class="form-group row pt-3">
            <label for="cantidadSedes" class="col-sm-2 col-form-label">Cantidad</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" name="cantidadSedes" id="cantidadSedes" value="1"><br>
            </div>
          </div>
          <div id="crearSedes">
            <!-- Generar Input para las sedes -->
            <div class="form-group row">
              <label for="titulo1" class="col-sm-2 col-form-label">Sede 1</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="sede[1]" id="sede1"><br>
              </div>
            </div>
          </div>
          <input type="submit" class="btn btn-primary" name="sendData" value="Enviar" id="sendData">
        
        </form>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script>
    $('#cantidadSedes').change(function() {
      let cantidad = $('#cantidadSedes').val();
      $('#crearSedes').empty();
      for (var i = 1; i <= cantidad; i++) {
          $("#crearSedes").append('<div class="form-group row"><label for="sede'+i+'" class="col-sm-2 col-form-label">Sede '+i+'</label><div class="col-sm-10"><input type="text" class="form-control" name="sede['+i+']" id="sede'+i+'"><br></div></div>');
      }
    });
  </script>
@endsection
