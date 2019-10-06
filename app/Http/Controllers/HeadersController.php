<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Header;
use App\Item;
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
        $mode = 'create';
        return view('headers/create',[
            'title' => 'カラム追加',
            'project_id' => $project_id,
            'mode' => $mode,
        ]);
    }

    public function edit($project_id,$header_id){
        $header = new Header();
        $header = $header->find($header_id);
        $col_types = config('params.headers.col_types');
        unset($col_types[0]);//"結果"はリストさせないので削除
        $mode = 'edit';
        return view('headers/create',[
            'title' => 'カラム編集',
            'project_id' => $project_id,
            'mode' => $mode,
            'header' => $header,
        ]);
    }

    public function getColTypes($mode,$header_id = null){
        $col_types = config('params.headers.col_types');
        unset($col_types[0]);//"結果"はリストさせないので削除

        $returnData = [];
        $header = null;
        if($mode == 'edit'){
            $header = new Header();
            $header = $header->find($header_id);
            if($header->col_type=='4'){
                $item = new Item();
                $items = $item->where('header_id',$header->id)->orderBy('order_num','asc')->get();
                $item_names = [];
                foreach($items as $k => $i){
                    $item_names[$k] = $i->item_name;
                }
                $returnData['items'] = $item_names;
            }
        }
        $returnData['col_types'] = $col_types;
        $returnData['header'] = $header;

        return response()->json($returnData);
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

    public function submit(Request $request){
        $data = $request->all();
        $project_id = $data['project_id'];
        $mode = $data['mode'];
        $header_id = $data['header_id'];
        $col_name = $data['col_name'];
        $col_type = $data['col_type'];
        $items = $data['items'];

        $attributes = [
            'col_name' => trans('public.headers.col_name'),
            'items.*' =>  trans('public.headers.items'),
        ];

        $ruleValid = [
            'col_name' => 'required|max:50',
            'items.*' => 'required|max:50',
        ];

        $validator = Validator::make( $data, $ruleValid,[],$attributes);
        if($validator->fails()) {
            return response()->json([
                'success' => FALSE,
                'message' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $header = new Header();

            if ($mode == 'create') {
                $order_num = $header->where('project_id', $project_id)->max('order_num') + 1;
                $header->project_id = $project_id;
                $header->col_name = $col_name;
                $header->col_type = $col_type;
                $header->order_num = $order_num;
                $header->disp_flg = 1;
            } else {
                $header = $header->find($header_id);
                $header->col_name = $col_name;
            }
            $header->save();

            if (!$header->save()) {
                return response()->json([
                    'success' => false,
                ]);
            }

            if($header->col_type == '4'){
                $num = 1;
                $item = new Item();
                foreach($items as $item_name){
                    $item = new Item();
                    $item->updateOrCreate(
                        [
                            'order_num' => $num,
                            'header_id' => $header->id,
                        ],
                        [
                            'header_id' => $header->id,
                            'item_name' => $item_name,
                            'order_num' => $num,
                        ]
                    );

                    $num++;
                }

            }

            DB::commit();


        }catch(\Exception $ex){
            DB::rollBack();

            return response()->json([
                'success' => false,
            ]);
        };


        return response()->json([
            'success' => true,
            'header_id' => $header->id,
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
                $h->firstOrCreate(
                    ['id' => $header['id']],
                    [
                        'col_name' => $header['col_name'],
                        'project_id' => $project_id,
                        'disp_flg' => 1,
                    ]
                );
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
