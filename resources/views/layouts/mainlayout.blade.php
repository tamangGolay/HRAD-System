<!doctype html>
<html lang="{{ app()->getLocale() }}">
 <head>
   @include('layouts.head')
 </head>
 <body>
@include('layouts.nav')

@yield('content')
@include('layouts.footer')
@include('layouts.footer-scripts')
 </body>
</html>
