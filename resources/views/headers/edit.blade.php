@extends('Layouts.app')
@section('title','ヘッダー編集')
@section('content')
    <div id="CtrHeaders">
        <rise-loader :loading="loading"></rise-loader>
        <div v-for="(header,index) in headers" class="form-group row">
                <span v-cloak class="text-info text-center align-self-center col-1">項目@{{ index+1 }}</span>
                <input type="text" class="form-control col-11" :value="header.col_name">
{{--            <span v-cloak v-if="errors.project_name != undefined" class="text-danger" v-html="errors['project_name'][0]"></span>--}}
        </div>
        <div class="m-4">
            <button class="btn-info text-white p-2 rounded-lg">登録する</button>
        </div>
    </div>
@endsection
@section('style')
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/headers/edit.js')  }}" charset="utf-8"></script>
@endsection
