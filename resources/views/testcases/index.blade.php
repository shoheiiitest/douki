@extends('Layouts.app')
@section('title','検索')
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
                <tr>
                    @for ($i = 0; $i < count($headers); $i++)
                        <td></td>
                    @endfor
                </tr>
        </tbody>
    </table>
    </div>
@endsection
@section('script')
    <script type="text/javascript"  src="{{ mix('js/controller/index.js')  }}" charset="utf-8"></script>
@endsection
