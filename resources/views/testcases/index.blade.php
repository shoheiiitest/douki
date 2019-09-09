@extends('Layouts.app')
@section('title','検索')
@section('content')
    <div id="app">
        <example-component></example-component>example-component>
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
    </div>
    <script src="{{ mix('js/app.js')  }}"></script>
@endsection
