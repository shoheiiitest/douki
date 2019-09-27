<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sheet;
use App\Header;
use App\Cases;
use App\CaseContent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class SheetsController extends Controller
{
    public function index($project_id){
        $sheets = new Sheet();
        $sheets = $sheets->where('project_id',$project_id)->get();
        return view('sheets/index',[
            'project_id' => $project_id,
            'sheets' => $sheets
        ]);
    }

    public function create($project_id){
        return view('sheets/create',[
            'mode' => 'create',
            'title' => 'シート追加',
            'project_id' => $project_id,
        ]);
    }

    public function edit($project_id,$sheet_id){

        return view('sheets/create',[
            'mode' => 'edit',
            'title' => 'シート編集',
            'project_id' => $project_id,
            'sheet_id' => $sheet_id,
        ]);
    }

    public function getItems($mode,$project_id,$sheet_id = null){
        $headers = new Header();
        $headers = $headers
            ->where('project_id',$project_id)
            ->where('disp_flg','1')
            ->orderBy('order_num','asc')->get();
        $returnHeaders = [];
        $retrunColTypes = [];
        for ($i=0; $i<count($headers); $i++){
            $returnHeaders[$i] = $headers[$i]->col_name;
            $retrunColTypes[$i] = $headers[$i]->col_type;
        }

        if($mode=='create'){
            return response()->json([
                'headers' => $returnHeaders,
                'colTypes' => $retrunColTypes,
                'success' => true,
            ]);
        }elseif($mode=='edit'){
            $data = [];

            $sheet = new Sheet();
            $sheet_name = $sheet->find($sheet_id)->sheet_name;

            $case = new Cases();
            $caseIds = $case
                ->where('sheet_id',$sheet_id)
                ->pluck('id')
                ->toArray();

            foreach($caseIds as $index => $casId){
                $case_contents = new CaseContent();
                $case_contents = $case_contents
                    ->join('m_headers','m_headers.id','m_case_contents.header_id')
                    ->where('m_case_contents.case_id',$casId)
                    ->where('m_headers.disp_flg','1')
                    ->orderBy('m_headers.order_num','asc')
                    ->get();
                foreach($case_contents as $i => $case_content){
                    $data[$index][$i] = $case_content->content;
                }
            }

            return response()->json([
                'headers' => $returnHeaders,
                'sheet_name' => $sheet_name,
                'colTypes' => $retrunColTypes,
                'data' => $data,
                'success' => true,
            ]);


        }

    }

    public function submit(Request $request){
        $data = $request->all();
        $project_id = $data['project_id'];
        $sheet_name = $data['sheet_name'];
        $cases_data = $data['cases'];

        $messages = Lang::get('validation',[], 'ja'); // 取得したい言語を第3引数に設定
        $attributes = [
            'sheet_name' => 'シート名'
        ];
        $ruleValid = [
            'sheet_name' => 'required|max:20'
        ];
        $validator = Validator::make( $data, $ruleValid,$messages,$attributes);
        if($validator->fails()){
            return response()->json([
                'success'=>FALSE,
                'message'=> $validator->errors()
            ]);
        }


        DB::beginTransaction();
        try {
            //m_sheetsにレコード1件追加
            $Sheet = new Sheet();
            $Sheet->project_id = $project_id;
            $Sheet->sheet_name = $sheet_name;
            $Sheet->sheet_no = $Sheet->getMaxSheetNo($project_id);
            $Sheet->save();
            if(!$Sheet->save()){
                DB::rollBack();
                return response()->json([
                    'success' => false,
                ]);
            }

            //m_casesにヘッダー数分のレコードを追加
            $sheet_id = $Sheet->id;
            $sheet_no = $Sheet->sheet_no;

            $Header = new Header();
            $Headers = $Header
                ->where('project_id',$project_id)
                ->where('disp_flg',1)
                ->orderBy('id','asc')
                ->get();

            $case_no = 1;

            foreach($cases_data as $index => $case){
                if($index == (count($cases_data)-1) ){
                    break;
                }
                $Cases = new Cases();
                $Cases->project_id = $project_id;
                $Cases->sheet_id = $sheet_id;
                $Cases->sheet_no = $sheet_no;
                $Cases->case_no = $case_no;
                $Cases->save();

                if(!$Cases->save()){
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                    ]);
                }
                $case_no++;
                $case_id = $Cases->id;

                //各ヘッダー項目に対してm_case_contentsにレコードを登録
                foreach($Headers as $i => $h){
                    $CaseContent = new CaseContent();
                    $CaseContent->project_id = $project_id;
                    $CaseContent->header_id = $h->id;
                    $CaseContent->sheet_id = $sheet_id;
                    $CaseContent->case_id = $case_id;
                    $CaseContent->content = $cases_data[$index][$i];
                    $CaseContent->save();

                    if(!$CaseContent->save()){
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                        ]);
                    }
                }

            }

            DB::commit();

            return response()->json([
                'success' => true,
            ]);

        }catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                'success' => false,
            ]);
        }
    }
}
