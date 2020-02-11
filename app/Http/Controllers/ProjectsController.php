<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Project;
use App\Header;
use App\Sheet;
use App\Cases;
use App\CaseContent;
use App\Item;
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

    public function getItems(){
        $projects = new Project();
        
        $projects = $projects->orderBy('project_name','asc')->get();
        return response()->json([
            'projects' => $projects,
        ]);
    }

    public function delete(Request $request){
        $project_id = $request->all()['project_id'];
        $project = new Project();
        $headers = new Header();
        $sheets = new Sheet();
        $cases = new Cases();
        $caseContents = new CaseContent();
        $item = new Item();

        $project->destroy($project_id);
        $headers->where('project_id',$project_id)->delete();
        $sheets->where('project_id',$project_id)->delete();
        $cases->where('project_id',$project_id)->delete();
        $caseContents->where('project_id',$project_id)->delete();
        $item->where('project_id',$project_id)->delete();
//        if(!($project->destroy($project_id))){
//            return response()->json([
//               'success' => false,
//               'message' => '削除に失敗しました。'
//            ]);
//        }

        return response()->json([
           'success' => true,
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

            $headers = config('params.headers.defaults');
            $items_header_id = 0;
            foreach($headers as $i => $header){
                $headerObj = new Header();
                $headerObj->project_id = $project->id;
                $headerObj->col_name = $header['col_name'];
                $headerObj->col_type = $header['col_type'];
                $headerObj->order_num = $i+1;
                $headerObj->disp_flg = 1;
                $headerObj->save();
                if($header['col_name']==="正常/異常"){
                    $items_header_id = $headerObj->id;
                }
            }
            
            for($i=0; $i<2; $i++){
                $item = new Item();
                $item->project_id = $project->id;
                $item->header_id = $items_header_id;
                $item->item_name = ($i==0) ? "正常" : "異常";
                $item->order_num = $i+1;
                $item->save();

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
