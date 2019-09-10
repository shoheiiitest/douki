<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Sheet extends Model
{
    protected $table = "m_sheets";

    public function getSheet($project_id,$id){
        $data = DB::table('m_sheets')
            ->where('m_sheets.id',$id)
            ->where('m_sheets.project_id',$project_id)
            ->first();
        return $data;
    }
}
