@extends('Layouts.app')
@section('title','テストケース一覧')
@section('content')
    <div id="CtrIndex">
        <rise-loader :loading="loading"></rise-loader>
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Primary card</div>
            <div class="card-body">
                <h4 class="card-title">園田海未</h4>
                <p class="card-text">16歳の高校2年生。一人称は「私」。腰まで伸ばした、青みがかかった黒のロングヘア。好きな食べ物は穂乃果の家のまんじゅう、嫌いな食べ物は炭酸飲料。</p>
            </div>
        </div>
        <span v-cloak >@{{ sheet.sheet_name }}</span>
    <table class="table table-bordered">
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
