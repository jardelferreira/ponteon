<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cadastro de Empresários</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script> 

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    
    <nav class="navbar navbar-expand-sm navbar-light bg-warning">
        <!-- <a class="navbar-brand" href="#">
          <img src="/docs/4.6/assets/brand/bootstrap-solid.svg" width="30" height="30" alt="">
        </a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a href="/" class="nav-link h3">Empresários</a>
            </li>
          </ul>
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active"><a class="nav-link h3" href="https://github.com/jardelferreira" target="_blank" rel="noopener noreferrer">Github:Jardel Ferreira</a></li>
          </ul>
        </div>
      </nav>
       @include('list') 
    {{-- {{$data->filiados}} --}}
    <style>
        ul{
            list-style-type: square;
        }
    </style>
</body>
</html>