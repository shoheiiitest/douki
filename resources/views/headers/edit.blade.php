@extends('Layouts.app')
@section('title','ヘッダー編集')
@section('content')
    <div id="CtrHeaders">
        <rise-loader :loading="loading"></rise-loader>
{{--        <div class="form-group row">--}}
{{--            <button @click="submit" class="col-1 offset-11 btn-info text-white p-2 rounded-lg">登録する</button>--}}
{{--        </div>--}}
        <div v-for="(header,index) in headers" class="form-group row">
                <span v-cloak class="text-info text-center align-self-center col-1">項目@{{ index+1 }}</span>
                <input type="text" class="form-control col-11" v-model="header['col_name']">
            <span v-cloak v-if="errors[index+'.col_name'] != undefined" class="col-11 offset-1 text-danger" v-html="errors[index+'.col_name'][0]"></span>
        </div>
        <div class="m-4">
            <button @click="submitHeaders" class="float-right btn-info text-white p-2 rounded-lg">登録する</button>
            <div class="form-group row mt-3">
                <button @click="addRow(1)" class="btn-outline-dark p-2 rounded-lg">1行追加</button>
                <div class="mr-5 ml-4 border-left border-dark"></div>
                <input type="text" class="col-1 m-2 form-control" v-model="add">
                <button @click="addRow(add)" class="btn-dark p-2 rounded-lg">行追加</button>
                <span class="ml-2 mb-1 align-self-end">※追加したい行数分入力してボタン押下</span>
            </div>
        </div>
    </div>
@endsection
@section('style')
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/headers/edit.js')  }}" charset="utf-8"></script>
@endsection
