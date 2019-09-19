@extends('Layouts.app')
@section('title','プロジェクト一覧')
@section('content')
    <div id="CtrProjects">
     <div class="m-4">
         <button onclick="location.href='/projects/create'" class="btn-primary text-white p-2 rounded-lg">新規登録</button>
     </div>
        <div class="mb-5">
        @foreach($projects as $project)
            <div class="container-fluid">
                <div class="row">
                <a class="h6 col-8 btn-info p-3 btn-block border border-success rounded-lg" href='/sheets/{{ $project->id }}'>{{ $project->project_name }}</a>
                <button onclick="location.href='/projects/create'" class="ml-1 h6 col-1 btn-danger text-white rounded-lg btn-xs">削除</button>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection
@section('script')
@endsection
