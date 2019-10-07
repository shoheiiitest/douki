<?php

namespace App\Exports;

use App\Sheet;
use App\Cases;
use App\CaseContent;
use App\Header;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($project_id,$sheet_id)
    {
        $this->project_id = $project_id;
        $this->sheet_id = $sheet_id;
        $this->col_name = \App\Header::where('project_id',$project_id)->where('disp_flg',1)->orderBy('order_num','asc')->pluck('col_name')->toArray();
        $this->header = new Header();
        $this->sheet = new Sheet();
        $this->case = new Cases();
        $this->case_contents = new CaseContent();
    }

//    public function collection()
//    {
//        return new Sheet([
//            [1,2,5]
//        ]);
////        return \App\Sheet::select("sheet_name")->get()->toArray();
//    }


    /**
     * @return array
     */
    public function headings(): array
    {
////        $ret = [];
////        foreach($this->header as $i => $v){
////            $ret[] = $v['col_name'];
//        }
        return $this->col_name;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $caseIds = \App\Cases::where('sheet_id',$this->sheet_id)->orderBy('case_no','asc')->pluck('id')->toArray();
        $ret = [];
        $headerIds = \App\Header::where('project_id',$this->project_id)->where('disp_flg',1)->orderBy('order_num','asc')->pluck('id')->toArray();
        foreach ($caseIds as $index => $case_id){
            foreach ($headerIds as $i => $header_id){
                $case_content = $this->case_contents->where('case_id',$case_id)->where('header_id',$header_id)->pluck('content')->toArray();
                $ret[$index][$i] = $case_content[0];
            }
        }
        return [$ret];
    }
}
