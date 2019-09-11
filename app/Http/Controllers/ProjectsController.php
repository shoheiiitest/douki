<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index(){
        $projects = new Project();
        $projects = $projects->get();
        return view('projects/index',[
            'projects' => $projects
        ]);
    }
}
