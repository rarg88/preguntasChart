@extends('layout')

@section('content')
  <div class="py-5 container">
    <a href="{{ route('home') }}"><button class="btn btn-info">Home</button></a>
    <h2 class="pt-5">Sedes</h2>
    
    <!--Alertas-->

    @if(request()->get('editSede') == 'ok')
      <div class="alert alert-success alert-dismissible show" role="alert">
        ¡<strong>Sede</strong> editada correctamente!
      </div>
    @endif
    @if(request()->get('borraSede') == 'ok')
      <div class="alert alert-success alert-dismissible show" role="alert">
        ¡<strong>Sede</strong> borrada correctamente!
      </div>
    @endif

      <!--Fin Alertas-->

    <div class="row pt-3">
      <div class="col-12 col-sm-10">
        <div class="py-3">
          <a href="/sedes/create"><button class="btn btn-primary">Nueva Sede</button></a>
        </div>
      </div>
    </div>
    @if (!$sedes->isEmpty())
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Sede</th>
          <th scope="col" class="text-right">Acción</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($sedes as $sede)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <form method="POST" action="/sedes/{{ $sede->id }}" class="form-edit-sede">
              @csrf
              @method('PUT')
              <td>
                <input type="text" name="sede" value="{{ $sede->sede }}" class="form-control"></td>
              <td class="text-right">
                <div class="row justify-content-end">
                  <div class="form-group pr-1">
                    <input type="submit" class="btn btn-info edit-sede" value="Editar">
                  </div>
                </form>
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
        <h6>Aún no hay ninguna sede ceada</h6>
    @endif
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


  $('.delete-sede').click(function(e){
      e.preventDefault() // Don't post the form, unless confirmed
      if (confirm('¿Seguro que deseas borrar la sede?')) {
          // Post the form
          $(e.target).closest('form').submit() // Post the surrounding form
      }
  });
</script>
@endsection
