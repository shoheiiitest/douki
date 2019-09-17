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
            <tr v-for="(caseContent,caseId) in caseContents" :class="'row' + '_' + caseId">
                <td  v-cloak v-for="(content,headerId) in caseContent" @dblclick="editColumns(caseId,headerId)">
                    <div :class="'label' + '_' + caseId + '_' +  headerId" v-html="content"></div>
                    <div style="display:none;" :class="'edit' + '_' + caseId + '_' +  headerId">
                        <i  @click.stop="closeEdit(caseId,headerId)" class="fas fa-times fa-lg text-danger mousepointer-hand float-left m-1"></i>
                        <i  @click.stop="submitContents(caseId,headerId)" class="fas fa-check-square fa-lg text-info mousepointer-hand float-left m-1"></i>
                        <textarea v-html="content"></textarea>
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
    <script type="text/javascript"  src="{{ mix('js/controller/testcases/index.js')  }}" charset="utf-8"></script>
@endsection
