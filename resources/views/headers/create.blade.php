@extends('Layouts.app')
@section('title',$title)
@section('content')
    <div id="CtrHeaders" class="mb-5">
        <rise-loader :loading="loading"></rise-loader>
        <div class="form-group row">
            <label for="" class="col-2 text-center align-self-center">カラム名</label>
            <input type="text" id="" class="form-control col-10" v-model="col_name">
        </div>
        <div class="form-group row">
            <label for="" class="col-2 text-center align-self-center">タイプ</label>
{{--            <input type="" id="" class="form-control col-10" v-model="col_name">--}}
            <select name="" id="" v-model="selecting">
                <option v-for="(col_type,index) in col_types" :key="index" :value="index">@{{ col_type }}</option>
            </select>
        </div>
    </div>
@endsection
@section('style')
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/headers/create.js')  }}"></script>
@endsection
