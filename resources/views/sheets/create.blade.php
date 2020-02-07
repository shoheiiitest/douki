@extends('Layouts.app')
@section('title',$title)
@section('content')
    <div id="CtrSheets">
        <rise-loader :loading="loading"></rise-loader>
        <div v-cloak v-if="show" class="success-message-bg">
            <transition name="slideY" appear>
                <h3 class="text-center success-message">取り込みに成功しました(まだDBには保存されておりませぬ)</h3>
            </transition>
        </div>
        <div class="input-group">
            <div class="custom-file col-12 mb-3">
                <input @change="upFile($event,'customFile')" type="file" class="custom-file-input" id="customFile">
                <label v-cloak class="custom-file-label" for="customFile" data-browse="参照">@{{ file_name!='' ? file_name:'ファイル選択...' }}</label>
            </div>
            <div class="input-group-append mb-3">
                <button class="btn btn-outline-secondary reset">取消</button>
                <button @click="setImportFile" class="btn btn-dark">取り込み</button>
            </div>
        </div>
        <div class="form-group">
            <label class="text-info">シート名</label>
            <input type="text" class="form-control" v-model="sheet_name">
            <span v-cloak v-if="errors.sheet_name != undefined" class="text-danger" v-html="errors['sheet_name'][0]"></span>
        </div>
        <div class="m-4">
            @if($mode=='create')
                <button @click="submit('{{ $mode}}',{{ $project_id }})" class="btn-info text-white p-2 rounded-lg">登録する</button>
            @elseif($mode=='edit')
                <button @click="submit('{{ $mode }}',{{ $project_id }},{{ $sheet_id }})" class="btn-info text-white p-2 rounded-lg">保存する</button>
                <button @click="exportSheet('{{ $project_id }}','{{ $sheet_id }}')" class="btn-dark text-white p-2 rounded-lg float-right">DBから出力</button>
            @endif
        </div>
        <div v-cloak class="mb-5" @keyup.ctrl.shift.83="submit('{{ $mode}}','{{ $project_id }}','{{ ($mode=='edit') ? $sheet_id:null }}')">
            <hot-table :root="root" :settings="hotSettings" ref="testHot"></hot-table>
        </div>
        <div v-cloak class="m-4">
            <button onclick="location.href='/sheets/{{ $project_id }}'" class="btn-dark p-2 rounded-lg">戻る</button>
            @if($mode=='create')
                <button @click="submit('{{ $mode}}',{{ $project_id }})" class="btn-info text-white p-2 rounded-lg">登録する</button>
            @elseif($mode=='edit')
                <button @click="submit('{{ $mode }}',{{ $project_id }},{{ $sheet_id }})" class="btn-info text-white p-2 rounded-lg">保存する</button>
            @endif
        </div>
    </div>
@endsection
@section('style')
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/sheets/create.js')  }}" charset="utf-8"></script>
@endsection
