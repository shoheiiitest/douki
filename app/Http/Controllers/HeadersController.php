<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Header;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HeadersController extends Controller
{
    protected $fillable = [
        'id'
    ];


    public function edit($project_id){
        return view('headers/edit',[

        ]);
    }

    public function getItems($project_id){
        $headers = new Header();
        $data = $headers
            ->where('project_id',$project_id)
            ->orderBy('id','asc')
            ->get();

        foreach ($data as $k => $v){
            $data[$k]['col_name_'.$k] = $v->col_name;
        }
        return response()->json([
            'headers' => $data,
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
}
