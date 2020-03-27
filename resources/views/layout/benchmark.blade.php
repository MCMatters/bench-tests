@extends('layout.main')

@section('content')
    <bench-table :results='@json($results)'></bench-table>
@endsection
