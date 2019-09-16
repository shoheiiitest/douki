<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\DB;

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
