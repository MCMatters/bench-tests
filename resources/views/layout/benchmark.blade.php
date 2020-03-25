@extends('layout.main')

@section('content')
    @yield('content-header')
    <table class="table table-striped table-bordered table-sm">
        <thead class="thead-inverse">
        <tr>
            <th>Test</th>
            <th>min time, s</th>
            <th>max time, s</th>
            <th>avg time, s</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($result as $name => $results)
            <tr>
                <td><b>{{ $name }}</b></td>
                <td>{{ $results['min'] }}</td>
                <td>{{ $results['max'] }}</td>
                <td>{{ $results['avg'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
