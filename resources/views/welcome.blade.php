@extends('layout')

@section('content')
    <div class="py-5 container">
      <h2>Preguntas</h2>
      <div>
        <div class="row">
          <div class="col-12 col-sm-6">

            <!-- Alertas -->

            @if(request()->get('crearPreguntas') == 'ok')
            <div class="alert alert-success alert-dismissible show" role="alert">
              ¡<strong>Pregunta</strong> creada correctamente!
            </div>
            @endif
            @if(request()->get('crearSedes') == 'ok')
            <div class="alert alert-success alert-dismissible show" role="alert">
              ¡<strong>Sede</strong> creada correctamente!
            </div>
            @endif
            @if(request()->get('borraSede') == 'ok')
            <div class="alert alert-success alert-dismissible show" role="alert">
              ¡<strong>Sede</strong> borrada correctamente!
            </div>
            @endif
            @if(request()->get('borraPregunta') == 'ok')
            <div class="alert alert-success alert-dismissible show" role="alert">
              ¡<strong>Pregunta</strong> borrada correctamente!
            </div>
            @endif
            @if(request()->get('crearSede') == 'ok')
            <div class="alert alert-success alert-dismissible show" role="alert">
              ¡<strong>Sede</strong> creada correctamente!
            </div>
            @endif

            <!-- Fin Alertas-->

            <h4>Crear preguntas</h4>
            <div class="py-3">
              <a href="/preguntas/create"><button class="btn btn-primary">Crear</button></a>
            </div>
          </div>
        </div>
        <div class="row py-3">
          <div class="col-12">
            <h4>Ver preguntas</h4>
            @if (!$preguntas->isEmpty())
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="width: 10%">#</th>
                  <th style="width: 50%">Pregunta</th>
                  <th style="width: 40%" class="text-right">Acceso</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($preguntas as $pregunta)
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $pregunta->pregunta }}</td>
                    <td class="text-right">
                      <div class="row justify-content-end">
                        <a href="/preguntas/{{ $pregunta->id }}" class="pr-1"><button class="btn btn-info">Acceder</button></a>
                        <form method="POST" action="/preguntas/{{ $pregunta->id }}" class="pr-3">
                          @csrf
                          @method('DELETE')
                          <div class="form-group">
                              <input type="submit" class="btn btn-danger delete-pregunta" value="Borrar">
                          </div>
                        </form>
                    </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            @else
                <h6>Aún no hay ninguna preguntas</h6>
            @endif
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6">
            <h4>Sedes</h4>
            <div class="py-3">
              <a href="/sedes/create"><button class="btn btn-primary">Crear Sede</button></a>
              <a href="/sedes/" class="mx-3"><button class="btn btn-primary">Ver y editar Sedes</button></a>
            </div>
          </div>
        </div>
        <div class="row py-3">
          <div class="col-12">
            <h4>Ver Sedes</h4>
            @if (!$sedes->isEmpty())
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Sede</th>
                  <th scope="col" class="text-right">Acceso</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($sedes as $sede)
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $sede->sede }}</td>
                    <td class="text-right">
                      <div class="row justify-content-end">
                        <form method="POST" action="/sedes/{{ $sede->id }}" class="pr-3">
                          @csrf
                          @method('DELETE')
                          <div class="form-group">
                              <input type="submit" class="btn btn-danger delete-sede" value="Borrar">
                          </div>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            @else
                <h6>Aún no hay ninguna sede</h6>
            @endif
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    setTimeout(function() {
      $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
          $(".alert-dismissible").alert('close');
      });   
    }, 3000);
  });

  $('.delete-pregunta').click(function(e){
      e.preventDefault() // Don't post the form, unless confirmed
      if (confirm('¿Seguro que deseas borrar la pregunta?')) {
          // Post the form
          $(e.target).closest('form').submit() // Post the surrounding form
      }
  });

  $('.delete-sede').click(function(e){
      e.preventDefault() // Don't post the form, unless confirmed
      if (confirm('¿Seguro que deseas borrar la sede?')) {
          // Post the form
          $(e.target).closest('form').submit() // Post the surrounding form
      }
  });

</script>
@endsection

