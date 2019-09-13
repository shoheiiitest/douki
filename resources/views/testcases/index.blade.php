@extends('Layouts.app')
@section('title','テストケース一覧')
@section('content')
    <div id="CtrIndex">
        <rise-loader :loading="loading"></rise-loader>
    <table class="table table-bordered">
        <div class="m-3" v-cloak ><span><i class="far fa-angry mr-1"></i></span>  @{{ sheet.sheet_name }}</div>
        <thead>
            <tr>
                <th  v-cloak v-for="header in headers">@{{ header['col_name'] }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(caseContent,index) in caseContents">
                <td  v-cloak v-for="(content,i) in caseContent" @dblclick="editColumns(index)">
                    <div v-if="!col_show">@{{ content }}</div>
                    <div v-if="col_show">
                        <textarea v-model="caseContents[index][i]">@{{ content }}</textarea>
                        <button @click.stop="submitContents">✔</button>
                        <button @click.stop="closeEdit">x</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/index.js')  }}" charset="utf-8"></script>
@endsection
