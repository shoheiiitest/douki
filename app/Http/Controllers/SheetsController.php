<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sheet;
use App\Header;
use App\Cases;
use App\CaseContent;
use App\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use App\Exports\SheetExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $returnColTypes = [];
        $items = [];
        for ($i=0; $i<count($headers); $i++){
            $returnHeaders[$i] = $headers[$i]->col_name;
            $returnColTypes[$i] = $headers[$i]->col_type;
            if($returnColTypes[$i]==4){
                $item = new Item();
                $items[$i] = $item->where('header_id',$headers[$i]->id)->pluck('item_name')->toArray();
            }

        }

        if($mode=='create'){
            return response()->json([
                'headers' => $returnHeaders,
                'colTypes' => $returnColTypes,
                'items' => $items,
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
                'colTypes' => $returnColTypes,
                'items' => $items,
                'data' => $data,
                'success' => true,
            ]);


        }

    }

    public function submit(Request $request){
        $data = $request->all();
        $mode = $data['mode'];
        $sheet_id = $data['sheet_id'];
        $project_id = $data['project_id'];
        $sheet_name = $data['sheet_name'];
        $cases_data = $data['cases'];
        $afterUpdateCount = count($cases_data);
        if($mode=='edit'){
            $Cases = new Cases();
            $beforeUpdateCount = $Cases->where('sheet_id',$sheet_id)->count();
        }

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
            if($mode=='edit'){
                $Sheet = $Sheet->find($sheet_id);
                $Sheet->sheet_name = $sheet_name;
            }else{
                $Sheet->project_id = $project_id;
                $Sheet->sheet_no = $Sheet->getMaxSheetNo($project_id);
                $Sheet->sheet_name = $sheet_name;

            }
                $Sheet->save();
                if(!$Sheet->save()){
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                    ]);
                }

                $sheet_id = $Sheet->id;
                $sheet_no = $Sheet->sheet_no;


            //m_casesにヘッダー数分のレコードを追加

            $Header = new Header();
            $Headers = $Header
                ->where('project_id',$project_id)
                ->where('disp_flg',1)
                ->orderBy('id','asc')
                ->get();

            $case_no = 1;

            foreach($cases_data as $index => $case){
//                if(($index == (count($cases_data)-1)) && $mode =='create' ){
//                    break;
//                }
                $Cases = new Cases();
                $Cases = $Cases->updateOrCreate(
                    ['sheet_id' => $sheet_id,'case_no' => $case_no],
                    [
                        'project_id' => $project_id,
                        'sheet_id' => $sheet_id,
                        'sheet_no' => $sheet_no,
                        'case_no' => $case_no
                    ]
                );
//                $Cases->project_id = $project_id;
//                $Cases->sheet_id = $sheet_id;
//                $Cases->sheet_no = $sheet_no;
//                $Cases->case_no = $case_no;
//                $Cases->save();

//                if(!$Cases->save()){
//                    DB::rollBack();
//                    return response()->json([
//                        'success' => false,
//                    ]);
//                }
                $case_no++;
                $case_id = $Cases->id;

                //各ヘッダー項目に対してm_case_contentsにレコードを登録
                foreach($Headers as $i => $h){
                    $CaseContent = new CaseContent();
                    $CaseContent->updateOrCreate(
                        ['sheet_id' => $sheet_id, 'case_id' => $case_id, 'header_id' => $h->id],
                        [
                            'project_id' => $project_id,
                            'header_id' => $h->id,
                            'sheet_id' => $sheet_id,
                            'case_id' => $case_id,
                            'content' => $cases_data[$index][$i],
                        ]
                    );
//                    $CaseContent->project_id = $project_id;
//                    $CaseContent->header_id = $h->id;
//                    $CaseContent->sheet_id = $sheet_id;
//                    $CaseContent->case_id = $case_id;
//                    $CaseContent->content = $cases_data[$index][$i];
//                    $CaseContent->save();

//                    if(!$CaseContent->save()){
//                        DB::rollBack();
//                        return response()->json([
//                            'success' => false,
//                        ]);
//                    }
                }

            }

            if($mode=='edit' && ($afterUpdateCount < $beforeUpdateCount)){
                $Cases = new Cases();
                $CaseContent = new CaseContent();
                $deleteCount = $beforeUpdateCount - $afterUpdateCount;
                $Cases = $Cases->where('sheet_id',$sheet_id)->orderBy('case_no','asc')->get();
                $deleteCaseIds = [];
                for($i=$afterUpdateCount; $i<$beforeUpdateCount; $i++){
                    $deleteCaseIds[$i] = $Cases[$i]->id;
                    $Cases[$i]->delete();
                }

                foreach ($deleteCaseIds as $k => $case_id){
                    $CaseContent->where('case_id',$case_id)->delete();
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

    public function export($project_id,$sheet_id)
    {
//        $export = new SheetExport([[1, 2, 3], [4, 5, 6]]);
        $export = new SheetExport($project_id,$sheet_id);
        return Excel::download($export, 'sheet.xlsx');
    }
}
