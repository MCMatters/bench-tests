@extends('layout.main')

@inject('router', 'Illuminate\Routing\Router')

@section('content')
    <ul>
        @foreach ($router->getRoutes() as $route)
            @if ($route->uri() === '/')
                @continue
            @endif

            <li>
                <a href="{!! url($route->uri()) !!}">{{ $route->getActionName() }}</a>
            </li>
        @endforeach
    </ul>
@endsection
