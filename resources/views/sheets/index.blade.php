@extends('Layouts.app')
@section('title','シート一覧')
@section('content')
    <div id="CtrSheets">
        <ul>
        @foreach($sheets as $sheet)
        <li>
            <a href='/cases/{{ $project_id."/" }}{{ $sheet->id }}'>{{ $sheet->sheet_name }}</a>
        </li>
        @endforeach
        </ul>
    </div>
@endsection
@section('script')
@endsection
