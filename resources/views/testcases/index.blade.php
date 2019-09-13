@extends('Layouts.app')
@section('title','テストケース一覧')
@section('content')
    <div id="CtrIndex">
        <rise-loader :loading="loading"></rise-loader>
    <table class="table table-bordered">
        <div class="m-3" v-cloak ><span><i class="far fa-angry mr-1"></i></span><strong class="p-2 mb-2 text-info">  @{{ sheet.sheet_name }}</strong></div>
        <thead>
            <tr>
                <th  v-cloak v-for="header in headers">@{{ header['col_name'] }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(caseContent,index) in caseContents">
                <td  v-cloak v-for="(content,i) in caseContent" @dblclick="editColumns()">
                    <div v-if="!col_show">@{{ content }}</div>
                    <div v-if="col_show" data-index="">
                        <i  @click.stop="closeEdit()" class="fas fa-times fa-lg text-danger mousepointer-hand float-right m-1"></i>
                        <i  @click.stop="submitContents()" class="fas fa-check-square fa-lg text-info mousepointer-hand float-right m-1"></i>
                        <textarea v-model="caseContents[index][i]">@{{ content }}</textarea>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
@endsection
@section('style')
    .mousepointer-hand:hover {
    cursor: pointer;
    opacity:0.7;
    };
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/index.js')  }}" charset="utf-8"></script>
@endsection
