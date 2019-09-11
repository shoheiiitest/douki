@extends('Layouts.app')
@section('title','テストケース一覧')
@section('content')
    <div id="CtrIndex">
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach($headers as $header)
                <th>{{ $header->col_name  }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($caseContents as $k => $caseContent)
                <tr>
                    @foreach ($caseContent as $header_id => $content)
                        <td>{{ $content }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/index.js')  }}" charset="utf-8"></script>
@endsection
