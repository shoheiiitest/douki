@extends('Layouts.app')
@section('title','プロジェクト一覧')
@section('content')
    <div id="CtrProjects">
        <rise-loader :loading="loading"></rise-loader>
     <div class="m-4">
         <button onclick="location.href='/projects/create'" class="btn-primary text-white p-2 rounded-lg">新規登録</button>
     </div>
        <div class="mb-5">
            <div v-cloak v-for="project in projects" class="container-fluid">
                <div class="row">
                    <a class="h6 col-8 btn-info p-2 rounded-lg" :href="'/sheets/' + project.id">@{{ project.project_name }}</a>
                    <button @click="toEditHeaders(project.id)" class="ml-2 h6 col-2 btn-secondary text-white rounded-lg btn-xs">ヘッダー編集</button>
                    <button @click="deleteProject(project.id)" class="ml-1 h6 col-1 btn-danger text-white rounded-lg btn-xs">削除</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/projects/index.js')  }}" charset="utf-8"></script>
@endsection
