@extends('Layouts.app')
@section('title','シート一覧')
@section('content')
    <div id="CtrSheets">
        <ul>
        @foreach($sheets as $sheet)
        <li>
            <a href='/cases/{{ $project_id."/" }}{{ $sheet->id }}'>{{ $sheet->sheet_name }}</a>
        </li>
        @endforeach
        </ul>
        {{--<hot-table :data="[['key','value']]" rowHeaders="true" colHeaders="true"></hot-table>--}}
        <div id="example"></div>
    </div>
@endsection
@section('script')
    <script>
    var data = [
    ['No', 'テスト項目', '正常/異常', 'テスト条件', '備考', '実行日', '実行者', '結果'],
    ['2017', 10, 11, 12, 13],
    ['2018', 20, 11, 14, 13],
    ['2019', 30, 15, 12, 13]
    ];

    var container = document.getElementById('CtrSheets');
    var hot = new Handsontable(container, {
        data: data,
        rowHeaders: true,
        colHeaders: true,
        filters: true,
        dropdownMenu: true,
        //colWidths: 200, 列幅を指定
        contextMenu: true,
        manualColumnResize: true,
        // minSpareCols: 2,
        minSpareRows: 3,
    // licenseKey: '00000-00000-00000-00000-00000'
        licenseKey: 'non-commercial-and-evaluation'

    });
    </script>
@endsection
