@extends('layout')

@section('content')
    <table>
        <thead>
        <tr>
            @foreach(array_first($results) as $name => $time)
                <th>{{ $name }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($results as $tests)
            <tr>
                @foreach($tests as $time)
                    <td>{{ $time }}s</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
        <tbody>
        <tr>
            <td colspan="{{ count($avg) }}">Average times</td>
        </tr>
        <tr>
            @foreach($avg as $time)
                <td>{{ $time }}s</td>
            @endforeach
        </tr>
        </tbody>
    </table>
@endsection
