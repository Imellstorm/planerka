<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
        <link rel='stylesheet' href="{{ asset('assets/css/font-awesome.min.css') }}">
        @yield('styles')
        <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">

        <script src="{{ asset('assets/js/jquery-1.9.1.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        @yield('scripts')
    </head>

    <body>
        <div class="container">

            @include('containers.navigation_admin')

            @if ($errors->has())
                @foreach ($errors->all() as $error)
                    <div class='bg-danger alert'>
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        {{ $error }}
                    </div>
                @endforeach
            @endif

            @if (Session::has('success'))
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <span class="glyphicon glyphicon-info-sign"></span>
                    <span>{{ Session::get('success') }}</span>
                </div>
            @endif

            @yield('main')
        </div>

    </body>

</html>