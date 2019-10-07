@extends('Layouts.app')
@section('title',$title)
@section('content')
    <div id="CtrSheets">
        <rise-loader :loading="loading"></rise-loader>
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
                <button @click="exportSheet('{{ $project_id }}','{{ $sheet_id }}')" class="btn-dark text-white p-2 rounded-lg float-right">出力</button>
            @endif
        </div>
        <div v-cloak class="mb-5" @keyup.ctrl.83.prevent="submit('{{ $mode}}','{{ $project_id }}','{{ ($mode=='edit') ? $sheet_id:null }}')">
            <hot-table :root="root" :settings="hotSettings" ref="testHot"></hot-table>
        </div>
        <div v-cloak class="m-4">
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
