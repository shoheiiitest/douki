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
            $contents = array();
            foreach ($caseIds as $key => $case_id){
                $data[$case_id] = $caseContents->where('case_id',$case_id)->get();
                foreach($data[$case_id] as $k => $item){
                    $contents[$case_id][$item->header_id] = $item->content;
                }
            }
//           dd($contents);

            return view('testcases/index',[
                'headers' => $headers,
                'sheet' => $sheet,
                'cases' => $cases,
                'caseContents' => $contents
            ]);

        }


        public function create(){

            return view('testcases/create');

        }

        public function getItems($project_id,$sheet_id){
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
            $contents = array();
            foreach ($caseIds as $key => $case_id){
                $data[$case_id] = $caseContents->where('case_id',$case_id)->get();
                foreach($data[$case_id] as $k => $item){
                    $contents[$case_id][$item->header_id] = $item->content;
                }
            }

            $response = [
                'headers' => $headers,
                'sheet' => $sheet,
                'cases' => $cases,
                'caseContents' => $contents
            ];

            return response()->json($response);


        }

        public function submit(Request $request)
        {
            $data = $request->all();
            //$CaseContents = new CaseContent();
            DB::beginTransaction();
            try {

                foreach ($data['caseContents'] as $case_id => $contents) {
                    foreach ($contents as $header_id => $c) {
                        $CaseContent = CaseContent::query()
                            ->where('case_id',$case_id)
                            ->where('header_id',$header_id)
                            ->first();
                        $CaseContent->content = $c;
                        $CaseContent->save();
                        if(!$CaseContent->save()){
                            DB::rollBack();
                            return response()->json([
                                'success' => false,
                            ]);
                        }

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
}
