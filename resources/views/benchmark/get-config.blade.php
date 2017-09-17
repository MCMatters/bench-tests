@extends('layout.main')

@section('content')
    <h2><b>Average times:</b></h2>
    <div>
        <table>
            <tbody>
            @foreach ($avg as $name => $time)
                <tr>
                    <td><b>{{ $name }}:</b></td>
                    <td>{{ $time }}s</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($results as $tests)
        <div style="margin-top: 20px;">
            <table style="border: 1px solid black">
                <tbody>
                @foreach ($tests as $name => $time)
                    <tr>
                        <td><b>{{ $name }}:</b></td>
                        <td>{{ $time }}s</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endsection
