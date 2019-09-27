<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CaseContent extends Model
{
    protected $table = "m_case_contents";
    protected $fillable = [
        'id',
        'project_id',
        'header_id',
        'sheet_id',
        'case_id',
    ];

//    public function getCaseContents($caseIds){
//        $data =  DB::table('m_case_contents')
//            ->whereIn('m_case_contents.case_id',$caseIds)
//            ->get();
//        return $data;
//    }

    public function getCaseContents($project_id,$sheet_id){
        $data =  DB::table('m_case_contents')
                ->leftJoin('m_cases','m_cases.id','m_case_contents.case_id')
                ->leftJoin('m_sheets','m_sheets.id','m_cases.sheet_id')
                ->leftJoin('m_headers', function ($join) {
                    $join->on('m_headers.project_id','m_case_contents.project_id')
                        ->where('m_headers.id', '=', 'm_case_contents.header_id');
                })
                ->orderBy('m_case_contents.case_id','asc')
                ->orderBy('m_cases.case_no','asc')
                ->orderBy('m_headers.id')
            ->get();
            return $data;
    }
}
