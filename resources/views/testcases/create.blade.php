@extends('Layouts.app')
@section('title','テストケース')
@section('content')
    <form>
        <div class="form-group row">
            <label for="inputFieldName" class="col-sm-2 col-form-label">画面項目名</label>
            <div class="col-sm-10">
                <input type="textbox" class="form-control" id="inputFieldName" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputFieldNameDb" class="col-sm-2 col-form-label">DB項目名</label>
            <div class="col-sm-10">
                <input type="textbox" class="form-control" id="inputFieldNameDb" placeholder="">
            </div>
        </div>
        <fieldset class="form-group">
            <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">テスト内容</legend>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                        <label class="form-check-label" for="gridRadios1">
                            テキストボックス入力値がDBに登録
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                        <label class="form-check-label" for="gridRadios2">
                            プルダウン選択値に基づき登録
                        </label>
                    </div>
                </div>
            </div>
        </fieldset>
        <button type="button" class="btn btn-primary mt-2" >保存</button>
        <button type="submit" class="btn btn-success mt-2" >ダウンロード
            <i class="fas fa-download"></i>
        </button>
        <a href="export">export</a>
    </form>
@endsection
