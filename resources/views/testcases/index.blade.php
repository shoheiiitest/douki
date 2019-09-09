@extends('Layouts.app')
@section('title','検索')
@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach($headers as $header)
                <th>{{ $header->col_name  }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
@endsection
