<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Header;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HeadersController extends Controller
{


    public function list($project_id){
        return view('headers/list',[
            'project_id' => $project_id,
        ]);
    }

    public function create($project_id){
        $col_types = config('params.headers.col_types');
        unset($col_types[0]);//"結果"はリストさせないので削除
        return view('headers/create',[
            'title' => 'カラム追加',
//            'col_types' => $col_types,
        ]);
    }

    public function getColTypes(){
        $col_types = config('params.headers.col_types');
        unset($col_types[0]);//"結果"はリストさせないので削除
        return response()->json([
            'col_types' => $col_types,
        ]);
    }

    public function getItems($project_id){
        $headers = new Header();
        $data = $headers
            ->where('project_id',$project_id)
            ->orderBy('order_num','asc')
            ->get();

        $col_types = config('params.headers.col_types');

//        foreach ($data as $k => $v){
//            $data[$k]['col_name_'.$k] = $v->col_name;
//        }
        return response()->json([
            'headers' => $data,
            'col_types' => $col_types,
        ]);
    }

    public function submitHeaders(Request $request){
        $data = $request->all();
        $counter = $data['counter'];
        $messages = Lang::get('validation',[], 'ja'); // 取得したい言語を第3引数に設定

        for ($i=0; $i<$counter; $i++){
            $attributes[strval($i).'.col_name'] = trans('public.headers.col_name').strval($i+1);

        }

        $ruleValid = [
            '*.col_name' => 'required|max:10',
        ];
        $validator = Validator::make( $data['data'], $ruleValid,$messages,$attributes);
        if($validator->fails()){
            return response()->json([
                'success'=>FALSE,
                'message'=> $validator->errors(),
                'data' => $data
            ]);
        }

        DB::beginTransaction();
        try {

            $project_id = $data['project_id'];
            $count = $data['counter'];
            $headers = $data['data'];
            foreach($headers as $k => $header){
                $h = Header::firstOrNew(['id' => $header['id']]);
//                $h->firstOrCreate(
//                    ['id' => $header['id']],
//                    [
//                        'col_name' => $header['col_name'],
//                        'project_id' => $project_id,
//                        'disp_flg' => 1,
//                    ]
//                );
                $h->col_name = $header['col_name'];
                $h->project_id = $project_id;
                $h->disp_flg = 1;
                $h->save();

                if(!$h->save()){
                    return response()->json([
                        'success' => false,
                    ]);
                }
            }


            DB::commit();

            return response()->json([
                'success' => true,
            ]);

        }catch(\Exception $ex){
            DB::rollBack();

            return response()->json([
                'success' => false,
            ]);
        };
    }

    public function editDispFlg(Request $request){
        $data = $request->all();
        $header = new Header();
        $header = $header->where('id',$data['header_id'])->first();
        $header->disp_flg = $data['disp_flg'];

        $header->save();

        if(!$header->save()){
            return response()->json([
                'success' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'header' => $header,

        ]);
    }


    public function moveOrder(Request $request){
        $headerIds = $request->all()['headerIds'];
        foreach ($headerIds as $k => $headerId){
            $header = new Header();
            $header = $header->find($headerId);
            $header->order_num = $k+1;

            $header->save();

            if(!$header->save()){
                return response()->json([
                    'success' => false,
                ]);
            }
        }

        $header = new Header();
        $headers = $header->find($headerIds);

        return response()->json([
            'success' => true,
            'headers' => $headers,

        ]);

    }
}
