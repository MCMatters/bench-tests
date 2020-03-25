@extends('layout.main')

@section('content')
    <ul>
        @foreach (Config::get('benchmark.benchmarks') as $uri => $class)
            <li>
                <a href="{!! URL::to("/bench/{$uri}") !!}">{{ $class }}</a>
            </li>
        @endforeach
    </ul>
@endsection
