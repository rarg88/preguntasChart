@extends('layout')

@section('content')

<div class="container-fluid bg-green">
  <div class="container">
    <div class="row">
      <div class="chart-container col-12 mb-5">
        <canvas id="myChart" aria-label="Hello ARIA World" role="img"></canvas>
      </div>
    </div>

    <div class="row">
    
      <div class="col-12 py-3">
        <a href="{{ route('home') }}"><button class="btn btn-info">Home</button></a>
        <a href="/preguntas/create"><button class="btn btn-info">Pregunta nueva</button></a>
        <button class="btn btn-info" id="show">Mostrar</button>
        @if($prev)
          <a href="/preguntas/{{ $prev->id }}"><button class="btn btn-info"><i class="fal fa-arrow-left"></i> Previous</button></a>
        @endif
        @if($next)
          <a href="/preguntas/{{ $next->id }}"><button class="btn btn-info">Next <i class="fal fa-arrow-right"></i></button></a>
        @endif
      </div>

      @isset($update)
        <div class="col-12 py-3">
          <div class="alert alert-success alert-dismissible show" role="alert">
            ¡<strong>Pregunta</strong> actualizada correctamente!
          </div>
        </div>
      @endisset
      @isset(request()->updateRespuestas)
        <div class="col-12 py-3">
          <div class="alert alert-success alert-dismissible show" role="alert">
            ¡<strong>Respuestas</strong> actualizadas correctamente!
          </div>
        </div>
      @endisset

      <div class="col-12 text-white py-3">
        <form method="post" action="/preguntas/{{ $pregunta->id }}">
          @csrf
          @method('PUT')
          <div class="form-group row">
            <div class="col-2">
              <label for="pregunta" class="col-form-label">Pregunta</label>
            </div>
            <div class="col-8">
              <input type="text" class="form-control" name="pregunta" id="pregunta" value="{{ $pregunta->pregunta }}"><br>
            </div>
            <div class="col-2">
              <input type="submit" class="btn btn-info" name="sendQuestion" value="Enviar Pregunta" id="sendQuestion">
            </div>
          </div>
        </form>
      </div>

      <div class="col-12 text-white py-3">
        <form method="post" action="/respuestas/">
          @csrf
          @method('PUT')
          <div class="form-group row">
            @foreach ($respuestas as $respuesta)
            <div class="col-12 col-sm-6">
              <div class="row">
                <label for="{{ $respuesta->sede->sede }}" class="col-sm-6 col-form-label">{{ $respuesta->sede->sede }}</label>
                <div class="col-sm-6">
                  <input type="number" class="form-control" name="respuesta[{{ $respuesta->id }}]" id="{{ $respuesta->sede->sede }}" value="{{ $respuesta->respuesta }}" min="0" max="100"><br>
                </div>
              </div>
            </div> 
            @endforeach
            <div class="col-12 col-sm-6 text-right">
              <input type="submit" class="btn btn-info" name="sendData" value="Enviar Respuestas" id="sendData">
            </div>
            <input type="hidden" name="pregunta_id" value="{{ $pregunta->id }}">
          </div>
        </form>
      </div>

    </div>
  </div>
</div>    


@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  <script>
    $(document).ready(function() {
      setTimeout(function() {
        $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-dismissible").alert('close');
        });   
      }, 3000);
    });

    const labels = {!! json_encode($sedes) !!}
    const images = ['/img/AMARILLO_SMALL.png', '/img/MARRON_SMALL.png', '/img/AZUL_SMALL.png', '/img/ROJO_SMALL.png', '/img/NARANJA_SMALL.png', '/img/VERDE_SMALL.png', '/img/MORADO_SMALL.png'];

    var titulo = "{!! $pregunta->pregunta !!}";
    titulo = titulo.match(/.{1,80}/g);
    var config = {
      type: 'horizontalBar',
        plugins: [{
          afterDraw: chart => {      
            var ctx = chart.chart.ctx; 
            var xAxis = chart.scales['x-axis-0'];
            var yAxis = chart.scales['y-axis-0'];
            yAxis.ticks.forEach((value, index) => {  
              var y = yAxis.getPixelForTick(index);      
              var image = new Image();
              image.src = images[index];
              ctx.drawImage(image, xAxis.left - 100, y -30);
            });      
          }
        }],
        data: {
            labels: labels,
            datasets: [{
                label: '%',
                data: {{ json_encode($data) }},
                backgroundColor: [
                    'rgba(250, 219, 58, 1)',
                    'rgba(192, 95, 40, 1)',
                    'rgba(82, 169, 230, 1)',
                    'rgba(212, 47, 29, 1)',
                    'rgba(227, 139, 34, 1)',
                    'rgba(91, 189, 75, 1)',
                    'rgba(119, 43, 155, 1)'
                ],
                borderColor: [
                    'rgba(250, 219, 58, 1)',
                    'rgba(192, 95, 40, 1)',
                    'rgba(82, 169, 230, 1)',
                    'rgba(212, 47, 29, 1)',
                    'rgba(227, 139, 34, 1)',
                    'rgba(91, 189, 75, 1)',
                    'rgba(119, 43, 155, 1)'
                ],
                borderWidth: 1,
                hidden: true,
            }]
        },
        options: { 
            scales: {
              xAxes: [{
                  display: true,
                  ticks: {
                    beginAtZero: true,
                    max:100,
                    fontColor: "white",
                    fontSize: 14,
                  },
                  gridLines: { color: "transparent" }
              }],
              yAxes: [{
                  display: false
              }]
            },
            title: {
              display: true,
              text: titulo ,
              fontColor: "white",
              fontSize: 22,
            },
            legend: {
                display: false,
                labels: {
                    // This more specific font property overrides the global property
                    fontColor: 'white',
                }
            },
            layout: {
              padding: {
                  left: 150,
                  right: 0,
                  top: 20,
                  bottom: 0
              }
            },
            plugins: {
              datalabels: {
                anchor: 'end',
                align: 'start',
                color: 'white',
                formatter: function (value) {
                  return value + '%';
                },
                font: {
                  size: 22,
                  weight: 'bold',
                }
              },
            }
        },
    };

    var ctx = document.getElementById('myChart').getContext('2d');
    var hidden = true;
    var myChart = new Chart(ctx, config);


    function addData(chart, label, data) {
      chart.data.datasets.forEach((dataset) => {
          dataset.data.push(data);
      });
      
    }

    function removeData(chart) {
        chart.data.datasets.forEach((dataset) => {
            dataset.data.pop();
        });
    }

    $('#show').click(function(e){
      myChart.destroy();
      myChart = new Chart(ctx, config);
      hidden = hidden ? false : true;
      myChart.options.plugins.datalabels.display = !hidden;
      myChart.data.datasets[0].hidden = hidden;
      myChart.update();
      $('#show').html('Mostrar');
      
      if(!hidden){
        myChart.destroy();
        myChart = new Chart(ctx, config);
        myChart.options.plugins.datalabels.display = !hidden;
        $('#show').html('Esconder');
        myChart.update({
          duration: 2000,
          lazy: false,
          easing: 'easeOutBounce'
        });

      }
    });
  </script>
@endsection
