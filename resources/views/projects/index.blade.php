@extends('Layouts.app')
@section('title','プロジェクト一覧')
@section('content')
    <div id="CtrProjects">
     <div class="m-4">
         <button onclick="location.href='/projects/create'" class="btn-info text-white p-2 rounded-lg">新規登録</button>
     </div>
        <ul>
        @foreach($projects as $project)
            <li>
                <a href='/sheets/{{ $project->id }}'>{{ $project->project_name }}</a>
            </li>
        @endforeach
        </ul>
    </div>
@endsection
@section('script')
@endsection
