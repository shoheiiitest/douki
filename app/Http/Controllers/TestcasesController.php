<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Header;
use App\Sheet;
use App\Cases;
use App\CaseContent;

class TestcasesController extends Controller
{
        public function index($project_id,$sheet_id){
            $headers = new Header();
            $headers = $headers->getHeaders($project_id);
            $sheet = new Sheet();
            $sheet = $sheet->getSheet($project_id,$sheet_id);
            $cases = new Cases();
            $cases = $cases->getCases($sheet_id);
            $caseIds = array();
            for ($i=0; $i <count($cases); $i++){
                $caseIds[$i] = $cases[$i]->id;
            }
            $caseContents = new CaseContent();
            //$caseContents = $caseContents->getCaseContents($project_id,$sheet_id);
            $data = array();
            foreach ($caseIds as $key => $case_id){
                $caseContents = $caseContents->where('case_id',$case_id);
                $data[$case_id] = $caseContents;
            }
            dd($data[1]);
            return view('testcases/index',[
                'headers' => $headers,
                'sheet' => $sheet,
                'cases' => $cases,
                'caseContents' => $caseContents
            ]);

        }


        public function create(){

            return view('testcases/create');

        }
}
