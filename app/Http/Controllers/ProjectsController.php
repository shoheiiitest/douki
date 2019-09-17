<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    public function index(){
        $projects = new Project();
        $projects = $projects->get();
        return view('projects/index',[
            'projects' => $projects
        ]);
    }

    public function create(){
        return view('projects/create',[

        ]);
    }

    public function submit(Request $request){
        $messages = Lang::get('validation',[], 'ja'); // 取得したい言語を第3引数に設定
        $attributes = [
                'project_name' => 'プロジェクト名'
        ];
        $data = $request->all();
        $ruleValid = [
            'project_name' => 'required|max:20'
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
