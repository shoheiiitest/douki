@extends('Layouts.app')
@section('title','ヘッダー一覧')
@section('content')
    <div id="CtrHeaders" class="mb-5">
        <rise-loader :loading="loading"></rise-loader>
        <draggable @update="moveOrder" :options="options" id="header-list">
        <div v-for="(header,index) in headers" :key="index" :data-header-id="header.id" class="form-group row border-bottom border-secondary bg-light m-auto p-2">
            <div class="col-1 m-auto handle"><i class="fa fa-align-justify fa-2x reorder-select ui-sortable-handle"></i></div>
            <div class="col-2 custom-control custom-switch align-self-center">
                <input @click="editDispFlg(index,header.id)" type="checkbox" class="custom-control-input" :id="'customSwitch_' + header.id" :checked="(header.disp_flg==1) ? true:false">
                <label v-cloak class="custom-control-label" :for="'customSwitch_' + header.id">@{{ header.disp_text = header.disp_flg ==1 ? '使用中':'未使用中' }}</label>
            </div>
            <span v-cloak class="text-left text-info align-self-center col-5">@{{ header.col_name }}</span>
            <span v-cloak class="text-left text-info align-self-center col-2">@{{ col_types[header.col_type] }}</span>
            <button @click="toEdit(header.id,header.project_id)" class="btn btn-info form-control offset-1 col-1 m-auto">編集</button>
        </div>
        </draggable>
        <div class="m-4">
            <button onclick="location.href='/{{ $project_id }}/header/create'" class="btn-outline-dark p-2 rounded-lg">カラム追加</button>
        </div>
    </div>
@endsection
@section('style')
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/headers/list.js')  }}"></script>
@endsection
