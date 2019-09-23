<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Header extends Model
{
    protected $table = "m_headers";
    protected $fillable = [
        'id',
        'project_id',
        'col_name',
        'disp_flg',
    ];

    public function getHeaders($project_id){
        $data = DB::table('m_headers')
            ->where('m_headers.project_id', '=', $project_id)
            ->where('m_headers.disp_flg', '=', '1')
            ->orderBy('order_num','asc')
            ->get();
        return $data;
    }
}
