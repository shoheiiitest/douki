<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sheet;
use App\Header;

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

    public function create($project_id){
        return view('sheets/create',[
            'project_id' => $project_id,
        ]);
    }

    public function getHeaders($project_id){
        $headers = new Header();
        $headers = $headers->where('project_id',$project_id)->orderBy('id','asc')->get();
        $returnHeaders = [];
        for ($i=0; $i<count($headers); $i++){
            $returnHeaders[$i] = $headers[$i]->col_name;
        }

        return response()->json([
            'headers' => $returnHeaders,
            'success' => true,
        ]);
    }
}
