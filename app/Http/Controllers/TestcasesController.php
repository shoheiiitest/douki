<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Header;

class TestcasesController extends Controller
{
        public function index(Request $request){
            $project_id = "1";
            $headers = new Header();
            $headers = $headers->getHeaders($project_id);
//            $headers = $headers
//                ->select('col_name')
//                ->where('project_id',$project_id)
//                ->where('disp_flg','1')
//                ->get();

            return view('testcases/index',[
                'headers' => $headers
            ]);

        }


        public function create(){

            return view('testcases/create');

        }
}
