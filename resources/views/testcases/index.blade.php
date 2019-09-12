@extends('Layouts.app')
@section('title','テストケース一覧')
@section('content')
    <div id="CtrIndex">
        <div v-show="loading" class="text-center" v-show="loading">
            <div class="spinner-border text-info m-5" style="width: 10rem; height: 10rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-show="!loading">
            <span v-cloak >@{{ sheet.sheet_name }}</span>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th  v-cloak v-for="header in headers">@{{ header['col_name'] }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(caseContent,index) in caseContents">
                <td  v-cloak v-for="(content,i) in caseContent" @click="editColumns(index)">
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
    </div>
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/index.js')  }}" charset="utf-8"></script>
@endsection
