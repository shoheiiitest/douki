@extends('Layouts.app')
@section('title','プロジェクト新規登録')
@section('content')
    <div id="CtrProjects">
        <rise-loader :loading="loading"></rise-loader>
        <div class="form-group">
                <label class="text-info">プロジェクト名</label>
                <input type="text" class="form-control" v-model="project_name">
                <span v-cloak v-if="errors.project_name != undefined" class="text-danger" v-html="errors['project_name'][0]"></span>
        </div>
        <div class="m-4">
            <button @click="submit" class="btn-info text-white p-2 rounded-lg">登録する</button>
        </div>
    </div>
@endsection
@section('style')
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/projects/create.js')  }}" charset="utf-8"></script>
@endsection
