@extends('Layouts.app')
@section('title',$title)
@section('content')
    <div id="CtrHeaders" class="mb-5">
        <rise-loader :loading="loading"></rise-loader>
        <div class="form-group row">
            <label for="" class="col-2 text-center align-self-center">カラム名</label>
            <input type="text" id="" class="form-control col-10" v-model="col_name">
            <span v-cloak v-if="errors.col_name != undefined" class="text-danger offset-2 col-10" v-html="errors['col_name'][0]"></span>
        </div>
        <div class="form-group row">
            <label for="" class="col-2 text-center align-self-center">タイプ</label>
{{--            <input type="" id="" class="form-control col-10" v-model="col_name">--}}
            <label v-cloak v-if="selecting == undefined" class="align-self-center">結果</label>
            <select v-else v-cloak v-model="selecting">
                <option v-cloak v-for="(col_type,index) in col_types" :key="index" :value="index">@{{ col_type }}</option>
            </select>
        </div>
        <div class="m-4">
            @if($mode=='create')
                <button @click="submit({{ $project_id }})" class="btn-info text-white p-2 rounded-lg">登録する</button>
            @else
                <button @click="submit" class="btn-info text-white p-2 rounded-lg">保存する</button>
            @endif
        </div>
    </div>
@endsection
@section('style')
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/headers/create.js')  }}"></script>
@endsection
