@extends('layout.main')

@section('content')
    <h2>Average times:</h2>
    @yield('content-header')
    <table class="table table-striped table-bordered table-sm">
        <thead class="thead-inverse">
        <tr>
            <th>Test</th>
            <th>Time, s</th>
            <th>Memory, Kb</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($avg as $name => $results)
            <tr>
                <td><b>{{ $name }}</b></td>
                <td>{{ $results['time'] }}</td>
                <td>{{ $results['memory'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
