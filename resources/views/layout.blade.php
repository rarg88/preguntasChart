<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Preguntas</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

        <style>
            body {
                font-family: 'Nunito';
            }

            .bg-green {
              background: rgb(65, 121, 205);
              /* background: linear-gradient(45deg, rgba(60,128,118,1) 40%, rgba(143,183,177,1) 100%); */
            }

            .col-preguntas {
              flex: 0 0 12%;
              max-width: 12%;
            }

            .lh-05{
              line-height: 0.5;
            }

            #overlayContainer {
              position: absolute;
              left: 125px;
              top: 65px;
              overflow: auto;
              background: rgb(65, 121, 205);
              /* background: linear-gradient(45deg, rgba(60,128,118,1) 40%, rgba(143,183,177,1) 100%); */
            }

            #overlay {
              opacity: .5;
              width: 1020px;
              height: 450px;
            }

            #legend ul {
                list-style: none;
                white-space: nowrap;
                color: white;
                text-align: center;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            #legend li {
              display: inline-block;
              margin-right: 5px;
              margin-left: 5px;
            }
            #legend li span {
              width: 36px;
              height: 12px;
              display: inline-block;
              margin: 0 0 8px 0;
              vertical-align: -9.4px;
            }
        </style>
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <script src="/js/icons.min.js"></script>

    </head>
    <body>
      <main role="main">
          @yield('content')
      </main>

      @yield('scripts')
    </body>
</html>