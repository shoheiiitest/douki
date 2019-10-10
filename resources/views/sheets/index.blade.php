@extends('Layouts.app')
@section('title','シート一覧')
@section('content')
    <div id="CtrSheets">
        <div v-cloak v-if="show" class="success-message-bg">
            <transition name="slideY" appear>
                <h3 class="text-center success-message">保存に成功しました</h3>
            </transition>
        </div>
        <div class="m-4">
            <button onclick="location.href='/sheets/create/{{ $project_id }}'" class="btn-info text-white p-2 rounded-lg">シート追加画面へ</button>
        </div>
        <div class="input-group">
            <div class="custom-file col-12">
                <input @change="upFile($event,'customFile')" type="file" class="custom-file-input" id="customFile">
                <label v-cloak class="custom-file-label" for="customFile" data-browse="参照">@{{ file_name!='' ? file_name:'ファイル選択...' }}</label>
            </div>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary reset">取消</button>
                <button @click="submit" class="btn btn-dark">取り込み</button>
            </div>
        </div>
        <ul>
        @foreach($sheets as $sheet)
        <li>
            <a href='/sheets/edit/{{ $project_id."/" }}{{ $sheet->id }}'>{{ $sheet->sheet_name }}</a>
        </li>
        @endforeach
        </ul>
    </div>
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/sheets/index.js')  }}" charset="utf-8"></script>
@endsection
