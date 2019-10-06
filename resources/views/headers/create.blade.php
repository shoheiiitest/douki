@extends('Layouts.app')
@section('title',$title)
@section('content')
    <div id="CtrHeaders" class="mb-5">
        <rise-loader :loading="loading"></rise-loader>
            <div v-cloak v-if="show" class="success-message-bg">
                <transition name="slideY" appear>
                    <h3 class="text-center success-message">保存に成功しました</h3>
                </transition>
            </div>
        <div class="form-group row">
            <label for="" class="col-2 text-center align-self-center">カラム名</label>
            <input type="text" id="" class="form-control col-10" v-model="col_name">
            <span v-cloak v-if="errors.col_name != undefined" class="text-danger offset-2 col-10" v-html="errors['col_name'][0]"></span>
        </div>
        <div class="form-group row">
            <label for="" class="col-2 text-center align-self-center">タイプ</label>
            <label v-cloak v-if="selecting == undefined" class="align-self-center">結果</label>
            <select @change="items = []" v-else v-cloak v-model="selecting">
                <option v-cloak v-for="(col_type,index) in col_types" :key="index" :value="index">@{{ col_type }}</option>
            </select>
        </div>
        <div v-cloak v-if="selecting==4" class="mb-5">
            <div class="text-center mt-5 mb-2">
                <strong>アイテム</strong>
            </div>
                <draggable @update="moveOrder" :options="options" id="item-list">
                    <transition-group name="slide">
                        <div v-for="(item,index) in items" :key="index" class="form-group row p-2">
                            <div class="offset-4 col-1 align-self-center handle"><i class="fa fa-align-justify fa-lg reorder-select ui-sortable-handle float-right  "></i></div>
                            <input type="text" class="form-control col-2" v-model="items[index]">
                            <div class="col-1 align-self-center"><i @click="deleteItem(index)" class="far fa-trash-alt float-left"></i></div>
                            <span v-cloak v-if="errors['items.' + index] != undefined" class="col-7 offset-5 text-danger" v-html="errors['items.'+ index][0]"></span>
                        </div>
                    </transition-group>
                </draggable>
            <div class="form-group row btn-block">
                <i @click="addItem" class="fas fa-plus-circle fa-2x float-left offset-7 col-1 my-pink"></i>
            </div>
        </div>
        <div class="m-4">
            @if($mode=='create')
                <button @click="submit('{{ $mode }}',{{ $project_id }})" class="btn-info text-white p-2 rounded-lg float-right">登録する</button>
            @else
                <button @click="submit('{{ $mode }}',{{ $project_id }},{{ $header['id'] }})" class="btn-info text-white p-2 rounded-lg float-right">保存する</button>
            @endif
        </div>
    </div>
@endsection
@section('style')
    .my-pink {color: pink}
    .fa-plus-circle,.fa-trash-alt{
    cursor:pointer;
    }
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/headers/create.js')  }}"></script>
@endsection
