<!doctype html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ URL::asset('build/images/logo-escuela.png') }}" type="image/png">
    <title>@yield('title') | Proyecto de Integración</title>

    @yield('css')

    @include('Layout.head-css')

</head>

<body>

@include('Layout.topbar')
@include('Layout.sidebar')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">

        @yield('content')

    </div>
</main>
<!--end main wrapper-->

<!--start overlay-->
    <div class="overlay btn-toggle"></div>
<!--end overlay-->

  @include('Layout.footer')

  @include('Layout.cart')

  @include('Layout.right-sidebar')

  @include('Layout.vendor-scripts')

  @yield('scripts')

</body>
  
</html>
