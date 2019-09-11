<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sheet;

class SheetsController extends Controller
{
    public function index($project_id){
        $sheets = new Sheet();
        $sheets = $sheets->where('project_id',$project_id)->get();
        return view('sheets/index',[
            'project_id' => $project_id,
            'sheets' => $sheets
        ]);
    }
}
