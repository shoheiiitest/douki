@extends('Layouts.app')
@section('title','シート一覧')
@section('content')
    <div id="CtrSheets">
        <div class="m-4">
            <button onclick="location.href='/sheets/create/{{ $project_id }}'" class="btn-info text-white p-2 rounded-lg">シート追加画面へ</button>
        </div>
        <ul>
        @foreach($sheets as $sheet)
        <li>
            <a href='/sheets/edit/{{ $project_id."/" }}{{ $sheet->id }}'>{{ $sheet->sheet_name }}</a>
        </li>
        @endforeach
        </ul>
    </div>
@endsection
@section('script')
@endsection
