@extends('Layouts.app')
@section('title','テストケース一覧')
@section('content')
    <div id="CtrIndex">
        <span>@{{ sheet.sheet_name }}</span>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th v-for="header in headers">@{{ header['col_name'] }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="caseContent in caseContents">
                <td v-for="content in caseContent">@{{ content }}</td>
            </tr>
        </tbody>
    </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/index.js')  }}" charset="utf-8"></script>
@endsection
