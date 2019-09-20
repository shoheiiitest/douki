<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Header;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HeadersController extends Controller
{
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
        return response()->json([
            'headers' => $data,
        ]);
    }

    public function submitHeaders(Request $request){
        $messages = Lang::get('validation',[], 'ja'); // 取得したい言語を第3引数に設定
        $attributes = [
                'col_name' => '項目名'
        ];
        $data = $request->all();
        $ruleValid = [
            'col_name' => 'required|max:20'
        ];
        $validator = Validator::make( $data, $ruleValid,$messages,$attributes);
        if($validator->fails()){
            return response()->json([
                'success'=>FALSE,
                'message'=> $validator->errors()
            ]);
        }

        $project_name = $request->all()['project_name'];
        DB::beginTransaction();
        try {

            $project = new Project();
            $project->project_name = $project_name;
            $project->save();

            if(!$project->save()){
                return response()->json([
                    'success' => false,
                ]);
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
