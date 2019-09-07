<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestcasesController extends Controller
{
        public function index(){

            return view('testcases/index');

        }


        public function create(){

            return view('testcases/create');

        }
}
