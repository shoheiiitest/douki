<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cases extends Model
{
    protected $table = "m_cases";
    protected $fillable = [
        'id',
        'project_id',
        'sheet_id',
        'sheet_no',
        'case_no',
    ];

    public function getCases($sheet_id){
    $data =  DB::table('m_cases')
            ->where('m_cases.sheet_id',$sheet_id)
            ->orderBy('m_cases.case_no','asc')
            ->get();
    return $data;
}
}
