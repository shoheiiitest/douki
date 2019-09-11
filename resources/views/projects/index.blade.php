@extends('Layouts.app')
@section('title','プロジェクト一覧')
@section('content')
    <div id="CtrProjects">
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
