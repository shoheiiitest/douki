@extends('Layouts.app')
@section('title','ヘッダー一覧')
@section('content')
    <div id="CtrHeaders" class="mb-5">
        <rise-loader :loading="loading"></rise-loader>
{{--        <div class="form-group row">--}}
{{--            <button @click="submit" class="col-1 offset-11 btn-info text-white p-2 rounded-lg">登録する</button>--}}
{{--        </div>--}}
        {{--<div class="form-group row border-bottom border-secondary">--}}
            {{--<span class="col-2 text-right">表示</span>--}}
            {{--<span class="col-6 text-center">カラム名</span>--}}
            {{--<span class="col-4 text-left">タイプ</span>--}}
        {{--</div>--}}
        <draggable @start="moveOrder" @end="moveOrder" :options="options">
        <div v-for="(header,index) in headers" :key="index" :data-column-id="header.id" class="form-group row border-bottom border-secondary bg-light m-auto p-2">
            <div class="col-1 m-auto handle"><i class="fa fa-align-justify fa-2x reorder-select ui-sortable-handle"></i></div>
            <div class="col-1 custom-control custom-switch align-self-center">
                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                <label class="custom-control-label" for="customSwitch1">表示</label>
            </div>
            <span v-cloak class="text-left text-info align-self-center col-6">@{{ header['col_name'] }}</span>
            <span v-cloak class="text-left text-info align-self-center col-2">@{{ col_types[header.col_type] }}</span>
            <button class="btn btn-info form-control offset-1 col-1 m-auto">編集</button>
            {{--<span v-cloak v-if="errors[index+'.col_name'] != undefined" class="col-11 offset-1 text-danger" v-html="errors[index+'.col_name'][0]"></span>--}}
        </div>
        </draggable>
            {{--<table class="table">--}}
                    {{--<td>表示</td>--}}
                    {{--<td>カラム名</td>--}}
                    {{--<td>タイプ</td>--}}
                    {{--<td>タイプ</td>--}}
                    {{--<td>タイプ</td>--}}
                {{--<tbody>--}}
                {{--<draggable @start="moveOrder" @end="moveOrder" :options="options" :element="'tbody'" :list="headers">--}}
                {{--<tr v-for="(header,index) in headers" :key="index" :data-column-id="header.id" class="">--}}
                        {{--<td><div class="handle"><i class="fa fa-align-justify fa-2x reorder-select ui-sortable-handle"></i></div></td>--}}
                        {{--<td>--}}
                            {{--<div class="custom-control custom-switch">--}}
                                {{--<input type="checkbox" class="custom-control-input" id="customSwitch1">--}}
                                {{--<label class="custom-control-label" for="customSwitch1"></label>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td><span v-cloak class="text-left text-info align-self-center">@{{ header['col_name'] }}</span></td>--}}
                        {{--<td><span v-cloak class="text-left text-info align-self-center">@{{ header['col_type'] }}</span></td>--}}
                        {{--<td><button class="btn btn-info">編集</button></td>--}}
                    {{--</tr>--}}
                {{--</draggable>--}}
                {{--</tbody>--}}
            {{--</table>--}}
        <div class="m-4">
            <button @click="" class="btn-outline-dark p-2 rounded-lg">カラム追加</button>
            {{--            <button @click="submitHeaders" class="float-right btn-info text-white p-2 rounded-lg">登録する</button>--}}
{{--            <div class="form-group row mt-3">--}}
{{--                <button @click="addRow(1)" class="btn-outline-dark p-2 rounded-lg">1行追加</button>--}}
{{--                <div class="mr-5 ml-4 border-left border-dark"></div>--}}
{{--                <input type="text" class="col-1 m-2 form-control" v-model="add">--}}
{{--                <button @click="addRow(add)" class="btn-dark p-2 rounded-lg">行追加</button>--}}
{{--                <span class="ml-2 mb-1 align-self-end">※追加したい行数分入力してボタン押下</span>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
@section('style')
    .handle{
        cursor:move;
    }
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/headers/edit.js')  }}" charset="utf-8"></script>
{{--    <script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>--}}
{{--    <script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>--}}
@endsection
