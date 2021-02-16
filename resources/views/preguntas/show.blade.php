@extends('layout')

@section('content')

<div class="container-fluid bg-green">
  <div class="container">
    <div class="row">
      <div class="chart-container col-12 mb-5">
        <canvas id="myChart" aria-label="Hello ARIA World" role="img"></canvas>
        <div id="overlayContainer">
          <canvas id="overlay" role="img"></canvas>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 pb-3">
        <div class="row align-items-start">
          <div class="col-3">
            <a href="{{ route('home') }}" tabindex="-1"><button class="btn btn-info" tabindex="-1"><i class="fal fa-home-heart"></i></button></a>
            <a href="/preguntas/create" tabindex="-1"><button class="btn btn-info" tabindex="-1"><i class="fal fa-comment-plus"></i></button></a>
            <button class="btn btn-info" id="show" tabindex="-1"><i class="fal fa-eye"></i></button>
            @if($prev)
              <a href="/preguntas/{{ $prev->id }}" tabindex="-1"><button class="btn btn-info" tabindex="-1"><i class="fal fa-arrow-left"></i></button></a>
            @endif
            @if($next)
              <a href="/preguntas/{{ $next->id }}" tabindex="-1"><button class="btn btn-info" tabindex="-1"><i class="fal fa-arrow-right"></i></button></a>  
            @endif
          </div>
          <div class=" col-9 text-white">
            <form method="post" action="/respuestas" class="px-1 lh-05">
              @csrf
              @method('PUT')
              <div class="form-group row align-items-start">
                @foreach ($respuestas as $respuesta)
                <div class="col-preguntas px-2">
                  <div class="row flex-column">
                    <div class="col-sm-12">
                      <input type="number" class="form-control" name="respuesta[{{ $respuesta->id }}]" id="{{ $respuesta->sede->sede }}" value="{{ $respuesta->respuesta }}" min="0" max="100" tabindex="{{ $loop->iteration }}"><br>
                    </div>
                    <label for="{{ $respuesta->sede->sede }}" class="col-sm-12 col-form-label text-truncate pt-0">{{ $respuesta->sede->sede }}</label>
                  </div>
                </div> 
                @endforeach
                <div class="col-preguntas px-2">
                  <button type="submit" class="btn btn-info" id="sendData" tabindex="-1"><i class="fal fa-paper-plane"></i></button>
                </div>
                <input type="hidden" name="pregunta_id" value="{{ $pregunta->id }}">
              </div>
            </form>
          </div>
        </div>
      </div>

      @isset($update)
        <div class="alert alert-success alert-dismissible show col-12 py-3" role="alert">
          ¡<strong>Pregunta</strong> actualizada correctamente!
        </div>
      @endisset
      @isset(request()->updateRespuestas)
        <div class="alert alert-success alert-dismissible show col-12 py-3" role="alert">
          ¡<strong>Respuestas</strong> actualizadas correctamente!
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
              <input type="text" class="form-control" name="pregunta" id="pregunta" value="{{ $pregunta->pregunta }}" tabindex="-1"><br>
            </div>
            <div class="col-2">
              <input type="submit" class="btn btn-info" name="sendQuestion" value="Enviar Pregunta" id="sendQuestion" tabindex="-1">
            </div>
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
    var tituloLongitud = titulo.length;
    var tituloTop = Math.floor(tituloLongitud/80) * 20;

    $("#overlayContainer").css({top : "+=" + tituloTop + 'px'});
    $("#overlay").css({height : "-=" + tituloTop + 'px'});
    
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
            tooltips: {
              enabled: false
            },
            layout: {
              padding: {
                  left: 150,
                  right: 100,
                  top: 20,
                  bottom: 0
              }
            },
            plugins: {
              datalabels: {
                anchor: 'end',
                align: 'end',
                color: 'white',
                display: false,
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
      myChart.options.plugins.datalabels.display = false;
      // myChart.options.plugins.datalabels.color = 'transparent';
      myChart.data.datasets[0].hidden = hidden;
      $("#overlayContainer").css('left', '125px');
      $("#overlay").css('width', '1020px');
      myChart.update();
      $('#show').html('<i class="fal fa-eye"></i>');
      
      if(!hidden){
        myChart.destroy();
        myChart = new Chart(ctx, config);
        // myChart.options.plugins.datalabels.display = !hidden;
        $('#show').html('<i class="fal fa-eye-slash"></i>');
        myChart.update();
        setTimeout(function(){ 
          myChart.options.plugins.datalabels.display = !hidden;
          myChart.update(); 
        }, 6000);
        $("#overlayContainer").animate({
          left: '+=1100px',
        }, 8000);
        $("#overlay").animate({
          width: '-=1020px',
        }, 8000);
      }
    });
  </script>
@endsection
